@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12" id="corePane">
            <app-del-admin :appdels="{{$appdels}}"></app-del-admin>
        </div>
    </div>
</div>
@endsection
