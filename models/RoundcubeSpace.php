<?php

namespace olan\roundcube\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%roundcube_space}}".
 *
 * @property int $id
 * @property int $space_id HH Space ID, Foreign Key reference space.id
 * @property string $email Email to login to Akaunting
 * @property string $enc_password Encrypted Password to login to Akaunting
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class RoundcubeSpace extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%roundcube_space}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['space_id', 'email', 'enc_password'], 'required'],
            [['space_id', 'created_at', 'updated_at'], 'integer'],
            [['email', 'enc_password'], 'string', 'max' => 255],

            ['email', 'email'],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'space_id' => 'Space',
            'email' => 'Email',
            'enc_password' => 'Password',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Check if Inbox is configured for space or not
     * @param integer $space_id
     * @return boolean
     */
    public static function configured($space_id)
    {
        return ((self::findOne(['space_id' => $space_id])) ? true : false);
    }
}
