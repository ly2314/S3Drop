<?php
/*
    Code by ly2314
    https://www.ly2314.cc
*/
    // Include
    require_once app_path().'/../vendor/aws-lib/aws-autoloader.php';
    use Aws\Common\Aws;
    require_once app_path().'/views/common/config.php';
    require_once app_path().'/views/common/token.php';

    // Global Variables
    $aws = Aws::factory(app_path().'/views/common/aws_api_credential.php');
    $s3client = $aws->get('s3');
    $bucket_name = $config_BUCKET;
    $username = '';
    $token = '';

    // Helper Functions
    function startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }

    function endsWith($haystack, $needle)
    {
        return $needle === "" || substr($haystack, - strlen($needle)) === $needle;
    }
    
    function getItemMetadata($s3client, $bucket_name, $key)
    {
        $object = $s3client->getObject(array(
                'Bucket' => $bucket_name,
                'Key' => $key,
            ));
        return $object;
    }

    function isImage($path)
    {
        try
        {
            $a = getimagesize($path);
            $image_type = $a[2];
            if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
            {
                return true;
            }
            return false;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    // Check if access token is in header.
    $headers = getallheaders();
    if (array_key_exists('Authorization', $headers))
    {
        $token = $headers['Authorization'];
        $token = str_replace('Bearer ', '', $token);
    }
    else
    {
        App::abort(400, 'Required Header Missing');
    }

    // Check if user token is valid.
    if (checkToken($token) == true)
    {
        $username = getUsername($token);
        try
        {
            $object = $s3client->getObject(array(
                    'Bucket' => $bucket_name,
                    'Key' => $username.'/',
                ));
        }
        catch (Exception $ex)
        {
            $result = $s3client->putObject(array(
                    'Bucket'       => $bucket_name,
                    'Key'          => $username.'/',
                    'Body'         => '',
                ));
        }
    }
    else
    {
        App::abort(401, 'Invalid Token');
    }
?>