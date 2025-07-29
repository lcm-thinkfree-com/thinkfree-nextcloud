<?php
namespace OCA\Thinkfree\Controller;

use OCA\Thinkfree\Crypt;
use OCP\AppFramework\Controller;
use OCP\IConfig;
use OCP\IRequest;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;
use OCP\AppFramework\Http\Attribute\PublicPage;
use OCP\AppFramework\Http\DataResponse;
use OCP\Files\IRootFolder;
use OCP\AppFramework\Http\Response;
use OCP\AppFramework\Http\DataDownloadResponse;
use OCP\IAppConfig;
use OC\Security\Crypto;

class FileController extends Controller {
	private IConfig $config;
	private IRootFolder $rootFolder;
	private IAppConfig $appConfig;
	private Crypto $crypto;

	public function __construct(IRequest $request, IConfig $config, IRootFolder $rootFolder, IAppConfig $appConfig, Crypto $crypto) {
		parent::__construct('thinkfree', $request);
		$this->config = $config;
		$this->appConfig = $appConfig;
		$this->crypto = $crypto;
		$this->rootFolder = $rootFolder;
	}

	/**
	 * @param string $userId
	 * @param string $docId
	 * @param string $hash
	 */
	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[PublicPage]
	public function info(string $userId, string $docId, string $hash): DataResponse {
		try {
			$crypt = $this->createJwtCrypt();
			$usrId = $crypt->getJwtClaim($hash, 'sub');

			if ($usrId !== $userId) {
				return new DataResponse([
					'error' => 'Unauthorized: mismatched userId'
				], 401);
			}

			$userFolder = $this->rootFolder->getUserFolder($userId);
			$files = $userFolder->getById($docId);

			$file = $files[0];

			return new DataResponse([
				'userId' => $userId,
				'docId' => $docId,
				'size' => $file->getSize(),
				'mtime' => $file->getMTime(),
				'exists' => !empty($file)
			]);

		} catch (\Throwable $e) {
			return new DataResponse([
				'error' => 'Exception: ' . $e->getMessage()
			], 400);
		}
	}

	/**
	 * @param string $userId
	 * @param string $path
	 */
	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[PublicPage]
	public function get(string $userId, string $docId, string $hash) {
		try {
			$crypt = $this->createJwtCrypt();
			$usrId = $crypt->getJwtClaim($hash, 'sub');

			if ($usrId !== $userId) {
				return new DataResponse([
					'error' => 'Unauthorized: mismatched userId'
				], 401);
			}


			$userFolder = $this->rootFolder->getUserFolder($userId);
			$files = $userFolder->getById($docId);
			$file = $files[0];

			if (empty($files)) {
				throw new \Exception("File not found");
			}

			$filename = $file->getName();
			$mimeType = $file->getMimeType();

			$response = new DataDownloadResponse($file->getContent(), $filename, $mimeType);
			$response->addHeader('Content-Length', $file->getSize());

			return $response;
		} catch (\Throwable $e){
			return new DataResponse([
				'success' => false,
				'message' => $e->getMessage()
			], 500);
		}
	}



	/**
	 * Save file from adapter via PUT request
	 *
	 * @param string $userId
	 * @param string $path
	 */
	#[NoCSRFRequired]
	#[NoAdminRequired]
	#[PublicPage]
	public function put(string $userId, string $docId, string $hash): Response {
		try {
			$crypt = $this->createJwtCrypt();
			$usrId = $crypt->getJwtClaim($hash, 'sub');

			if ($usrId !== $userId) {
				return new DataResponse([
					'error' => 'Unauthorized: mismatched userId'
				], 401);
			}

			$userFolder = $this->rootFolder->getUserFolder($userId);
			$files = $userFolder->getById($docId);

			$file = $files[0];
			$in = fopen('php://input', 'rb');
			$out = $file->fopen('w');

			while (!feof($in)) {
				fwrite($out, fread($in, 8192));
			}

			fclose($in);
			fclose($out);

			$response = new \OCP\AppFramework\Http\Response();
			$response->setStatus(204);
			return $response;
		} catch (\Throwable $e) {
			$response = new \OCP\AppFramework\Http\Response();
			$response->setStatus(500);
			return $response;
		}
	}

	private function createJwtCrypt(): Crypt {
		$appKey = $this->crypto->decrypt($this->appConfig->getValue('thinkfree', 'appKey'));

		if (empty($appKey)) {
			throw new \RuntimeException('App key is not configured');
		}

		$secret = hash('sha256', $appKey);
		return new Crypt($secret);
	}
}
