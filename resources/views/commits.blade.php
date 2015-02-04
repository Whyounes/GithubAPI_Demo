@extends('layouts.master')

@section('content')
    <div class="list-group">
    @foreach($commits as $commit)
        <a class="list-group-item" target="_blank" href="{{ $commit['html_url'] }}">
            <h4 class="list-group-item-heading">{{ $commit['commit']['message'] }}</h4>
            <p class="list-group-item-text">{{ $commit['commit']['author']['name'] }}</p>
        </a>
    @endforeach
    </div>
@endsection