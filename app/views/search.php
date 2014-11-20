<?php
/*
    Code by ly2314
    https://www.ly2314.cc
*/
    require_once app_path().'/views/common/form_validator.php';

    $objects = $s3client->listObjects(array(
        'Bucket'       => $bucket_name,
        'Prefix'          => $username.$pwd,
    ));

    $response = array();

    foreach ($objects['Contents'] as $object)
    {
        $filename = substr($object['Key'], strlen($username));
        if (strpos($filename, $query) !== false)
        {
            $item_data = getItemMetadata($s3client, $bucket_name, $object['Key']);
            $item = array(
                    'bytes' => $object['Size'],
                    'modified' => $object['LastModified'],
                    'path' => $filename,
                    'mime_type' => $item_data['ContentType'],
                    'is_dir' => (endsWith($object['Key'], '/') ? 'true' : 'false'),
                );
            array_push($response, $item);
        }
    }
    
    echo json_encode($response);
?>