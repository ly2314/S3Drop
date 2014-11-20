<?php
/*
    Code by ly2314
    https://www.ly2314.cc
*/

    function getUsername($token)
    {
        include(app_path().'/views/common/config.php');
        $response = file_get_contents($token_server.'show_profile?access_token='.$token);
        if($response === false)
        {
            return NULL;
        }
        else
        {
            $response = json_decode($response, true);
            return $response['name'];
        }
    }

    function checkToken($token)
    {
        include(app_path().'/views/common/config.php');
        $response = file_get_contents($token_server.'show_profile?access_token='.$token);
        if($response === false)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    function getUserInfo($token)
    {
        include(app_path().'/views/common/config.php');
        $response = file_get_contents($token_server.'show_profile?access_token='.$token);
        if($response === false)
        {
            return NULL;
        }
        else
        {
            $response = json_decode($response, true);
            $return = array(
                    'display_name' => $response['name'],
                    'quota' => $response['storage(MB)'] * 1024 * 1024,
                    'email' => $response['email']
                );
            return $return;
        }
    }
?>