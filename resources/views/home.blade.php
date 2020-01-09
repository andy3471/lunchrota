@extends('layouts.app')

@section('content')
    <rota
        :LunchSlots="{{ $lunchSlots }}"
        :initiallunch="{{ $initialSlot }}"
        @if( config('app.roles_enabled') )
            :rolesenabled="true"
        @endif
        @auth
            :loggedin="true"
        @endauth
    >
    </rota>
@endsection
