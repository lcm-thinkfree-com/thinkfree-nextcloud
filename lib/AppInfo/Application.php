<?php

declare(strict_types=1);

namespace OCA\Thinkfree\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\Util;
use OCP\EventDispatcher\IEventDispatcher;
use OCA\Files\Event\LoadAdditionalScriptsEvent;
use OCP\AppFramework\Http\ContentSecurityPolicy;

class Application extends App implements IBootstrap {
	public const APP_ID = 'thinkfree';

	public function __construct(array $urlParams = []) {
		parent::__construct(self::APP_ID, $urlParams);
	}

	public function boot(IBootContext $context): void {
        $eventDispatcher = $context->getServerContainer()->get(IEventDispatcher::class);

        $eventDispatcher->addListener(LoadAdditionalScriptsEvent::class, function() {
            Util::addScript(self::APP_ID, 'editor.bundle');
        });
		$eventDispatcher->addListener(LoadAdditionalScriptsEvent::class, function() {
			Util::addScript(self::APP_ID, 'src/main');
		});
	}
}
