<?php

namespace olan\roundcube\helpers;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * A helper class for different roundcube URLs
 */
class RoundcubeUrl
{
    const RC_HH_AUTH_FILENAME = 'auth_hh.php'; // roundcube auth file use to generate session cookie

    const HTTP_SECURE_KEY     = 'asdfasdfasdf'; // Make sure this key matches with the Auth file in roundcube file above

    public static function get()
    {
        // echo Yii::$app->getModule('roundcube')->settings->get('rc_url');exit;
        return Yii::$app->getModule('roundcube')->settings->get('rc_url');
    }

    /**
     * Get inbox url
     */
    public static function inbox($cookies = [])
    {
        $url_params = ['_task' => 'mail', '_mbox' => 'INBOX'];

        $return = self::get() . '?' . http_build_query($url_params);

        if(!empty($cookies))
        {
            $cookies = Security::encrypt(http_build_query($cookies), self::HTTP_SECURE_KEY);
            $url_params['auth_token'] = $cookies;

            $return = self::get() . '/' . self::RC_HH_AUTH_FILENAME . '?' . http_build_query($url_params);
        }

        return $return;
    }

    /**
     * Get contact url
     */
    public static function contact($cookies = [])
    {
        $url_params = ['_task' => 'addressbook', '_source' => '0'];

        $return = self::get() . '?' . http_build_query($url_params);

        if(!empty($cookies))
        {
            $cookies = Security::encrypt(http_build_query($cookies), self::HTTP_SECURE_KEY);
            $url_params['auth_token'] = $cookies;

            $return = self::get() . '/' . self::RC_HH_AUTH_FILENAME . '?' . http_build_query($url_params);
        }

        return $return;
    }

    /**
     * Get contact url
     */
    public static function compose($cookies = [])
    {
        $url_params = ['_task' => 'mail', '_action' => 'compose'];

        $return = self::get() . '?' . http_build_query($url_params);

        if(!empty($cookies))
        {
            $cookies = Security::encrypt(http_build_query($cookies), self::HTTP_SECURE_KEY);
            $url_params['auth_token'] = $cookies;

            $return = self::get() . '/' . self::RC_HH_AUTH_FILENAME . '?' . http_build_query($url_params);
        }

        return $return;
    }

    public static function setting($cookies = [])
    {
        $url_params = ['_task' => 'settings'];

        $return = self::get() . '?' . http_build_query($url_params);

        if(!empty($cookies))
        {
            $cookies = Security::encrypt(http_build_query($cookies), self::HTTP_SECURE_KEY);
            $url_params['auth_token'] = $cookies;

            $return = self::get() . '/' . self::RC_HH_AUTH_FILENAME . '?' . http_build_query($url_params);
        }

        return $return;
    }
}
