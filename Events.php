<?php

namespace  olan\roundcube;

use humhub\modules\ui\menu\MenuLink;
use humhub\modules\ui\view\helpers\ThemeHelper;
use Yii;
use yii\helpers\Url;

class Events
{
    /**
     * Defines what to do when the top menu is initialized.
     *
     * @param $event
     */
    // public static function onTopMenuInit($event)
    // {
    //     $event->sender->addItem([
    //         'label' => 'Roundcube',
    //         'icon' => '<i class="fa fa-envelope-o"></i>',
    //         'url' => Url::to(['/roundcube/index']),
    //         'sortOrder' => 99999,
    //         'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'roundcube' && Yii::$app->controller->id == 'index'),
    //     ]);
    // }

    /**
     * Defines what to do if admin menu is initialized.
     *
     * @param $event
     */
    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem([
            'label'     => Yii::t('RoundcubeModule.base', 'Email and Contacts'),
            'url'       => Url::to(['/roundcube/admin']),
            'group'     => 'manage',
            'icon'      => '<i class="fa fa-users"></i>',
            'isActive'  => MenuLink::isActiveState('roundcube', 'admin'),
            'sortOrder' => 401,
        ]);
    }

    public static function onSpaceHeaderControlsMenu($event)
    {
        if($event->sender->space->isModuleEnabled('roundcube') && $event->sender->space->isAdmin())
        {
            $event->sender->addEntry(new MenuLink([
                'label'     => Yii::t('RoundcubeModule.base', 'Email & Contacts'),
                'url'       => $event->sender->space->createUrl('/roundcube/roundcube-settings-space'),
                'icon'      => 'envelope-o',
                'sortOrder' => 200,
            ]));
        }
    }

    public static function onSpaceDefaultMenu($event)
    {
        if($event->sender->space->isModuleEnabled('roundcube') && $event->sender->space->isAdmin())
        {
            $event->sender->addEntry(new MenuLink([
                'label'     => Yii::t('RoundcubeModule.base', 'Email & Contacts'),
                'url'       => $event->sender->space->createUrl('/roundcube/roundcube-settings-space'),
                // 'icon'      => 'envelope-o',
                'isActive'  => MenuLink::isActiveState('roundcube', 'roundcube-settings-space', 'index'),
                'sortOrder' => 401
            ]));

            $event->sender->addEntry(new MenuLink([
                'label'     => Yii::t('RoundcubeModule.base', 'Email Settings'),
                'url'       => $event->sender->space->createUrl('/roundcube/roundcube-settings-space/email-setting'),
                // 'icon'      => 'envelope-o',
                'isActive'  => MenuLink::isActiveState('roundcube', 'roundcube-settings-space', 'email-setting'),
                'sortOrder' => 401
            ]));
        }
    }

    public static function onSpaceMenuInit($event)
    {
        $space = $event->sender->space;

        $rc_url = Yii::$app->getModule('roundcube')->settings->get('rc_url');

        if($event->sender->space->isModuleEnabled('roundcube') && $rc_url)
        {
            // $event->sender->template = '@themes' . '/' . ThemeHelper::getThemeByName('Olan')->name . '/views/ui/menu/widgets/views/left-space-navigation.php';

            // $event->sender->addItem([
            //     'label'     => Yii::t('RoundcubeModule.base', 'Mail'),
            //     'url'       => 'javascript:void(0)', // $space->createUrl('/roundcube/inbox-space/index'),
            //     'htmlOptions' => ['onclick' => 'return false;'],
            //     'icon'      => '<i class="fa fa-envelope-o"></i>',
            //     // 'isActive'  => MenuLink::isActiveState('roundcube', 'inbox-space'),
            //     'sortOrder' => 401,
            // ]);

            $event->sender->addItem([
                'label'     => Yii::t('RoundcubeModule.base', 'Inbox'),
                'url'       => $space->createUrl('/roundcube/inbox-space/index'),
                // 'htmlOptions' => ['onclick' => 'return false;'],
                'icon'      => '<i class="fa fa-envelope"></i>',
                'isActive'  => MenuLink::isActiveState('roundcube', 'inbox-space', 'index'),
                'sortOrder' => 402,
            ]);

            $event->sender->addItem([
                'label'     => Yii::t('RoundcubeModule.base', 'Contacts'),
                'url'       => $space->createUrl('/roundcube/inbox-space/contact'),
                // 'htmlOptions' => ['mail' => 'mail'],
                'icon'      => '<i class="fa fa-group"></i>',
                'isActive'  => MenuLink::isActiveState('roundcube', 'inbox-space', 'contact'),
                'sortOrder' => 401,
            ]);

            // $event->sender->addItem([
            //     'label'     => Yii::t('RoundcubeModule.base', 'Compose'),
            //     'url'       => $space->createUrl('/roundcube/inbox-space/compose'),
            //     // 'htmlOptions' => ['mail' => 'mail'],
            //     'icon'      => '&nbsp;&nbsp;&nbsp;' . '<i class="fa fa-pencil-square"></i>',
            //     'isActive'  => MenuLink::isActiveState('roundcube', 'inbox-space', 'compose'),
            //     'sortOrder' => 403,
            // ]);

            // $event->sender->addItem([
            //     'label'     => Yii::t('RoundcubeModule.base', 'Auto Login (TEST)'),
            //     'url'       => $space->createUrl('/roundcube/inbox-space/auto-login'),
            //     'htmlOptions' => ['target' => '_blank'],
            //     'icon'      => '&nbsp;&nbsp;&nbsp;' . '<i class="fa fa-pencil-square"></i>',
            //     'isActive'  => MenuLink::isActiveState('roundcube', 'inbox-space', 'auto-login'),
            //     'sortOrder' => 403,
            // ]);
        }
    }

    public static function onAccountMenuInit($event)
    {
        $user = Yii::$app->user->getIdentity();

        // Show menu in account setting only if the module is enabled by user
        if($user->isModuleEnabled('roundcube')) //$event->sender->user->isModuleEnabled('roundcube'))
        {
            $event->sender->addEntry(new MenuLink([
                'label'     => Yii::t('RoundcubeModule.base', 'Email and Contacts'),
                'url'       => ['/roundcube/roundcube-settings-user/index'], //$event->sender->createUrl('/roundcube/roundcube-settings-space'),
                'icon'      => 'users',
                'isActive'  => MenuLink::isActiveState('roundcube', 'roundcube-settings-user', 'index'),
                'sortOrder' => 102,
            ]));

            $event->sender->addEntry(new MenuLink([
                'label'     => Yii::t('RoundcubeModule.base', 'Email Settings'),
                'url'       => ['/roundcube/roundcube-settings-user/email-setting'], //$event->sender->createUrl('/roundcube/roundcube-settings-space'),
                'icon'      => 'cog',
                'isActive'  => MenuLink::isActiveState('roundcube', 'roundcube-settings-user', 'email-setting'),
                'sortOrder' => 103,
            ]));
        }
    }

    public static function onProfileMenuInit($event)
    {
        $user = $event->sender->user;

        $rc_url = Yii::$app->getModule('roundcube')->settings->get('rc_url');

        if($user->isModuleEnabled('roundcube') && $rc_url && $user->id == Yii::$app->user->getIdentity()->id)
        {
            // $event->sender->template = '@themes' . '/' . ThemeHelper::getThemeByName('Olan')->name . '/views/ui/menu/widgets/views/left-space-navigation.php';

            // $event->sender->addItem([
            //     'label'     => Yii::t('RoundcubeModule.base', 'Mail'),
            //     'url'       => 'javascript:void(0)', // $space->createUrl('/roundcube/inbox-space/index'),
            //     'htmlOptions' => ['onclick' => 'return false;'],
            //     'icon'      => '<i class="fa fa-envelope-o"></i>',
            //     // 'isActive'  => MenuLink::isActiveState('roundcube', 'inbox-space'),
            //     'sortOrder' => 401,
            // ]);

            $event->sender->addItem([
                'label'     => Yii::t('RoundcubeModule.base', 'Inbox'),
                'url'       => $user->createUrl('/roundcube/inbox-user/index'),
                // 'htmlOptions' => ['onclick' => 'return false;'],
                'icon'      => '<i class="fa fa-envelope"></i>',
                'isActive'  => MenuLink::isActiveState('roundcube', 'inbox-user', 'index'),
                'sortOrder' => 402,
            ]);


            $event->sender->addItem([
                'label'     => Yii::t('RoundcubeModule.base', 'Contacts'),
                'url'       => $user->createUrl('/roundcube/inbox-user/contact'),
                // 'htmlOptions' => ['mail' => 'mail'],
                'icon'      => '<i class="fa fa-group"></i>',
                'isActive'  => MenuLink::isActiveState('roundcube', 'inbox-user', 'contact'),
                'sortOrder' => 401,
            ]);

            // $event->sender->addItem([
            //     'label'     => Yii::t('RoundcubeModule.base', 'Compose'),
            //     'url'       => $user->createUrl('/roundcube/inbox-user/compose'),
            //     // 'htmlOptions' => ['mail' => 'mail'],
            //     'icon'      => '&nbsp;&nbsp;&nbsp;' . '<i class="fa fa-pencil-square"></i>',
            //     'isActive'  => MenuLink::isActiveState('roundcube', 'inbox-user', 'compose'),
            //     'sortOrder' => 403,
            // ]);
        }
    }
}
