<?php

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

Route::get('/', ['uses' => 'GithubController@index', 'as' => 'index']);

Route::get('/finder', ['uses' => 'GithubController@finder', 'as' => 'finder']);

Route::get('/edit', ['uses' => 'GithubController@edit', 'as' => 'edit_file']);

Route::post('/update', ['uses' => 'GithubController@update', 'as' => 'update_file']);

Route::get('/commits', ['uses' => 'GithubController@commits', 'as' => 'commits']);

Route::get('/authorizations', ['uses' => 'GithubController@authorizations', 'as' => 'authorizations']);


// Github Webhooks part
Route::post('/events', ['uses' => 'GithubController@storeEvents']);

Route::get('/reports/contributions.json', ['uses' => 'GithubController@contributionsJson']);

Route::get('/reports/contributions', ['uses' => 'GithubController@contributions']);
