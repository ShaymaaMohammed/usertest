@extends('layout.master')
@section('title', 'Welcome')
@section('content')
<div class="container">
    <h2>Users List</h2>

    <form method="GET" action="{{ route('users_list') }}" class="mb-4">
        <div class="row">
           
            <div class="col-md-4">
                <input type="text" name="name" class="form-control" 
                       placeholder="Search by Name" value="{{ request('name') }}">
            </div>

            
            <div class="col-md-3">
            <input type="number" name="id" class="form-control" 
                   placeholder="Search by ID" value="{{ request('id') }}">
            </div>

          
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('users_list') }}" class="btn btn-secondary">Reset</a>
    </form>
    @can('add_user')
    <a href="{{ route('user_new') }}" class="btn btn-success">Add New User</a>
    @endcan


    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @can('edit_user')
                    <a href="{{ route('profile') }}" class="btn btn-info  btn-md ">Edit</a>
                    @endcan
                </td>
                <td>
                    @can('personal_information')
                    <a href="{{ route('personal_information_edit') }}" class="btn btn-success  btn-md ">personal information</a>
                    @endcan
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>

    
</div>
@endsection