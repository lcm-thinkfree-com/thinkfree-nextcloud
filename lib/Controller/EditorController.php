<?php

declare(strict_types=1);

namespace OCA\Thinkfree\Controller;

use OCP\AppFramework\Controller;
use OCP\IRequest;
use OCP\IConfig;
use OCP\IL10N;
use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;

class EditorController extends Controller {
    private IConfig $config;
    private $l10n;

    public function __construct($appName, IRequest $request,  IConfig $config, IL10N $l10n) {
        parent::__construct($appName, $request);
        $this->config = $config;
        $this->l10n = $l10n;
    }

    #[NoCSRFRequired]
    public function open(): JSONResponse {
        // TODO.
        // 1. Login이 안된경우 직접 로그인 페이지로 redirect 시켜야함.
        // 2. 권한이 있는 사용자인지 여부를 확인
        // 3. 에러 다이얼로그에 대한 리소스 관리 추가. ex) Not permitted to open the document.

		try {
			$locale = $this->l10n->getLanguageCode() ?? 'en';
			$adapterName = 'nc';

			$serverAddress = rtrim($this->config->getAppValue('thinkfree', 'serverAddress', 'http://localhost:8080/'), '/') . '/';
			// TODO. JWT 또는 암복호화 코드 필요.
			$appKey = $this->getAppKey();

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

	private function getAppKey(): string {
		$appKey = base64_encode($this->config->getAppValue('thinkfree', 'appKey', ''));
		return rtrim(strtr($appKey, '+/', '-_'), '=');
	}
}
