<?php

declare(strict_types=1);

namespace OCA\Thinkfree\Controller;

use OCP\AppFramework\Http;
use OCP\AppFramework\Http\Attribute\ApiRoute;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;

use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\OCSController;

class ApiController extends OCSController {
	/**
	 * An example API endpoint
	 *
	 * @return DataResponse<Http::STATUS_OK, array{message: string}, array{}>
	 *
	 * 200: Data returned
	 */
	#[NoCSRFRequired]
	#[NoAdminRequired]
	public function index(): DataResponse {
		return new DataResponse(
			['message' => 'Thinkfree API call successful']
		);
	}
}
