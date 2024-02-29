@extends('layouts.app')

@section('content')
    <rota-page
        :lunch-slots="{{ $lunchSlots }}"
        :initial-lunch="{{ $initialSlot }}"
        @if( config('app.roles_enabled') )
            roles-enabled
        @endif
        @auth
            logged-in
            @if ($available)
                available
            @endif
        @endauth
    >
    </rota-page>
@endsection
