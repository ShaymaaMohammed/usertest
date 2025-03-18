@extends('layout.master')
@section('title', 'User profile')
@section('content')

@section('content')
<div class="container mt-5">
        <div class="col-md-6">

        <div class="m-4 col-lg-12">
        <table class="table table-striped">
            <tr>
                <th>Name</th><td>{{$user->name}}</td>
            </tr>
            <tr>
                <th>Email</th><td>{{$user->email}}</td>
            </tr>
            
        </table>

                
           
    </div>
            @if (session('message'))
              <div class="alert alert-danger">
                {{ session('message') }}
              </div>
           @endif

            <div class="card mb-4">
                @if ($errors->any())
                   <ul class="alert alert-danger">
                      @foreach ($errors->all() as $error)
                         <li class="text-danger">{{ $error }}</li>
                      @endforeach
                   </ul>
                @endif
            </div>
            
            <div class="card">
                <div class="card-header bg-info"><strong>Edit information</strong></div>
                <div class="card-body">
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
                    </div>
                    <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                </div>
            </div>

        </div>
</div>
@endsection