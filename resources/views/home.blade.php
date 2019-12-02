@extends('layouts.app')

@section('content')
    <rota
        :LunchSlots="{{ $lunchSlots }}"
        {{-- :initialLunch="{{ $selectedLunch }}" --}}
        @if( config('app.roles_enabled') )
            :rolesenabled="true"
        @endif
        @auth
            :loggedin="true"
        @endauth
    >
    </rota>
@endsection
