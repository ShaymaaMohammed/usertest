@extends('layout.master')
@section('title', 'Welcome')
@section('content')
<div class="container">
    <h2>Add New User</h2>
    <form action="{{route('user_save', $user->id)}}" method="post">
        @csrf
        
    <div class="row mb-2">
        <div class="col">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" placeholder="Name" name="name" required value="{{$user->name}}">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-6">
            <label for="Email" class="form-label">Email:</label>
            <input type="email" class="form-control" placeholder="Email" name="email" required value="{{$user->email}}">
        </div>
        <div class="col-6">
            <label for="password" class="form-label">password:</label>
            <input type="password" class="form-control" placeholder="Password" name="password" required value="{{$user->password}}">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection