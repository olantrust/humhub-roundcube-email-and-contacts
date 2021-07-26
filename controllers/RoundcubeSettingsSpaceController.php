<?php

namespace olan\roundcubeemailandcontacts\controllers;

use olan\roundcubeemailandcontacts\components\RoundCubeAutoLogin;
use olan\roundcubeemailandcontacts\helpers\RoundcubeUrl;
use olan\roundcubeemailandcontacts\models\RoundcubeSpace;
use Yii;

/**
 * Thorugh this we are mapping Humhub space with akaunting
 */
class RoundcubeSettingsSpaceController extends \humhub\modules\space\modules\manage\components\Controller
{
    public function actionIndex()
    {
        $space = $this->contentContainer;

        // $link_space = AkauntingCompany::linked($space->id);

        $model = RoundcubeSpace::findOne(['space_id' => $space->id]);

        if(empty($model))
        {
            $model = new RoundcubeSpace();
            $model->space_id = $space->id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->view->saved();
            return $this->redirect($space->createUrl('/roundcube-email-and-contacts/roundcube-settings-space'));
        }


        $rc_url = Yii::$app->getModule('roundcube-email-and-contacts')->settings->get('rc_url');

        return $this->render('index', [
            'space'  => $space,
            'model'  => $model,
            // 'rc_url' => $rc_url
        ]);
    }

    public function actionEmailSetting()
    {
        $space  = $this->contentContainer;

        $configured = RoundcubeSpace::configured($space->id);
        if(!$configured)
        {
            $this->view->warn(Yii::t('RoundcubeEmailAndContactsModule.base', 'Please set your email configuration'));
            return $this->redirect($space->createUrl('/roundcube-email-and-contacts/roundcube-settings-space'));
        }

        $rc_url = RoundcubeUrl::setting();
        $model  = RoundcubeSpace::findOne(['space_id' => $space->id]);

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
            'space'  => $space,
            'rc_url' => $rc_url,
        ]);
    }
}
