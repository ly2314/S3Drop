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
        try // Add '/' in the tail of the path to check if pwd is a folder.
        {
            $pwd = $pwd.'/';
            $object = $s3client->getObject(array(
                    'Bucket' => $bucket_name,
                    'Key' => $username.$pwd,
                ));
        }
        catch(Exception $e)
        {
            App::abort(404, 'File Not Found');
        }
    }
    if (endsWith($pwd, '/')) // If pwd is a folder.
    {
        if (!endsWith($pwd, '/'))
            $pwd = $pwd.'/';
        $bucket_objects = $s3client->listObjects(array(
            'Bucket' => $bucket_name,
            'Prefix' => $username.$pwd
        ));
        $content = array();
        if (isset($bucket_objects['Contents']))
        {
            foreach ($bucket_objects['Contents'] as $bobject)
            {
                $fld = substr($bobject['Key'], strlen($username.$pwd));
                if (substr_count($fld, '/') < 1 || (substr_count($fld, '/') == 1 && endsWith($bobject['Key'], '/')))
                {
                    if (endsWith($bobject['Key'], '/'))
                    {
                        if (substr($bobject['Key'], strpos($bobject['Key'], $username) + strlen($username)) != $pwd)
                        {
                            $item_data = getItemMetadata($s3client, $bucket_name, $bobject['Key']);
                            $item = array(
                                    'bytes' => $bobject['Size'],
                                    'modified' => $bobject['LastModified'],
                                    'path' => substr($bobject['Key'], strpos($bobject['Key'], $username) + strlen($username)),
                                    'mime_type' => $item_data['ContentType'],
                                    'Expires' => $object['Expires'],
                                    'is_dir' => 'true',
                                );
                            array_push($content, $item);
                        }
                        else
                        {
                            continue;
                        }
                    }
                    else
                    {
                        $item_data = getItemMetadata($s3client, $bucket_name, $bobject['Key']);
                        $item = array(
                                'bytes' => $bobject['Size'],
                                'modified' => $bobject['LastModified'],
                                'path' => substr($bobject['Key'], strpos($bobject['Key'], $username.$pwd) + strlen($username)),
                                'mime_type' => $item_data['ContentType'],
                                'Expires' => $object['Expires'],
                                'is_dir' => 'false',
                            );
                        array_push($content, $item);
                    }
                }
            }
        }
        $response = array(
                'bytes' => $object['ContentLength'],
                'modified' => $object['LastModified'],
                'path' => $pwd,
                'mime_type' => $object['ContentType'],
                'is_dir' => true,
                'Expires' => $object['Expires'],
                'contents' => $content,
            );
        echo json_encode($response);
    }
    else // If pwd is not a folder.
    {
        $response = array(
                'bytes' => $object['ContentLength'],
                'modified' => $object['LastModified'],
                'path' => $pwd,
                'mime_type' => $object['ContentType'],
                'Expires' => $object['Expires'],
                'is_dir' => false,
            );
        echo json_encode($response);
    }
?>