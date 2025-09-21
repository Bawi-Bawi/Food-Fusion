@extends('layouts.admin_app')
@section('title','Contact List')
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
            <div class="dropdown">
              <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Inquiry Type
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('contact#list',['type'=>'general'])}}">General Inquiry</a></li>
                <li><a class="dropdown-item" href="{{ route('contact#list',['type'=>'recipe'])}}">Recipe Request</a></li>
                <li><a class="dropdown-item" href="{{ route('contact#list',['type'=>'feedback'])}}">Feed Back</a></li>
                <li><a class="dropdown-item" href="{{ route('contact#list',['type'=>'partner_ship'])}}">Partner Ship</a></li>
                <li><a class="dropdown-item" href="{{ route('contact#list',['type'=>'technical_support'])}}">Technical Support</a></li>
              </ul>
            </div>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        @if ($contacts->count() !== 0)
        <table class="table table-hover text-nowrap text-center">
            <thead>
              <tr>
                <th>name</th>
                <th>email</th>
                <th>Inquiry Type</th>
                <th>Subject</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($contacts as $contact )
              <tr data-id="{{ $contact->id }}" onclick="selectRow(this)">
                <td><small>{{ $contact->name}}</small></td>
                <td><small>{{$contact->email}}</small></td>
                <td><small>{{ $contact->inquiry_type}}</small></td>
                <td><small>{{ $contact->subject}}</small></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
            <h4 class=" text-muted text-center my-3"> There is no contact!</h4>
        @endif
      </div>
      <!-- /.card-body -->
    </div>
   <div class="d-flex justify-content-between mt-3">
    <div class=" fw-bold">Total Contacts: {{$contacts->total()}}</div>
    <small>{{ $contacts->links() }}</small>
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
        window.location.href = `/contact/details/${selectedId}`;
      }
</script>
@endsection
