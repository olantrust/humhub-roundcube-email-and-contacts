<?php

namespace olan\roundcube\controllers;

use Yii;
use humhub\modules\admin\components\Controller;
use olan\roundcube\models\RoundcubeSetup;

class AdminController extends Controller
{

    /**
     * Render admin only page
     *
     * @return string
     */
    public function actionIndex()
    {
        $module = Yii::$app->getModule('roundcube');

        $model = new RoundcubeSetup();

        // Save data
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->view->saved();
            return $this->redirect(['index']);
        }

        $model->rc_url  =  $module->settings->get('rc_url');

        return $this->render('index', [
            'model' => $model
        ]);
    }

}

