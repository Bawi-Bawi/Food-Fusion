@extends('layouts.admin_app')
@section('title','Event')
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
        <a href="{{ route('event#addPage')}}" class="btn btn-outline-dark">Add Event</a>
        <div class="card-tools">
          <form method="GET" action="#"  class="input-group input-group-sm" style="width: 150px;">
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
        @if ($events->count() !== 0)
        <table class="table table-hover text-nowrap text-center">
            <thead>
              <tr>
                <th>Name</th>
                <th>Photo</th>
                <th>Location</th>
                <th>Date</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($events as $event )
              <tr>
                  <td><small>{{ $event->name}}</small></td>
                  <td>
                    <img src="{{asset('storage/event/'.$event->image)}}"  alt="" style="width: 70px; height: 70px;">
                  </td>
                  <td><small>{{ $event->location}}</small></td>
                  <td><small>{{ \Carbon\Carbon::parse($event->date)->format('d M, g:i a') }}</small></td>
                  <td>
                    <div class="d-flex justify-content-around">
                        <a href="{{ route('event#editPage',$event->id)}}" class="btn btn-sm"><i class="fa-solid fa-pen-to-square"></i></a>
                        <form action="{{ route('event#delete', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
            <h4 class=" text-muted text-center my-3"> There is no event!</h4>
        @endif
      </div>
      <!-- /.card-body -->
    </div>
   <div class="d-flex justify-content-between mt-3">
    <div class=" fw-bold">Total : {{$events->total()}}</div>
    <small>{{ $events->links() }}</small>
   </div>
    <!-- /.card -->
  </div>
@endsection
