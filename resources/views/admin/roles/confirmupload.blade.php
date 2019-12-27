@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        @foreach($messages as $message)
            <div class="alert alert-{{$message['type']}}" role="alert">
                {{$message['message']}}
            </div>
        @endforeach
    </div>
@endsection
