<?php

namespace olan\roundcube\controllers;

use Yii;
use olan\roundcube\components\RoundCubeAutoLogin;
use olan\roundcube\helpers\RoundcubeUrl;
use olan\roundcube\helpers\Security;
use olan\roundcube\models\RoundcubeSpace;

class InboxSpaceController extends \humhub\modules\content\components\ContentContainerController
{
    // public function beforeAction($action)
    // {
    //     $space = $this->contentContainer;

    //     $model = RoundcubeSpace::findOne(['space_id' => $space->id]);

    //     if(empty($model))
    //     {
    //         // $this->view->saved();
    //         $this->view->warn(Yii::t('RoundcubeModule.base', 'Please set your email configuration'));
    //         return $this->redirect($space->createUrl('/roundcube/roundcube-settings-space'));
    //     }

    //     return parent::beforeAction($action);
    // }

    public function checkRcConfiguration($space)
    {
        $configured = RoundcubeSpace::configured($space->id);

        if(!$configured)
        {
            if($space->isAdmin())
            {
                // $this->view->saved();
                $this->view->warn(Yii::t('RoundcubeModule.base', 'Please set your email configuration'));
                return $this->redirect($space->createUrl('/roundcube/roundcube-settings-space'));
            }
            else //if(!$space->isAdmin())
            {
                return $this->redirect($space->createUrl('/roundcube/inbox-space/config-required'));
            }
        }
    }

    public function actionIndex()
    {
        $space  = $this->contentContainer;
        $this->checkRcConfiguration($space);

        $rc_url = RoundcubeUrl::inbox();
        $model  = RoundcubeSpace::findOne(['space_id' => $space->id]);

        if(!empty($model))
        {
            $rc = new RoundCubeAutoLogin(RoundcubeUrl::get());
            $cookies = $rc->login($model->email, $model->enc_password);
            if (!empty($cookies))
            {
                $rc_url =  RoundcubeUrl::inbox($cookies);
            }
        }

        // $rc = new RoundCubeAutoLogin(RoundcubeUrl::get());

        return $this->render('index', [
            'space'  => $space,
            'rc_url' => $rc_url,
        ]);
    }

    public function actionContact()
    {
        $space = $this->contentContainer;
        $this->checkRcConfiguration($space);
        $rc_url = RoundcubeUrl::contact();
        $model  = RoundcubeSpace::findOne(['space_id' => $space->id]);

        if(!empty($model))
        {
            $rc = new RoundCubeAutoLogin(RoundcubeUrl::get());
            $cookies = $rc->login($model->email, $model->enc_password);

            if (!empty($cookies))
            {
                $rc_url =  RoundcubeUrl::contact($cookies);
            }
        }

        return $this->render('index', [
            'space'  => $space,
            'rc_url' => $rc_url
        ]);
    }

    public function actionCompose()
    {
        $space = $this->contentContainer;
        $this->checkRcConfiguration($space);
        $rc_url = RoundcubeUrl::compose();
        $model  = RoundcubeSpace::findOne(['space_id' => $space->id]);

        if(!empty($model))
        {
            $rc = new RoundCubeAutoLogin(RoundcubeUrl::get());
            $cookies = $rc->login($model->email, $model->enc_password);

            if (!empty($cookies))
            {
                $rc_url =  RoundcubeUrl::compose($cookies);
            }
        }

        return $this->render('index', [
            'space'  => $space,
            'rc_url' => $rc_url
        ]);
    }

    public function actionConfigRequired()
    {
        return $this->render('auto-login');
    }

    // public function actionAutoLogin()
    // {
    //     $rc = new RoundCubeAutoLogin(RoundcubeUrl::get());
    //     // $cookies = $rc->login('developers@digitize-info', 'digi!@#$%tize');
    //     // $rc = new RoundCubeAutoLogin('https://mail.olan.net');
    //     $cookies = $rc->login('user@olan.uk', 'Vijay1Ro!undcube??');
    //     // $cookies = $rc->login('vijay@olan.uk', 'Vijay1234!');

    //     if (!empty($cookies))
    //     {
    //         // echo RoundcubeUrl::inbox($cookies);
    //         // exit;
    //         return $this->redirect(RoundcubeUrl::inbox($cookies));
    //     }

    //     return $this->render('auto-login', [
    //         // 'space'  => $space,
    //         // 'rc_url' => RoundcubeUrl::contact()
    //     ]);
    // }
}
