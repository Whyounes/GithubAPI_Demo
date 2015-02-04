@extends('layouts.master')

@section('content')
    <div class="list-group">
        @foreach($authorizations as $authorization)
            <a class="list-group-item" target="_blank" href="{{ $authorization['app']['url'] }}">
                <h4 class="list-group-item-heading">{{ $authorization['app']['name'] }}</h4>
                <p class="list-group-item-text">{{ $authorization['app']['url'] }}</p>
            </a>
        @endforeach
    </div>
@endsection