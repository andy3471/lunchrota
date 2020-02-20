@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 order-lg-2 center">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th colspan="2">
                            <h4 id="date" class="text-center">About</h4>
                        </th>
                    </tr>
                    <tr>
                        <td style="width:25%">
                            Created By:
                        </td>
                        <td>
                            Andrew Hargrave + Curtis Reet
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Created Using:
                        </td>
                        <td>
                            Laravel 6, Vue JS, HTML5, Bootstrap 4, PHP, JavaScript and MySQL.
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Local Admins:
                        </td>
                        <td>
                            @foreach($admins as $admin)
                                {{ $loop->first ? '' : ', ' }}
                                @if($admin->meme)
                                    <a href='{{$admin->meme}}' class="meme">{{$admin->name}}</a>
                                @else
                                    {{$admin->name}}
                                @endif
                                    
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td>Version:</td>
                        <td>{{ config('app.version') }}</td>
                    </tr>
                    <tr>
                        <td>GitHub:</td>
                        <td><a href="https://github.com/andy3471/rota">Github</a></td>
                    </tr>
                    <tr>
                        <td>Report an issue:</td>
                        <td><a href="https://github.com/andy3471/lunchrota/issues/new/choose">Report Issue</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
