<?php

use humhub\widgets\Button;

// Register our module assets, this could also be done within the controller
\olan\roundcube\assets\Assets::register($this);

$displayName = (Yii::$app->user->isGuest) ? Yii::t('RoundcubeEmailAndContactsModule.base', 'Guest') : Yii::$app->user->getIdentity()->displayName;

// Add some configuration to our js module
$this->registerJsConfig("roundcube", [
    'username' => (Yii::$app->user->isGuest) ? $displayName : Yii::$app->user->getIdentity()->username,
    'text' => [
        'hello' => Yii::t('RoundcubeEmailAndContactsModule.base', 'Hi there {name}!', ["name" => $displayName])
    ]
])

?>

<div class="panel-heading"><strong>Roundcube</strong> <?= Yii::t('RoundcubeEmailAndContactsModule.base', 'overview') ?></div>

<div class="panel-body">
    <p><?= Yii::t('RoundcubeEmailAndContactsModule.base', 'Hello World!') ?></p>

    <?=  Button::primary(Yii::t('RoundcubeEmailAndContactsModule.base', 'Say Hello!'))->action("roundcube.hello")->loader(false); ?></div>
