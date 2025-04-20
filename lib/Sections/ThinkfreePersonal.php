<?php

namespace OCA\Thinkfree\Sections;

use OCP\IL10N;
use OCP\Settings\IIconSection;
use OCP\IURLGenerator;

class ThinkfreePersonal implements IIconSection {
	/** @var IL10N */
	private $l10n;
	private $urlGenerator;

	public function __construct(IL10N $l10n, IURLGenerator $urlGenerator) {
		$this->l10n = $l10n;
		$this->urlGenerator = $urlGenerator;
	}

	/**
	 * @return string
	 */
	public function getID() {
		return 'thinkfree';
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->l10n->t('Thinkfree Office');
	}

	/**
	 * @return int
	 */
	public function getPriority() {
		return 99;
	}

	/**
	 * @return string|null
	 */
	public function getIcon() {
		return $this->urlGenerator->imagePath('thinkfree', 'app-dark.svg');
	}
}
