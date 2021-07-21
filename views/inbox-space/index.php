<?php
use yii\web\View;
?>

<!-- <div class="panel panel-default">
    <div class="panel-heading text-center">Work in progress - Inbox for space</div>
</div> -->

<iframe id="roudcube_space_iframe" src="<?= $rc_url ?>" frameborder="0" style="height:100%;width:100%;border-radius:4px"></iframe>

<?php // to resize iframe base on document height
if(is_file(Yii::getAlias('@themes') . '/' . $this->theme->name . '/views/layouts/_iframe_resize.php'))
{
    echo $this->render('@themes' . '/' . $this->theme->name . '/views/layouts/_iframe_resize', ['ID_iframe' => 'roudcube_space_iframe']);
}