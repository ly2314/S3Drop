<?php
/*
    Code by ly2314
    https://www.ly2314.cc
*/
    require_once app_path().'/views/common/form_validator.php';

    $response = @file_get_contents($token_server.'disable_token?access_token='.$token);
?>