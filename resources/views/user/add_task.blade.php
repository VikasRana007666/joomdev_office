@extends('user.layout')

@section('content')
    @include('user.navbar')
    <div class="container">
        <h3>Add Task</h3>
        @if (session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <form method="POST">
            @csrf
            <div class="row">
                <div class="mb-3 col">
                    <label class="form-label">Start Time</label>
                    <input required name="start_time" type="date" class="form-control">
                </div>
                <div class="mb-3 col">
                    <label class="form-label">End Time</label>
                    <input required name="end_time" type="date" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col">
                    <label class="form-label">Note</label>
                    <input required name="notes" type="text" class="form-control">
                </div>
                <div class="mb-3 col">
                    <label class="form-label">Description</label>
                    <input required name="description" type="text" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        {{-- Table --}}
        <hr>
        <h3>All Tasks</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Start Time</th>
                    <th scope="col">End Time</th>
                    <th scope="col">Notes</th>
                    <th scope="col">Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $item)
                    <tr>
                        <th scope="row">#</th>
                        <td>{{ $item->start_time }}</td>
                        <td>{{ $item->end_time }}</td>
                        <td>{{ $item->notes }}</td>
                        <td>{{ $item->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
