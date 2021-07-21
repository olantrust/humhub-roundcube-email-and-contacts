<?php
/**
 * Copy this file as is into your roundcube directory
 *
 * 1. This file helps us to setup auth between HH and Roundcube
 */

define('HTTP_SECURE_KEY', 'asdfasdfasdf');

setcookie('auth_from_hh', 'yes', time(), '/', '');

/**
 * When calling from Humhub we need to set cookie
 */
if(!empty($_GET) && !empty($_GET['auth_token']))
{
    $cookie_params = decrypt($_GET['auth_token'], HTTP_SECURE_KEY);

    if(!empty($cookie_params))
    {
        parse_str($cookie_params, $cookies);

        if(!empty($cookies) && is_array($cookies))
        {
            foreach($cookies as $cookie_name => $cookie_value)
            {
                // echo $cookie_name . '<br />';
                setcookie($cookie_name, $cookie_value, 0, '/', '');
            }

            setcookie('auth_from_hh', 'yes', 0, '/', '');
        }
    }

    unset($_GET['auth_token']);
    // exit;
}

function decrypt($msg_encrypted_bundle, $password)
{
    $password      = sha1($password);

    $components    = explode( ':', $msg_encrypted_bundle );
    $iv            = $components[0];
    $salt          = hash('sha256', $password.$components[1]);
    $encrypted_msg = $components[2];

    $decrypted_msg = openssl_decrypt($encrypted_msg, 'aes-256-cbc', $salt, null, $iv);

    if ( $decrypted_msg === false )
        return false;

    $msg = substr($decrypted_msg, 41 );

    return $decrypted_msg;
}

// echo 'index.php?' . http_build_query($_GET);
return header('Location: ' . 'index.php?' . http_build_query($_GET));
// exit;

// if(!empty($_GET) && !empty($_GET['roundcube_sessauth']) && !empty($_GET['roundcube_sessid']))
// {
//     $set_cookie_for = ['roundcube_sessauth', 'roundcube_sessid'];

//     foreach($_GET as $cookie_name => $cookie_value)
//     {
//         if(in_array($cookie_name, $set_cookie_for))
//         {
//             // echo $cookie_name;
//             setcookie($cookie_name, $cookie_value, 0, '/', '');
//         }
//     }

//     unset($_GET['roundcube_sessauth']);
//     unset($_GET['roundcube_sessid']);
// }