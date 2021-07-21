<?php

use olan\roundcube\Events;
use humhub\modules\admin\widgets\AdminMenu;
use humhub\modules\space\modules\manage\widgets\DefaultMenu;
use humhub\modules\space\widgets\HeaderControlsMenu;
use humhub\modules\space\widgets\Menu;
use humhub\modules\user\widgets\AccountMenu;
use humhub\modules\user\widgets\ProfileMenu;
use humhub\widgets\TopMenu;

return [
	'id' => 'roundcube',
	'class' => 'olan\roundcube\Module',
	'namespace' => 'olan\roundcube',
	'events' => [
		// ['class' => TopMenu::class, 'event' => TopMenu::EVENT_INIT, 'callback' => [Events::class, 'onTopMenuInit']],
		['class' => AdminMenu::class, 'event' => AdminMenu::EVENT_INIT, 'callback' => [Events::class, 'onAdminMenuInit']],

		// Configuration for space
		['class' => HeaderControlsMenu::class, 'event' => HeaderControlsMenu::EVENT_INIT, 'callback' => [Events::class, 'onSpaceHeaderControlsMenu']],
		['class' => DefaultMenu::class, 'event' => DefaultMenu::EVENT_INIT, 'callback' => [Events::class, 'onSpaceDefaultMenu']],
		['class' => Menu::class, 'event' => Menu::EVENT_INIT, 'callback' => [Events::class, 'onSpaceMenuInit']],

		// Configuration for user
		['class' => AccountMenu::class, 'event' => AccountMenu::EVENT_INIT, 'callback' => [Events::class, 'onAccountMenuInit']],
		['class' => ProfileMenu::class, 'event' => ProfileMenu::EVENT_INIT, 'callback' => [Events::class, 'onProfileMenuInit']],
	],
];
