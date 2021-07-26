<?php

namespace olan\roundcubeemailandcontacts\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%roundcube_user}}".
 *
 * @property int $id
 * @property int $user_id HH User ID, Foreign key references user.id
 * @property string $email Email to login to Akaunting
 * @property string $enc_password Encrypted Password to login to Akaunting
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class RoundcubeUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%roundcube_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'email', 'enc_password'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
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
            'user_id' => 'User',
            'email' => 'Email',
            'enc_password' => 'Password',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function configured($user_id)
    {
        return ((self::findOne(['user_id' => $user_id])) ? true : false);
    }
}
