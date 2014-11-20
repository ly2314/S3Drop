<?php
/*
    Code by ly2314
    https://www.ly2314.cc
*/
    require_once app_path().'/views/common/form_validator.php';

    $result = $s3client->putObjectAcl(array(
        'ACL' => 'public-read',
        'Bucket' => $bucket_name,
        'Key' => $username.$pwd,
    ));

    $plainUrl = $s3client->getObjectUrl($bucket_name, $username.$pwd);
    $response = array(
        "url" => $plainUrl,
        "expires"=> "Tue, 01 Jan 2030 00:00:00 +0000"
    );

    echo json_encode($response);
?>