@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12" id="corePane">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Time</th>
                            <th>Available</th>
                            <th>Delete</th>
                        </tr>
                        @foreach ($lunchSlots as $lunchSlot)
                            <tr>
                                <td>{{ $lunchSlot->time }}</td>
                                <td><input type="text" class="form-control" placeholder="{{ $lunchSlot->available }}"></td>
                                <td>
                                    No
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="7">
                            <button type="submit" class="btn btn-primary" id="updateusers">Apply Changes</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>
</div>
@endsection
