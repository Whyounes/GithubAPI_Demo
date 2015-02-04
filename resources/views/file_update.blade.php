@extends('layouts.master')

@section('content')
    <ol class="breadcrumb">
        <li><a href="{{ $file['download_url'] }}" target="_blank">Download</a></li>
        <li><a href="{{ $file['html_url'] }}" target="_blank">View file</a></li>
    </ol>

    {!! Form::open(['url' => '/update', 'method' => 'POST']) !!}
        <input name="path" value="{{ $path }}" type="hidden"/>
        <input name="repo" value="{{ $repo }}" type="hidden"/>
        <div class="form-group">
            <label for="content">File content:</label>
            <textarea class="form-control" name="content" id="content" cols="30" rows="10">{{ $content }}</textarea>
        </div>

        <div class="form-group">
            <label for="commit">Commit message:</label>
            <input class="form-control" type="text" id="commit" name="commit" value="{{ $commitMessage }}"/>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary btn-control" value="Submit" />
        </div>
    {!! Form::close() !!}
@endsection
