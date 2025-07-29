<?php

namespace OCA\Thinkfree\Settings;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\IL10N;
use OCP\Settings\IIconSection;
use OCP\Settings\ISettings;

class ThinkfreePersonal implements ISettings {
	/** @var IL10N */
	private $l10n;


	public function __construct(IL10N $l10n) {
		$this->l10n = $l10n;
	}

	public function getForm() {
		$parameters = [];

		$response = new TemplateResponse('thinkfree', 'personal', $parameters, '');

		return $response;
	}

	/**
	 * @return string
	 */
	public function getSection() {
		return 'thinkfree';
	}

	/**
	 * @return int
	 */
	public function getPriority() {
		return 11;
	}
}
