<?php

namespace olan\roundcubeemailandcontacts\models;

use Yii;

/**
 * Model class to save Akaunting Setting.
 */
class RoundcubeSetup extends \humhub\models\Setting
{
    var $rc_url;

    /**
     * Define Validation rules
     */
    public function rules()
    {
        return [
            [['rc_url'], 'required'],
            // ['API_url', 'url', 'defaultScheme' => 'https']
        ];
    }

    /**
     * Label values
     */
    public function attributeLabels()
    {
        return [
            'rc_url'  => 'Roundcube URL',
            // 'API_user' => 'Username',
            // 'API_pass' => 'Password',
        ];
    }

    public function attributeHints()
    {
        return [
            'rc_url'  => 'Provide Base URL of Roundcube setup.',
            // 'API_user' => 'Akaunting setup Username (with API role enabled)',
            // 'API_pass' => 'Password of Akaunting user',
        ];
    }

    /**
     * Save the value in database
     */
    public function save($runValidation = true, $attributeNames = NULL)
    {
        $module = Yii::$app->getModule('roundcube-email-and-contacts');

        $module->settings->set('rc_url', $this->rc_url);

        return true;
    }

    /**
     * Get Value for the given key
     * @param string $key
     * @return string|null
     */
    public static function getValue($key)
    {
        return Yii::$app->getModule('roundcube-email-and-contacts')->settings->get($key);
    }

}