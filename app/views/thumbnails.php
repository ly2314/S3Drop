<?php
/*
    Code by ly2314
    https://www.ly2314.cc
*/
    require_once app_path().'/views/common/form_validator.php';
    require_once app_path().'/views/common/config.php';

    $acl = '';
    try
    {
        $result = $s3client->putObjectAcl(array(
            'ACL' => 'public-read',
            'Bucket' => $bucket_name,
            'Key' => $username.$pwd,
        ));
    }
    catch(Exception $ex)
    {
        App::abort(404, 'File Not Found');
    }

    $plainUrl = $s3client->getObjectUrl($bucket_name, $username.$pwd);
    $plainUrl = str_replace('https://', 'http://', $plainUrl);

    $ffmpeg = $ffmpeg_path;
    $video  = $plainUrl;
    $image  = tempnam(sys_get_temp_dir(), "s3d").'.jpg';
    $second = 1;
    $cmd = "$ffmpeg -i $video 2>&1";
    if (preg_match('/Duration: ((\d+):(\d+):(\d+))/s', `$cmd`, $time)) {
        $total = ($time[2] * 3600) + ($time[3] * 60) + $time[4];
        if ($total > 5)
            $total = 5;
        $second = rand(1, ($total - 1));
    }
    $cmd = "$ffmpeg -i $video -deinterlace -an -ss $second -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $image 2>&1";
    $return = `$cmd`;

    $result = $s3client->putObjectAcl(array(
        'ACL' => 'private',
        'Bucket' => $bucket_name,
        'Key' => $username.$pwd,
    ));

    if (isImage($image))
    {
        header("Content-Type: image/jpg");
        readfile($image);
        exit;
    }
    else
    {
        App::abort(400, 'Invalid input');
    }
?>