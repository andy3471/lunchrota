@extends('layouts.app')

@section('content')
<role-admin :users="{{$users}}" :roles="{{$roles}}"></role-admin>
@endsection
