<?php
declare(strict_types=1);

namespace OCA\Thinkfree\Controller;

use OCP\AppFramework\Controller;
use OCP\IRequest;
use OCP\IConfig;
use OCP\IUserSession;
use OCP\IL10N;
use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;
use OCA\Thinkfree\Crypt;
use OCP\IAppConfig;
use OC\Security\Crypto;


require_once __DIR__ . '/../../vendor/autoload.php';

class EditorController extends Controller {
    private IConfig $config;
	private IAppConfig $appConfig;
	private Crypto $crypto;
	private IUserSession $userSession;
    private $l10n;

    public function __construct($appName, IRequest $request,  IConfig $config, IL10N $l10n, IUserSession $userSession, IAppConfig $appConfig, Crypto $crypto) {
        parent::__construct($appName, $request);
        $this->config = $config;
		$this->appConfig = $appConfig;
		$this->crypto = $crypto;
		$this->userSession = $userSession;
        $this->l10n = $l10n;
    }

	#[NoCSRFRequired]
	#[NoAdminRequired]
    public function open(): JSONResponse {
		if (!\OC_User::isLoggedIn()) {
			return new JSONResponse(['error' => 'Not logged in'], 401);
		}

		try {
			$user = $this->userSession->getUser();
			if (!$user) {
				return new DataResponse(['error' => 'Unauthorized'], Http::STATUS_UNAUTHORIZED);
			}
			$userId = $user->getUID();

			$locale = $this->l10n->getLanguageCode() ?? 'en';
			$adapterName = 'nc';

			$serverAddressRaw = $this->config->getUserValue($userId, 'thinkfree', 'serverAddress', 'https://nextcloud.thinkfree.com/');
			$serverAddress = empty($serverAddressRaw) ? 'https://nextcloud.thinkfree.com/' : $serverAddressRaw;
			if (!preg_match('#^https?://#i', $serverAddress)) {
				$serverAddress = 'http://' . $serverAddress;
			}
			$serverAddress = rtrim($serverAddress, '/') . '/';

			$appKey = $this->crypto->decrypt($this->appConfig->getValue('thinkfree', 'appKey'));
			$secret = hash('sha256', $appKey);
			$crypt = new Crypt($secret);

			$payload = [
				'jti' => bin2hex(random_bytes(16)),
				'sub' => $userId,
				'iss' => 'Connector',
				'aud' => 'WebOffice',
				'exp' => time() + 60 * 60 * 48,
			];
			$jwt = $crypt->createToken($payload);

			return new JSONResponse(
				['status' => 'success',
					'domain' => $serverAddress . 'cloud-office/api/' . $adapterName,
					'lang' => $locale,
					'appKey' => $jwt
				]);
		} catch (\Exception $e) {
			return new JSONResponse(['error' => '파일 열기 실패: ' . $e->getMessage()], 500);
		}
    }
}
