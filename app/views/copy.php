<?php
/*
    Code by ly2314
    https://www.ly2314.cc
*/
    require_once app_path().'/views/common/form_validator.php';

    try
    {
        $object = $s3client->getObject(array(
                'Bucket' => $bucket_name,
                'Key' => $username.$from,
            ));

        if ($object['ContentLength'] == '0')
        {
            $obj = $s3client->listObjects(array(
                    'Bucket' => $bucket_name,
                    'Prefix' => $username.$from,
                ));
            foreach ($obj['Contents'] as $bobject)
            {
                $to = str_replace($from, $pwd, $bobject['Key']);
                $result = $s3client->copyObject(array(
                        'Bucket'     => $bucket_name,
                        'Key'        => $to,
                        'CopySource' => urlencode($bucket_name.'/'.$bobject['Key']),
                        'ContentType'=> $object['ContentType'],
                    ));
            }
        }
        else
        {
            $result = $s3client->copyObject(array(
                    'Bucket'     => $bucket_name,
                    'Key'        => $username.$pwd,
                    'CopySource' => urlencode($bucket_name.'/'.$username.$from),
                    'ContentType'=> $object['ContentType'],
                ));
        }
    }
    catch(Exception $ex)
    {
        App::abort(404, 'File Not Found');
    }

    require_once app_path().'/views/metadata.php';
?>