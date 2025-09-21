@extends('layouts.admin_app')
@section('title','Contact details')
@section('content')
<div class="col-12">
    <div class=" d-flex justify-content-center">
        <div class="card col-md-8 mt-3">
          <div class="card-header p-2 d-flex">
            <a href="{{ route('contact#list')}}" class="mt-1 ms-3 text-dark"><i class="fa-solid fa-arrow-left"></i></a>
            <legend class="text-center">Contact Information</legend>
          </div>
          <div class="card-body">
                  <div class="form-group row border-bottom">
                    <label for="" class="col-sm-3 col-form-label">User Name:</label>
                    <div class="col-sm-9 align-content-center text-muted">
                        {{ $contact->name}}
                    </div>
                  </div>
                  <div class="form-group row border-bottom">
                    <label for="" class="col-sm-3 col-form-label">User Email:</label>
                    <div class="col-sm-9 align-content-center text-muted">
                        {{$contact->email}}
                    </div>
                  </div>
                  <div class="form-group row border-bottom">
                    <label for="" class="col-sm-3 col-form-label">Type:</label>
                    <div class="col-sm-9 align-content-center text-muted">
                        {{$contact->inquiry_type}}
                    </div>
                  </div>
                  <div class="form-group row border-bottom">
                    <label for="" class="col-sm-3 col-form-label">Subject:</label>
                    <div class="col-sm-9 align-content-center text-muted">
                        {{$contact->subject}}
                    </div>
                  </div>
                  <div class="form-group row border-bottom">
                    <label for="" class="col-sm-3 col-form-label">Message:</label>
                    <div class="col-sm-9 align-content-center text-muted">
                        {{$contact->message}}
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10 d-flex justify-content-end">
                        <form action="{{ route('contact#delete', $contact->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class=" mt-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-dark">Delete</button>
                        </form>
                    </div>
                  </div>
              </div>
            </div>
          </div>
@endsection

