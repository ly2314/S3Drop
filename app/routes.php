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
    return View::make('metadata', array('pwd' => '/'.$path));
})->where('path', '(.*)');

Route::post('/fileops/delete/', function()
{
    if (Input::has('path'))
    {
        return View::make('delete', array('pwd' => Input::get('path')));
    }
    App::abort(400, 'Required Filed Missing');
});

Route::post('/files_put/{path?}', function($path = '')
{
    if (Input::has('expires'))
    {
        return View::make('files_put', array('pwd' => '/'.$path, 'expires' => Input::get('expires')));
    }
    return View::make('files_put', array('pwd' => '/'.$path));
})->where('path', '(.*)');

Route::get('/files/{path?}', function($path = '')
{
    return View::make('files', array('pwd' => '/'.$path));
})->where('path', '(.*)');;

Route::post('/fileops/copy', function()
{
    if (Input::has('from_path') && Input::has('to_path'))
    {
        return View::make('copy', array('pwd' => Input::get('to_path'), 'from' => Input::get('from_path')));
    }
    App::abort(400, 'Required Filed Missing');
});

Route::post('/fileops/move', function()
{
    if (Input::has('from_path') && Input::has('to_path'))
    {
        return View::make('move', array('pwd' => Input::get('to_path'), 'from' => Input::get('from_path')));
    }
    App::abort(400, 'Required Filed Missing');
});

Route::post('/fileops/create_folder', function()
{
    if (Input::has('path'))
    {
        return View::make('mkdir', array('pwd' => '/'.Input::get('path')));
    }
    App::abort(400, 'Required Filed Missing');
});

Route::match(array('GET', 'POST'), '/search/{path?}', function($path = '')
{
    if (Input::has('query'))
    {
        return View::make('search', array('pwd' => '/'.$path, 'query' => Input::get('query')));
    }
    App::abort(400, 'Required Filed Missing');
});

Route::post('/disable_access_token', function()
{
    return View::make('disable_token');
});

Route::get('/account/info', function()
{
    return View::make('account_info');
});

Route::post('/shares/{path?}', function($path = '')
{
    return View::make('shares', array('pwd' => '/'.$path));
})->where('path', '(.*)');

Route::get('/thumbnails/{path?}', function($path = '')
{
    return View::make('thumbnails', array('pwd' => '/'.$path));
})->where('path', '(.*)');

Route::post('/new_user', function()
{
    if (Input::has('username'))
    {
        return View::make('new_user', array('username' => Input::get('username')));
    }
    App::abort(400, 'Required Filed Missing');
});

Route::post('/unshare/{path?}', function($path = '')
{
    return View::make('unshare', array('pwd' => '/'.$path));
})->where('path', '(.*)');