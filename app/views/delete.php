<?php
/*
    Code by ly2314
    https://www.ly2314.cc
*/
    require_once app_path().'/views/common/form_validator.php';

    // Get object metadata.
    $object = '';
    try
    {
        $object = $s3client->getObject(array(
                'Bucket' => $bucket_name,
                'Key' => $username.$pwd,
            ));
    }
    catch(Exception $ex)
    {
        App::abort(404, 'File Not Found');
    }

    require_once app_path().'/views/metadata.php';
    
    if (endsWith($username.$pwd, '/')) // If pwd is a folder.
    {
        $s3client->deleteMatchingObjects($bucket_name, $username.$pwd, '(.*)', array());
    }
    else // If pwd is not a folder.
    {
        $s3client->deleteObject(array(
                'Bucket' => $bucket_name,
                'Key' => $username.$pwd,
            ));
    }
?>