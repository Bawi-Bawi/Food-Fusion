@extends('layouts.admin_app')
@section('title','Resources List')
@section('content')
<div class="col-12">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show w-50 m-auto my-3" role="alert">
      <strong>Success!</strong> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <div class="dropdown">
          <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Add Resources
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('pdf#resources')}}">PDF</a></li>
            <li><a class="dropdown-item" href="{{ route('video#resources')}}">Tutorial Video</a></li>
            <li><a class="dropdown-item" href="{{ route('infographic#resources')}}">Infographic</a></li>
          </ul>
        </div>
        <div class="card-tools">
          <form method="GET" action="{{ route('admin#resources')}}"  class="input-group input-group-sm" style="width: 150px;">
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
        @if ($resources->count() !== 0)
        <table class="table table-hover text-nowrap text-center">
            <thead>
              <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Type</th>
                <th>File</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($resources as $resource )
              <tr data-id="{{ $resource->id }}" onclick="selectRow(this)">
                <td><small>{{ $resource->title}}</small></td>
                <td><small>{{Str::limit($resource->description,50)}}</small></td>
                <td><small>{{ $resource->type}}</small></td>
                <td>
                    @if ($resource->link != null)
                        <a href="{{ $resource->link}}" target="_blank" class="text-decoration-none">Video Link</a>
                    @elseif ($resource->file_path != null)
                        <a href="{{ asset('storage/file/'.$resource->file_path)}}" target="_blank" class="text-decoration-none">PDF File</a>
                    @else
                        <a href="{{ asset('storage/image/'.$resource->image)}}" target="_blank" class="text-decoration-none">Infographic</a>
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin#deleteResource', $resource->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
            <h4 class=" text-muted text-center my-3"> There is no resource!</h4>
        @endif
      </div>
      <!-- /.card-body -->
    </div>
   <div class="d-flex justify-content-between mt-3">
    <div class=" fw-bold">Total Resources: {{$resources->total()}}</div>
    <small>{{ $resources->links() }}</small>
   </div>
    <!-- /.card -->
  </div>
@endsection

