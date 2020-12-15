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
            @if( Auth::user()->app_del )
                :appdel=true
            @endif
            @if ($available)
                :available=true
            @endif
        @endauth
    >
    </rota>
@endsection
