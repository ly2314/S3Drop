<?php
/*
    Code by ly2314
    https://www.ly2314.cc
*/
    require_once app_path().'/views/common/form_validator.php';

    $result = $s3client->putObjectAcl(array(
        'ACL' => 'private',
        'Bucket' => $bucket_name,
        'Key' => $username.$pwd,
    ));

    require_once app_path().'/views/metadata.php';
?>