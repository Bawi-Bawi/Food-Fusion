@extends('layouts.admin_app')
@section('title','Recipes List')
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
          <form method="GET" action="{{ route('recipes#list')}}"  class="input-group input-group-sm" style="width: 150px;">
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
        @if ($recipes->count() !== 0)
        <table class="table table-hover text-nowrap text-center">
            <thead>
              <tr>
                <th>Title</th>
                <th>Image</th>
                <th>Description</th>
                <th>Difficulty</th>
                <th>Time_Taken</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($recipes as $recipe )
              <tr data-id="{{ $recipe->id }}" onclick="selectRow(this)">
                <td><small>{{ $recipe->title}}</small></td>
                <td>
                    <img src="{{ asset('storage/Recipes/'.$recipe->image)}}" class="" alt="" style=" width: 100px; height: 70px;">
                </td>
                <td><small>{{Str::limit($recipe->description,30)}}</small></td>
                <td><small>{{ $recipe->difficulty}}</small></td>
                <td><small>{{ $recipe->time_taken}}</small></td>
                <td>
                    @if ($recipe->status == 'pending')
                        <small class=" text-warning">{{ $recipe->status}}</small>
                    @elseif ($recipe->status == 'approved')
                        <small class=" text-success">{{ $recipe->status}}</small>
                    @else
                     <small class=" text-danger">{{ $recipe->status}}</small>
                    @endif
                </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
            <h4 class=" text-muted text-center my-3"> There is no recipe!</h4>
        @endif
      </div>
      <!-- /.card-body -->
    </div>
   <div class="d-flex justify-content-between mt-3">
    <div class=" fw-bold">Total Recipes: {{$recipes->total()}}</div>
    <small>{{ $recipes->links() }}</small>
   </div>
    <!-- /.card -->
  </div>
@endsection
@section('scripts')
<script>
    let selectedId = null;

      function selectRow(row) {
        document.querySelectorAll("tr[data-id]").forEach(tr => tr.classList.remove("table-primary"));

        // Store selected ID
        selectedId = row.getAttribute("data-id");
        window.location.href = `/recipe/admin/details/${selectedId}`;

      }
</script>
@endsection
