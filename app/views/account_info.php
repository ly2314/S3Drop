<?php
/*
    Code by ly2314
    https://www.ly2314.cc
*/
    require_once app_path().'/views/common/form_validator.php';

    // Get object metadata.
    $bucket_objects = $s3client->listObjects(array(
        'Bucket' => $config_BUCKET,
        'Prefix' => $username,
    ));

    $used = 0;
    foreach ($bucket_objects['Contents'] as $bobject)
    {
        $used += $bobject['Size'];
    }

    $response = getUserInfo($token);

    $return = array(
        'display_name' => $response['display_name'],
        'email' => $response['email'],
        'quota_info' => array(
            'quota' => $response['quota'],
            'normal' => $used,
        ),
    );
    echo json_encode($return);
?>