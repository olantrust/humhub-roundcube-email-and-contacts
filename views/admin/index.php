<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$link = '<div class="input-group-addon">Please Insert Link</div>';
if(!empty($model->rc_url))
{
    $link = "<div class='input-group-addon'>". Html::a('View <i class="fa fa-external-link"></i>', $model->rc_url, ['target' => '_blank']) . "</div>";
}

?>
<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading"><strong><?= Yii::t('RoundcubeEmailAndContactsModule.base', 'Roundcube') ?></strong> <?= Yii::t('RoundcubeEmailAndContactsModule.base', 'configuration') ?></div>

        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'rc_url', [
                        'template' => "{label}\n<div class='input-group'>{input}
                            " . $link . "</div>\n{hint}\n{error}"
                    ])->textInput(['maxlength' => true])->label('Roundcube URL (for use with Email and Contacts modules)'); ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('FinanceModule.base', 'Save'), ['class' => 'btn btn-success']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>