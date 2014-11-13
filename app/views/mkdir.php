<?php
/*
    Code by ly2314
    https://www.ly2314.cc
*/
    require_once app_path().'/views/common/form_validator.php';

    $result = $s3client->putObject(array(
        'Bucket'       => $bucket_name,
        'Key'          => $username.$pwd,
        'Body'         => '',
    ));
    
    require_once app_path().'/views/metadata.php';
?>