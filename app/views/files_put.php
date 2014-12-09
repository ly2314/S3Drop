<?php
/*
    Code by ly2314
    https://www.ly2314.cc
*/
    require_once app_path().'/views/common/form_validator.php';

    $request = Request::instance();
    $content = $request->getContent();
    $temp_pwd = $pwd;
    if (!endsWith($pwd, '/'))
    {
        $pwd = substr($pwd, 0, strrpos($pwd, '/') + 1);
    }
    while ($pwd != '/')
    {
        $result = $s3client->putObject(array(
            'Bucket'       => $bucket_name,
            'Key'          => $username.$pwd,
            'Body'         => '',
        ));
        $pwd = substr($pwd, 0, strrpos($pwd, '/', -2) + 1);
    }
    $pwd = $temp_pwd;
    if (isset($expires))
    {
        $result = $s3client->putObject(array(
            'Bucket'       => $bucket_name,
            'Key'          => $username.$pwd,
            'Body'         => $content,
            'Expires'      => $expires,
            'ContentType'  => Request::header('Content-Type')
        ));
    }
    else
    {
        $result = $s3client->putObject(array(
            'Bucket'       => $bucket_name,
            'Key'          => $username.$pwd,
            'Body'         => $content,
            'ContentType'  => Request::header('Content-Type')
        ));
    }

    require_once app_path().'/views/metadata.php';
?>