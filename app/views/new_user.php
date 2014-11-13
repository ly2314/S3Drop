<?php
/*
    Code by ly2314
    https://www.ly2314.cc
*/
    require_once app_path().'/../vendor/aws-lib/aws-autoloader.php';
    use Aws\Common\Aws;
    require_once app_path().'/views/common/config.php';
    require_once app_path().'/views/common/token.php';

    $aws = Aws::factory(app_path().'/views/common/aws_api_credential.php');
    $s3client = $aws->get('s3');
    $bucket_name = $config_BUCKET;

    $result = $s3client->putObject(array(
        'Bucket'       => $bucket_name,
        'Key'          => $username.'/',
        'Body'         => '',
    ));

    echo '{status: "OK"}';
?>