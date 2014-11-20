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
            echo $pwd;
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
    
    if ($object['ContentLength'] == '0') // If pwd is a folder.
    {
        require_once app_path().'/views/metadata.php';
        return;
    }
    else // If pwd is not a folder.
    {
        $file = substr($pwd, strrpos($pwd, '/') + 1);
        header('Content-Type:'.$object["ContentType"]);
        header('Content-Disposition: attachment; filename='.$file);
        echo $object['Body'];
    }
?>