@extends('admin.layout')

@section('content')
    @include('admin.navbar')
    <div class="container">
        <h3>Add User</h3>
        @if (session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <form method="POST">
            @csrf
            <div class="row">
                <div class="mb-3 col">
                    <label class="form-label">First Name</label>
                    <input required name="first_name" type="text" class="form-control">
                </div>
                <div class="mb-3 col">
                    <label class="form-label">Last Name</label>
                    <input required name="last_name" type="text" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col">
                    <label class="form-label">Phone</label>
                    <input required name="phone" maxlength="10" type="text" class="form-control">
                </div>
                <div class="mb-3 col">
                    <label class="form-label">Email address</label>
                    <input required name="email" type="email" class="form-control">
                </div>
            </div>
            <div class="row d-flex align-items-center">
                <div class="mb-3 col">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input required name="password" type="password" class="form-control" id="password-input">
                        <button class="btn btn-outline-secondary" type="button" id="password-toggle">
                            Show
                        </button>
                    </div>
                </div>
                <div class="mt-12 col form-check">
                    <input type="checkbox" class="form-check-input" id="generatePassword">
                    <label class="form-check-label" for="generatePassword">Generate strong password</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        {{-- Table --}}
        <hr>
        <h3>All Users</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $item)
                    <tr>
                        <th scope="row">#</th>
                        <td>{{ $item->first_name }}</td>
                        <td>{{ $item->last_name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->phone }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
