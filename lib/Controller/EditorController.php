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

class EditorController extends Controller {
    private IConfig $config;
	private IUserSession $userSession;
    private $l10n;

    public function __construct($appName, IRequest $request,  IConfig $config, IL10N $l10n, IUserSession $userSession) {
        parent::__construct($appName, $request);
        $this->config = $config;
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

			$serverAddress = rtrim($this->config->getUserValue($userId, 'thinkfree', 'serverAddress', 'https://nextcloud.thinkfree.com/'), '/') . '/';
			// TODO. JWT 또는 암복호화 코드 필요.
			$appKey = $this->getAppKey($userId);

			return new JSONResponse(
				['status' => 'success',
					'domain' => $serverAddress . 'cloud-office/api/' . $adapterName,
					'lang' => $locale,
					'appKey' => $appKey
				]);
		} catch (\Exception $e) {
			return new JSONResponse(['error' => '파일 열기 실패: ' . $e->getMessage()], 500);
		}

    }

	private function getAppKey(string $userId): string {
		$appKey = base64_encode($this->config->getUserValue($userId, 'thinkfree', 'appKey', ''));
		return rtrim(strtr($appKey, '+/', '-_'), '=');
	}
}
