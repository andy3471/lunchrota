@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 order-lg-1">
                Please download the export. Once edited, you can upload it to override all roles in bulk <br>
            </div>
            <div class="col-lg-4 order-lg-2" id="corePane">
                <a href="{{ route('downloadcsv') }}"> Download All Current Data </a>
            </div>
            <div class="col-xl-4 order-xl-3" id="corePane">
                @error('csv')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <form action="{{ route('uploadcsv') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    Select amended export:
                    <input type="file" name="csv" id="csv">
                    <input type="submit" value="Upload CSV" name="submit">
                </form>
            </div>
        </div>


        @isset ($messages)
            {{$messages}}
        @endisset
    </div>
@endsection
