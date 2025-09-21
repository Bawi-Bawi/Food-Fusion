@extends('layouts.admin_app')
@section('title','Admin-dashboard')
@section('content')
<div class="col-12">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show w-50 m-auto my-3" role="alert">
      <strong>Success!</strong> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="card">
      <div class="card-header d-flex justify-content-end">
        <div class="card-tools">
          <form method="GET" action="{{ route('admin#dashboard')}}"  class="input-group input-group-sm" style="width: 150px;">
            @csrf
            <input type="text" name="table_search" class="form-control float-right" placeholder="Search" value="{{ request('table_search')}}">
            <div class="input-group-append">
              <button type="submit" class="btn btn-default">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        @if ($users->count() !== 0)
        <table class="table table-hover text-nowrap text-center">
            <thead>
              <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user )
              <tr @if (Auth::user()->id == $user->id)
                  class="bg-gray-light"
              @endif>
                  <td><small>{{ $user->id}}</small></td>
                  <td>
                    @if ($user->image == null)
                        <img src="{{ asset('storage/user/default/default_user.jpg') }}" class="img-thumbnail shadow-sm" style="width: 50px; height: 50px;">
                    @else
                        <img src="{{asset('storage/user/'.$user->image)}}"  alt="" style="width: 50px; height: 50px;">
                    @endif
                  </td>
                  <td><small>{{ $user->first_name}}</small></td>
                 <td><small>{{ $user->last_name}}</small></td>
                  <td><small>{{ $user->email}}</small></td>
                  <td><small>{{ $user->role}}</small></td>
                  <td>

                    @if ($user->id == Auth::user()->id)
                    <button class="btn  btn-sm btn-outline-light text-dark" disabled><i class=" fa fa-trash"></i></button>
                    @else
                    <form action="{{ route('user#delete', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn"><i class="fa-solid fa-trash"></i></button>
                    </form>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
            <h4 class=" text-muted text-center my-3"> There is no user!</h4>
        @endif
      </div>
      <!-- /.card-body -->
    </div>
   <div class="d-flex justify-content-between mt-3">
    <div class=" fw-bold">Total User: {{$users->total()}}</div>
    <small>{{ $users->links() }}</small>
   </div>
    <!-- /.card -->
  </div>
@endsection

