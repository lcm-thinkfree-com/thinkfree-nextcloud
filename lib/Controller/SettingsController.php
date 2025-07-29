<?php

namespace OCA\Thinkfree\Controller;

use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;
use OCP\IRequest;
use OCP\IConfig;
use OCP\IUserSession;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;
use OCP\IGroupManager;
use OCP\IAppConfig;
use OC\Security\Crypto;

class SettingsController extends Controller {
	private IConfig $config;
	private IAppConfig $appConfig;
	private IUserSession $userSession;
	private IGroupManager $groupManager;
	private Crypto $crypto;

    public function __construct(IRequest $request, IConfig $config, IAppConfig $appConfig, IUserSession $userSession, IGroupManager $groupManager, Crypto $crypto) {
		parent::__construct('thinkfree', $request);
		$this->config = $config;
		$this->appConfig = $appConfig;
		$this->userSession = $userSession;
		$this->groupManager = $groupManager;
		$this->crypto = $crypto;
	}

	#[NoCSRFRequired]
	#[NoAdminRequired]
    public function get(): DataResponse {
		$user = $this->userSession->getUser();
		if (!$user) {
			return new DataResponse(['error' => 'Unauthorized'], Http::STATUS_UNAUTHORIZED);
		}
		$userId = $user->getUID();

		$serverAddress = $this->config->getUserValue($userId, 'thinkfree', 'serverAddress', '');

		$response = [
			'serverAddress' => $serverAddress
		];

		if ($this->groupManager->isAdmin($userId)) {
        	$appKey = $this->appConfig->getValue('thinkfree', 'appKey');
			if (!empty($appKey)) {
				$response['appKey'] = str_repeat('*', 20);
			} else {
				$response['appKey'] = '';
			}
		}

        return new DataResponse($response);
    }

    #[NoCSRFRequired]
    #[NoAdminRequired]
    public function set(): DataResponse {
		$user = $this->userSession->getUser();
		if (!$user) {
			return new DataResponse(['error' => 'Unauthorized'], 401);
		}
		$userId = $user->getUID();

        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['serverAddress'])) {
            $this->config->setUserValue($userId, 'thinkfree', 'serverAddress', $data['serverAddress']);
        }
        if (isset($data['appKey'])) {
			$encryptedData = $this->crypto->encrypt($data['appKey']);
            $this->appConfig->setValue('thinkfree', 'appKey', $encryptedData);
        }

        return new DataResponse(['status' => 'success']);
    }
}
