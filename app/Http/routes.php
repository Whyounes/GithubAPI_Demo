<?php

use App\Hook;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

/*
Route::get('/', ['uses' => 'GithubController@index', 'as' => 'index']);

Route::get('/finder', ['uses' => 'GithubController@finder', 'as' => 'finder']);

Route::get('/edit', ['uses' => 'GithubController@edit', 'as' => 'edit_file']);

Route::post('/update', ['uses' => 'GithubController@update', 'as' => 'update_file']);

Route::get('/commits', ['uses' => 'GithubController@commits', 'as' => 'commits']);

Route::get('/authorizations', ['uses' => 'GithubController@authorizations', 'as' => 'authorizations']);
*/

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

Route::post('/events', ['uses' => 'GithubController@storeEvents']);

Route::get('/dump', function () {
  $hooks = Hook::all(['payload']);

  $hooks->each(function ($item) {
    $json = json_decode($item['payload']);

    dump($json);
  });

  return "";
});


Route::get('/reports/contributions.json', function () {
  $hooks = Hook::where('event_name', '=', 'push')->get(['payload']);

  $users = [];
  $hooks->each(function ($item) use (&$users) {
    $item = json_decode($item['payload']);

    $pusherName = $item->pusher->name;
    $commitsCount = count($item->commits);

    $users[$pusherName] = array_pull($users, $pusherName, 0) + $commitsCount;
  });


  return $users;
});

Route::get('/reports/contributions', function () {
  $hooks = Hook::where('event_name', '=', 'push')->get(['payload']);

  $hooks->each(function ($item) {
    $item = json_decode($item['payload']);

    $commitsCount = count($item->commits);

    (new Symfony\Component\VarDumper\VarDumper())->dump(['pusher' => $item->pusher, 'count' => $commitsCount]);
    //$users[$pusherName] = (isset($users[$pusherName]) ?: 0) + $commitsCount;
  });

  //return View::make('reports.contributions');
});
