@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-6 order-lg-1" id="corePane">
            <form method="post" id="userAdmin">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Admin</th>
                            <th>Expired</th>
                            <th>New Password</th>
                        </tr>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input position-static" type="checkbox" checked="{{ $user->admin }}">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>
                                    <input type="password" class="form-control" name="password9" id="password9">
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
            </form>
            <div class="col" id="error2">
            </div>
        </div>

        <div class="col-lg-6 order-lg-2">
            <form method="post" action="{{ route('storeuser') }}">
                @csrf
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>
                                <label for="name">Name:</label>
                            </td>
                            <td>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                        <tr>
                            <td>
                                <label for="username">Email:</label>
                            </td>
                            <td>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="password">Password:</label>
                            </td>
                            <td>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                                @error('currentpassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="confpass">Confirm Password:</label>
                            </td>
                            <td>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                            <button type="submit" class="btn btn-primary" name="register" id="register">Register</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>


    </div>
</div>
@endsection
