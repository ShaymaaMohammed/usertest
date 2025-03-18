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
            <tr>
                <th>Roles</th>
                <td>
                        @foreach($user->roles as $role)
                            <span class="badge bg-primary">{{$role->name}}</span>
                        @endforeach
                    </td>
                  
            </tr>
            <tr>
                    <th>Permissions</th>
                    <td>
                        @foreach($permissions as $permission)
                            <span class="badge bg-success">{{$permission->display_name}}</span>
                        @endforeach
                    </td>
                </tr>
        </table>

        <div class="row">
                <div class="col col-5">
                </div>
                <div class="col col-2">
                    @if(auth()->user()->hasPermissionTo('edit_user')||auth()->id()==$user->id)
                    <a href="{{route('admin_users_edit')}}" class="btn btn-primary form-control">Edit</a>
                    @endif
                </div>
                <div class="col col-2">
                    @if(auth()->user()->hasPermissionTo('edit_user')||auth()->id()==$user->id)
                    <a href="{{route('user_delete', $user->id)}}" class="btn btn-danger  btn-md ">Delete</a>
                    @endif
                </div>
        </div>
                
           
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
                <div class="card-header bg-info"><strong>Password</strong></div>
                <div class="card-body">
                    <form action="{{ route('update_password') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                            
                        </div>

                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="new_password" class="form-control" required>
                            
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Update Password</button>
                    </form>
                </div>
            </div>

        </div>
</div>
@endsection