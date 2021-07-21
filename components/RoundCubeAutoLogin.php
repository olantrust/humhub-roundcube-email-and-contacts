<?php

namespace olan\roundcube\components;

use Yii;
use Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class to automatically login on a Roundcube installation
 * @compatibility RoundCube 1.0.2+
 */

// a roundcube exception class
class RoundCubeException extends Exception {}

// main class
class RoundCubeAutoLogin
{
    // roundcube link (with a trailing slash)
    private $_rc_link = '';

    private $ch;

    /**
     * Creates a new RC object
     * @param $roundcube_link the roundcube link with a trailing slash
     */
    public function __construct($roundcube_link)
    {
        $this->_rc_link = $roundcube_link;
        $this->ch = curl_init();
    }

    /**
     * Tries to log a RC user in using cURL. Does two requests. One to
     * get a session token to perform the login, and one to do the actual
     * login of the user
     *
     * @param $email the full e-mailaddress of the user
     * @param $password the password of the user
     *
     * @returns The cookies you should set with setcookie
     */
    public function login($email, $password)
    {
        try
        {
            $token = $this->_get_token();

            if($token === FALSE)
            {
                Yii::error('Unable to get token, is your RC link correct?');
                // throw new RoundCubeException('Unable to get token, is your RC link correct?');
            }

            // make the request to roundcube
            $post_params = [
                '_token' => $token,
                '_task' => 'login',
                '_action' => 'login',
                '_timezone' => '',
                '_url' => '_task=login',
                '_user' => $email,
                '_pass' => $password
            ];

            // $timeout = 30;
            // $http = new \Zend\Http\Client($this->_rc_link . '?_task=login', [
            //     'useragent'   => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.146 Safari/537.36',
            //     'adapter'     => '\Zend\Http\Client\Adapter\Curl',
            //     'curloptions' => ArrayHelper::merge(\humhub\libs\CURLHelper::getOptions(), [
            //         CURLOPT_COOKIEFILE => '',
            //         CURLOPT_COOKIEJAR  => ''
            //     ]),
            //     'timeout'    => $timeout
            // ]);

            // $http->request('POST', $this->_rc_link . '?_task=login', $post_params);

            // $http->setMethod(\Zend\Http\Request::METHOD_POST);
            // $http->setRawBody(http_build_query($post_params));

            // $send = $http->send();
            // $response = $send->getBody();

            // echo '<pre>';
            // print_r($response);
            // print_r($send->getCookie());
            // exit;


            curl_setopt($this->ch, CURLOPT_URL, $this->_rc_link . '?_task=login');
            curl_setopt($this->ch, CURLOPT_COOKIEFILE, '');
            curl_setopt($this->ch, CURLOPT_COOKIEJAR, '');
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, CURLPROTO_HTTP | CURLPROTO_HTTPS);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, CURLPROTO_HTTP | CURLPROTO_HTTPS);
            curl_setopt($this->ch, CURLOPT_POST, TRUE);
            curl_setopt($this->ch, CURLOPT_HEADER, TRUE);
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($post_params));
            $response = curl_exec($this->ch);
            $response_info = curl_getinfo($this->ch);

            preg_match_all('/Set-Cookie: (.*)\b/', $response, $cookies);

            // echo '<pre>';
            // print_r($response);
            // print_r($response_info);
            // exit;

            Yii::warning('cookie info ' . Json::encode($response_info));

            if($response_info['http_code'] == 302)
            {
                // find all relevant cookies to set (php session + rc auth cookie)
                preg_match_all('/Set-Cookie: (.*)\b/i', $response, $cookies);

                $cookie_return = array();

                foreach($cookies[1] as $cookie)
                {
                    preg_match('|([A-z0-9\_]*)=([A-z0-9\_\-]*);|', $cookie, $cookie_match);
                    if($cookie_match) {
                        $cookie_return[$cookie_match[1]] = $cookie_match[2];
                    }
                }

                return $cookie_return;
            }
            else
            {
                Yii::error('Login failed, please check your credentials.');
                // throw new RoundCubeException('Login failed, please check your credentials.');
            }

        }
        catch(RoundCubeException $e)
        {
            Yii::error('RC error: ' . $e->getMessage());
            // echo 'RC error: ' . $e->getMessage();
        }
        catch(Exception $e)
        {
            Yii::error('General error: ' . $e->getMessage());
            // echo 'General error: ' . $e->getMessage();
        }
    }

    /**
     * Redirect to RC
     */
    public function redirect()
    {
        header('Location: ' . $this->_rc_link . '?task=mail');
    }

    /**
     * Gets a token to use for the login
     */
    private function _get_token($timeout = 30)
    {
        // $http = new \Zend\Http\Client($this->_rc_link, [
        //     'useragent'   => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.146 Safari/537.36',
        //     'adapter'     => '\Zend\Http\Client\Adapter\Curl',
        //     'curloptions' => ArrayHelper::merge(\humhub\libs\CURLHelper::getOptions(), [
        //         CURLOPT_COOKIEFILE => '',
        //         CURLOPT_COOKIEJAR  => ''
        //     ]),
        //     'timeout'    => $timeout
        // ]);

        // $send = $http->send();
        // $response = $send->getBody();

        curl_setopt($this->ch, CURLOPT_URL, $this->_rc_link);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($this->ch, CURLOPT_COOKIEFILE, '');
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, '');
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, CURLPROTO_HTTP | CURLPROTO_HTTPS);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, CURLPROTO_HTTP | CURLPROTO_HTTPS);
        $response = curl_exec($this->ch);

        preg_match('|<input type="hidden" name="_token" value="([A-z0-9]*)">|', $response, $matches);

        // echo '<pre>';
        // // echo $this->_rc_link;
        // print_r($matches);
        // exit;

        if($matches)
        {
            Yii::warning('RC token: ' . Json::encode($matches));

            return $matches[1];
        }
        else {
            return FALSE;
        }
    }
}

/*
 include this HTML form in you page and point it to your script location

<form action="http://domain.com/roundcube/RoundcubeAutoLogin.php" method="post" name="autologin">
  UserID <input name="rc_user" type="text" id="rc_user">
  Passwort <input name="rc_pass" type="password" id="rc_pass">
  <input type="submit" name="Submit" value="login">
</form>

*/

// send parameters with post, its more secure because username and password not shown in browser and logfile
// $rcuser=$_REQUEST['rc_user'];
// $rcpass=$_REQUEST['rc_pass'];


// // set your roundcube domain path
// $rc = new RoundcubeAutoLogin('http://domain.com/roundcube/');
// $cookies = $rc->login($rcuser, $rcpass);

// // now you can set the cookies with setcookie php function, or using any other function of a framework you are using
// if (!empty($cookies))
// {
//     foreach($cookies as $cookie_name => $cookie_value)
//     {
//         setcookie($cookie_name, $cookie_value, 0, '/', '');
//     }
//     // and redirect to roundcube with the set cookies
//     $rc->redirect();
// }

?>
