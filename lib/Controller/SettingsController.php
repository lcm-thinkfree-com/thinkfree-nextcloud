<?php

namespace OCA\Thinkfree\Controller;

use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;
use OCP\IRequest;
use OCP\IConfig;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;

class SettingsController extends Controller {
    private IConfig $config;

    public function __construct(IRequest $request, IConfig $config, $appName) {
        $this->config = $config;
        parent::__construct('thinkfree', $request);
    }

	#[NoCSRFRequired]
	#[NoAdminRequired]
    public function get(): DataResponse {
        $serverAddress = $this->config->getAppValue('thinkfree', 'serverAddress', '');
        $appKey = $this->config->getAppValue('thinkfree', 'appKey', '');
        return new DataResponse([
            'serverAddress' => $serverAddress,
            'appKey' => $appKey,
        ]);
    }

    #[NoCSRFRequired]
    #[NoAdminRequired]
    public function set(): DataResponse {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['serverAddress'])) {
            $this->config->setAppValue('thinkfree', 'serverAddress', $data['serverAddress']);
        }
        if (isset($data['appKey'])) {
            $this->config->setAppValue('thinkfree', 'appKey', $data['appKey']);
        }

        return new DataResponse(['status' => 'success']);
    }
}
