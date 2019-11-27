@extends('layouts.app')

@section('content')

    <rota :LunchSlots="{{ $lunchSlots }}" @auth :loggedin="true" @endauth></rota>
@endsection
