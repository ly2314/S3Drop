<?php
/*
    Code by ly2314
    https://www.ly2314.cc
*/
    require_once app_path().'/views/common/form_validator.php';

    $request = Request::instance();
    $content = $request->getContent();
    if (isset($expires))
    {
        $result = $s3client->putObject(array(
            'Bucket'       => $bucket_name,
            'Key'          => $username.$pwd,
            'Body'         => $content,
            'Expires'      => $expires,
        ));
    }
    else
    {
        $result = $s3client->putObject(array(
            'Bucket'       => $bucket_name,
            'Key'          => $username.$pwd,
            'Body'         => $content,
        ));
    }

    require_once app_path().'/views/metadata.php';
?>