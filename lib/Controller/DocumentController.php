<?php
namespace OCA\Thinkfree\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\Controller;
use OCP\Files\IRootFolder;
use OCP\IUserSession;
use OCP\IL10N;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;

class DocumentController extends Controller {
    private $userFolder;
    private $userId;
    private $l10n;


    public function __construct(
        string $appName,
        IRequest $request,
        IRootFolder $rootFolder,
        IUserSession $userSession,
        IL10N $l10n,
    ) {
        parent::__construct($appName, $request);
        $this->userId = $userSession->getUser()->getUID();
        $this->userFolder = $rootFolder->getUserFolder($this->userId);
        $this->l10n = $l10n;

    }

	#[NoCSRFRequired]
	#[NoAdminRequired]
    public function create(): JSONResponse {

        try {
            $type = $this->request->getParam('type');
            $path = $this->request->getParam('path');

            if (!$type) {
                return new JSONResponse(['error' => 'type 파라미터가 필요합니다'], 400);
            }

            // 파일객체 생성
            $fileInfo = $this->getFileInfo($type);
            if (!$fileInfo) {
                return new JSONResponse(['error' => '지원되지 않는 파일 타입: ' . $type], 400);
            }

            // 경로 존재 여부에 따른 처리
            $targetFolder = $this->userFolder;

            if ($path && $path !== '/') {
                $path = trim($path, '/');

                if (!$this->userFolder->nodeExists($path)) {
                    $targetFolder = $this->userFolder->newFolder($path);
                } else {
                    $targetFolder = $this->userFolder->get($path);
                }
            }

            $filename = $this->generateUniqueFilename($fileInfo['baseName'], $fileInfo['extension'], $targetFolder);
            $file = $targetFolder->newFile($filename);
            $content = $this->loadTemplateContent($fileInfo['templatePath']);
            $file->putContent($content);

			$userFolderPath = $this->userFolder->getPath();
			$relativePath = ltrim(str_replace($userFolderPath, '', $file->getPath()), '/');
			$directory = dirname($relativePath);

			return new JSONResponse([
				'basename' => $filename,
				'fileid' => $file->getId(),
				'mime' => $file->getMimeType(),
				'type' => 'file',
				'path' => $directory,
				'source' => $relativePath,
				'mtime' => $file->getMTime(),
				'size' => $file->getSize()
			]);

			return new JSONResponse($responseData);
        } catch (\Exception $e) {
            return new JSONResponse(['error' => '파일 생성 실패'], 500);
        }
    }

    private function getFileInfo(string $type): ?array {
        $locale = $this->l10n->getLanguageCode() ?? 'en';
        $fileTypes = [
            'excel' => [
                'baseName' => $this->l10n->t('New Excel Document'),
                'extension' => '.xlsx',
                'template' => 'new.xlsx'
            ],
            'word' => [
                'baseName' => $this->l10n->t('New Word Document'),
                'extension' => '.docx',
                'template' => 'new.docx'
            ],
            'presentation' => [
                'baseName' => $this->l10n->t('New Presentation Document'),
                'extension' => '.pptx',
                'template' => 'new.pptx'
            ]
        ];

        $info = $fileTypes[$type] ?? null;
        if ($info) {
            $info['templatePath'] = __DIR__ . "/../../assets/doc_templates/{$locale}/{$info['template']}";
        }

        return $info;
    }

    private function loadTemplateContent(string $templatePath): string {
        if (!file_exists($templatePath)) {
            $defaultPath = __DIR__ . "/../../assets/doc_templates/en/" . basename($templatePath);
            if (!file_exists($defaultPath)) {
                // TODO. 관련 메시지를 위한 locale 리소스 정의필요.
                throw new \Exception("템플릿 파일을 찾을 수 없습니다: {$templatePath}");
            }
            $templatePath = $defaultPath;
        }

        return file_get_contents($templatePath);
    }

	private function generateUniqueFilename(string $baseName, string $extension, \OCP\Files\Folder $targetFolder): string {
		$filename = $baseName . $extension;
		$counter = 1;
		while ($targetFolder->nodeExists($filename)) {
			$filename = $baseName . ' (' . $counter . ')' . $extension;
			$counter++;
		}
		return $filename;
	}
}
