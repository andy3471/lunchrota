@extends('layouts.app')

@section('content')
    <user-role-admin :users="{{$users}}" :roles="{{$roles}}"></role-admin>
@endsection
