<?php

namespace OCA\Thinkfree\Controller;

use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;
use OCP\IRequest;
use OCP\IConfig;
use OCP\IUserSession;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;

class SettingsController extends Controller {
    private IConfig $config;
	private IUserSession $userSession;

    public function __construct(IRequest $request, IConfig $config, IUserSession $userSession) {
        $this->config = $config;
		$this->userSession = $userSession;
        parent::__construct('thinkfree', $request);
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
        $appKey = $this->config->getUserValue($userId, 'thinkfree', 'appKey', '');
        return new DataResponse([
            'serverAddress' => $serverAddress,
            'appKey' => $appKey,
        ]);
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
            $this->config->setUserValue($userId, 'thinkfree', 'appKey', $data['appKey']);
        }

        return new DataResponse(['status' => 'success']);
    }
}
