<?php namespace App\Http\Controllers;

use App\Hook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

class GithubController extends Controller
{

  private $client;

  /*
   * Github username
   *
   * @var string
   * */
  private $username;

  public function __construct(\Github\Client $client)
  {
    $this->client = $client;
    $this->username = env('GITHUB_USERNAME');
  }

  public function index()
  {
    try {
      $repos = $this->client->api('current_user')->repositories();

      return View::make('repos', ['repos' => $repos]);
    } catch (\RuntimeException $e) {
      $this->handleAPIException($e);
    }
  }//index

  public function finder()
  {
    $repo = Input::get('repo');
    $path = Input::get('path', '.');

    try {
      $result = $this->client->api('repo')->contents()->show($this->username, $repo, $path);

      return View::make('finder', ['parent' => dirname($path), 'repo' => $repo, 'items' => $result]);
    } catch (\RuntimeException $e) {
      $this->handleAPIException($e);
    }
  }//finder

  public function edit()
  {
    $repo = Input::get('repo');
    $path = Input::get('path');

    try {
      $file = $this->client->api('repo')->contents()->show($this->username, $repo, $path);

      $content = base64_decode($file['content']);
      $commitMessage = "Updated file " . $file['name'];

      return View::make('file_update', [
          'file'          => $file,
          'path'          => $path,
          'repo'          => $repo,
          'content'       => $content,
          'commitMessage' => $commitMessage
      ]);
    } catch (\RuntimeException $e) {
      $this->handleAPIException($e);
    }
  }//edit

  public function update()
  {
    $repo = Input::get('repo');
    $path = Input::get('path');
    $content = Input::get('content');
    $commit = Input::get('commit');

    try {
      $oldFile = $this->client->api('repo')->contents()->show($this->username, $repo, $path);
      $result = $this->client->api('repo')->contents()->update(
          $this->username,
          $repo,
          $path,
          $content,
          $commit,
          $oldFile['sha']
      );

      return \Redirect::route('commits', ['path' => $path, 'repo' => $repo]);
    } catch (\RuntimeException $e) {
      $this->handleAPIException($e);
    }
  }//update

  public function commits()
  {
    $repo = Input::get('repo');
    $path = Input::get('path');

    try {
      $commits = $this->client->api('repo')->commits()->all($this->username, $repo, ['path' => $path]);

      return View::make('commits', ['commits' => $commits]);
    } catch (\RuntimeException $e) {
      $this->handleAPIException($e);
    }
  }

  public function authorizations()
  {
    try {
      $authorizations = $this->client->api('authorizations')->all();

      return view('authorizations', ['authorizations' => $authorizations]);
    } catch (\RuntimeException $e) {
      $this->handleAPIException($e);
    }
  }

  public function handleAPIException($e)
  {
    dd($e->getCode() . ' - ' . $e->getMessage());
  }

  public function storeEvents(Request $request) {
    $event_name = $request->header('X-Github-Event');
    $body = json_encode(Input::all());

    $hook = new Hook;
    $hook->event_name = $event_name;
    $hook->payload = $body;

    $hook->save();

    return '';// 200 OK
  }

  public function contributionsJson(){
    $hooks = Hook::where('event_name', '=', 'push')->get(['payload']);

    $users = [];
    $hooks->each(function ($item) use (&$users) {
      $item = json_decode($item['payload']);

      $pusherName = $item->pusher->name;
      $commitsCount = count($item->commits);

      $users[$pusherName] = array_pull($users, $pusherName, 0) + $commitsCount;
    });

    return [
        'users'   => array_keys($users),
        'commits'  => array_values($users)
    ];
  }

  public function contributions(){

    return View::make('reports.contributions');
  }
}
 