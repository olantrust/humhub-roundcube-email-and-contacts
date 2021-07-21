<?php

namespace olan\roundcube\controllers;

use olan\roundcube\components\RoundCubeAutoLogin;
use olan\roundcube\helpers\RoundcubeUrl;
use olan\roundcube\models\RoundcubeUser;
use Yii;

/**
 * Thorugh this we are mapping Humhub space with akaunting
 */
class RoundcubeSettingsUserController extends \humhub\modules\user\components\BaseAccountController
{
    public function actionIndex()
    {
        // $space = $this->contentContainer;
        $user = Yii::$app->user->getIdentity();

        $model = RoundcubeUser::findOne(['user_id' => $user->id]);

        if(empty($model))
        {
            $model = new RoundcubeUser();
            $model->user_id = $user->id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->view->saved();
            return $this->redirect(['index']);
        }

        // $rc_url = Yii::$app->getModule('roundcube')->settings->get('rc_url');

        return $this->render('index', [
            'user'   => $user,
            'model'  => $model,
            // 'rc_url' => $rc_url
        ]);
    }


    public function actionEmailSetting()
    {
        $user   = Yii::$app->user->getIdentity();
        $rc_url = RoundcubeUrl::setting();

        $configured = RoundcubeUser::configured($user->id);
        if(!$configured)
        {
            $this->view->warn(Yii::t('RoundcubeModule.base', 'Please set your email configuration'));
            return $this->redirect(['/roundcube/roundcube-settings-user/index']);
        }

        $rc_url = RoundcubeUrl::setting();
        $model  = RoundcubeUser::findOne(['user_id' => $user->id]);

        if(!empty($model))
        {
            $rc = new RoundCubeAutoLogin(RoundcubeUrl::get());
            $cookies = $rc->login($model->email, $model->enc_password);
            if (!empty($cookies))
            {
                $rc_url =  RoundcubeUrl::setting($cookies);
            }
        }


        return $this->render('email-setting', [
            'rc_url' => $rc_url,
        ]);
    }
}
