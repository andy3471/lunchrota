@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12" id="corePane">
            <lunch-slot-admin
                @if( config('app.lunch_slot_calculated') )
                 :lunchcalculated="true"
                @endif
            >
            </lunch-slot-admin>
        </div>
    </div>
</div>
@endsection
