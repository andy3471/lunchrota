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
            <form method="post" id="login" novalidate="novalidate">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>
                                <label for="name">Name:</label>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="name" id="name">
                            </td>
                        <tr>
                            <td>
                                <label for="username">Email:</label>
                            </td>
                            <td>
                                <input type="email" class="form-control" name="username" id="username">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="password">Password:</label>
                            </td>
                            <td>
                                <input type="password" class="form-control" name="password" id="password">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="confpass">Confirm Password:</label>
                            </td>
                            <td>
                                <input type="password" class="form-control" name="confpass" id="confpass">
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
