<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use humhub\modules\space\modules\manage\widgets\DefaultMenu;
use humhub\widgets\Button;

// \olan\finance\assets\Assets::register($this);

?>
<div class="panel panel-default">
    <div>
        <div class="panel-heading">
            <?= Yii::t('RoundcubeModule.manage', '<strong>Email & Contacts</strong> Configuration'); ?>
        </div>
    </div>

    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'enc_password')->passwordInput() ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('RoundcubeModule.base', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>