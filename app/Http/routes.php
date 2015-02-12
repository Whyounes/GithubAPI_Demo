<?php

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

Route::get('/', ['uses' => 'GithubController@index', 'as' => 'index']);

Route::get('/finder', ['uses' => 'GithubController@finder', 'as' => 'finder']);

Route::get('/edit', ['uses' => 'GithubController@edit', 'as' => 'edit_file']);

Route::post('/update', ['uses' => 'GithubController@update', 'as' => 'update_file']);

Route::get('/commits', ['uses' => 'GithubController@commits', 'as' => 'commits']);

Route::get('/authorizations', ['uses' => 'GithubController@authorizations', 'as' => 'authorizations']);

Route::get('/docs/{filename}.html', function ($filename) {
  try {
    $path = base_path('resources/views/docs/') . $filename . '.md';
    $content = File::get($path);

    return View::make('doc', ['content' => $content]);
  } catch (FileNotFoundException $ex) {
    //return to index
    return App::abort("404");
  }

});