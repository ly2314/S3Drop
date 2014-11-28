<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*
    Code by ly2314
    https://www.ly2314.cc
*/

Route::get('/', function()
{
    return View::make('index');
});

Route::get('/metadata/{path?}', function($path = '')
{
    $pwd = '/'.$path;
    require_once app_path().'/views/metadata.php';
})->where('path', '(.*)');

Route::post('/fileops/delete/', function()
{
    $pwd = '/'.$path;
    require_once app_path().'/views/delete.php';
    App::abort(400, 'Required Filed Missing');
});

Route::post('/files_put/{path?}', function($path = '')
{
    if (Input::has('expires'))
    {
        $pwd = '/'.$path;
        $expires = Input::get('expires');
        require_once app_path().'/views/files_put.php';
    }
    else
    {
        $pwd = '/'.$path;
        require_once app_path().'/views/files_put.php';
    }
})->where('path', '(.*)');

Route::get('/files/{path?}', function($path = '')
{
    $pwd = '/'.$path;
    require_once app_path().'/views/files.php';
})->where('path', '(.*)');;

Route::post('/fileops/copy', function()
{
    if (Input::has('from_path') && Input::has('to_path'))
    {
        $pwd = Input::get('to_path');
        $from = Input::get('from_path');
        require_once app_path().'/views/copy.php';
    }
    App::abort(400, 'Required Filed Missing');
});

Route::post('/fileops/move', function()
{
    if (Input::has('from_path') && Input::has('to_path'))
    {
        $pwd = Input::get('to_path');
        $from = Input::get('from_path');
        require_once app_path().'/views/move.php';
    }
    App::abort(400, 'Required Filed Missing');
});

Route::post('/fileops/create_folder', function()
{
    if (Input::has('path'))
    {
        $pwd = '/'.Input::get('path');
        require_once app_path().'/views/mkdir.php';
    }
    App::abort(400, 'Required Filed Missing');
});

Route::match(array('GET', 'POST'), '/search/{path?}', function($path = '')
{
    if (Input::has('query'))
    {
        $pwd = '/'.$path;
        $query = Input::get('query');
        require_once app_path().'views/search.php';
    }
    App::abort(400, 'Required Filed Missing');
});

Route::post('/disable_access_token', function()
{
    require_once app_path().'views/disable_token.php';
});

Route::get('/account/info', function()
{
    require_once app_path().'views/account_info.php';
});

Route::post('/shares/{path?}', function($path = '')
{
    $pwd = '/'.$path;
    require_once app_path().'/views/shares.php';
})->where('path', '(.*)');

Route::get('/thumbnails/{path?}', function($path = '')
{
    $pwd = '/'.$path;
    require_once app_path().'/views/thumbnails.php';
})->where('path', '(.*)');

Route::post('/new_user', function()
{
    if (Input::has('username'))
    {
        $username = $username;
        require_once app_path().'/views/new_user.php';
    }
    App::abort(400, 'Required Filed Missing');
});

Route::post('/unshare/{path?}', function($path = '')
{
    $pwd = '/'.$path;
    require_once app_path().'/views/unshare.php';
})->where('path', '(.*)');