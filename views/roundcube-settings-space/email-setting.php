<?php

use humhub\modules\space\modules\manage\widgets\DefaultMenu;
use yii\web\View;

$this->registerCss('
.tab-menu .nav-tabs {margin-bottom:0}
.panel-body {padding:0 !important}
');
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('RoundcubeModule.manage', '<strong>Email & Contacts</strong> Settings'); ?>
    </div>

    <?= DefaultMenu::widget(['space' => $space]); ?>

    <div class="panel-body">
        <iframe id="roudcube_setting" src="<?= $rc_url ?>" frameborder="0" style="height:100%;width:100%;border-radius:4px;min-height:600px"></iframe>
    </div>
</div>

<?php // to resize iframe base on document height
if(is_file(Yii::getAlias('@themes') . '/' . $this->theme->name . '/views/layouts/_iframe_resize.php'))
{
    echo $this->render('@themes' . '/' . $this->theme->name . '/views/layouts/_iframe_resize', ['ID_iframe' => 'roudcube_setting']);
}