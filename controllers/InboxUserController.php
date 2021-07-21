<?php

namespace olan\roundcube\controllers;

use olan\roundcube\components\RoundCubeAutoLogin;
use Yii;
use olan\roundcube\helpers\RoundcubeUrl;
use olan\roundcube\models\RoundcubeUser;

class InboxUserController extends \humhub\modules\content\components\ContentContainerController
{
    public function beforeAction($action)
    {
        $user = $this->contentContainer;

        $model = RoundcubeUser::findOne(['user_id' => $user->id]);

        if(empty($model))
        {
            // $this->view->saved();
            $this->view->warn(Yii::t('RoundcubeModule.base', 'Please set your email configuration'));
            return $this->redirect(['/roundcube/roundcube-settings-user']);
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $user = $this->contentContainer;
        $rc_url = RoundcubeUrl::inbox();
        $model  = RoundcubeUser::findOne(['user_id' => $user->id]);

        if(!empty($model))
        {
            $rc = new RoundCubeAutoLogin(RoundcubeUrl::get());
            $cookies = $rc->login($model->email, $model->enc_password);
            if (!empty($cookies))
            {
                $rc_url =  RoundcubeUrl::inbox($cookies);
            }
        }

        return $this->render('index', [
            'user'   => $user,
            'rc_url' => $rc_url,
        ]);
    }

    public function actionCompose()
    {
        $user = $this->contentContainer;
        $rc_url = RoundcubeUrl::compose();
        $model  = RoundcubeUser::findOne(['user_id' => $user->id]);

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
            'user'   => $user,
            'rc_url' => $rc_url
        ]);
    }

    public function actionContact()
    {
        $user = $this->contentContainer;
        $rc_url = RoundcubeUrl::contact();
        $model  = RoundcubeUser::findOne(['user_id' => $user->id]);

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
            'user'   => $user,
            'rc_url' => $rc_url
        ]);
    }
}
