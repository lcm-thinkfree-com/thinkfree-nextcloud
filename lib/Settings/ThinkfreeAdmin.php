<?php

namespace OCA\Thinkfree\Settings;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\IL10N;
use OCP\Settings\ISettings;

use OCP\AppFramework\Http\EmptyContentSecurityPolicy;

class ThinkfreeAdmin implements ISettings {
    /** @var IConfig */
    private $config;

    /** @var IL10N $l*/
    private $l;

     public function __construct(IConfig $config, IL10N $l) {
        $this->config = $config;
        $this->l = $l;
    }

    public function getForm() {
        $parameters = [];

        $response = new TemplateResponse('thinkfree', 'admin', $parameters, '');
        $csp = new EmptyContentSecurityPolicy();
        $response->setContentSecurityPolicy($csp);
        
        return $response;
    }

    public function getSection() {
        return 'thinkfree';
    }

    public function getPriority() {
        return 10;
    }
}