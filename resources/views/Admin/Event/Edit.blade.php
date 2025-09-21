
@extends('layouts.admin_app')
@section('title','Edit Event')
@section('content')
<div class="col-12">
    <div class=" d-flex justify-content-center">
    <div class="card col-md-8 mt-3">
      <div class="card-header p-2 d-flex ">
        <a href="{{ route('event#list',)}}" class="mt-1 ms-3 text-dark"><i class=" fa-solid fa-arrow-left"></i></a>
        <legend class="text-center">Edit Event </legend>
        </div>
      <div class="card-body">
        <div class="tab-content">
            <form action="{{ route('event#edit',$event->id)}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                @csrf
              <div class="form-group row">
                <label for="" class="col-sm-3 col-form-label">Name:</label>
                <div class="col-sm-9">
                  <input type="text" name="title" class="form-control" placeholder="Title" value="{{ old('title',$event->name)}}">
                  @error('title')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
            <div class=" d-flex justify-content-center my-3">
                <img src="{{ asset('storage/event/'.$event->image)}}" alt="" style="width:300px; height: 200px;">
            </div>
            <div class="form-group row mt-3">
                <label for="" class="col-sm-3 col-form-label">Image:</label>
                <div class="col-sm-9 align-content-center">
                  <input type="file" class="form-control" name="image">
                  @error('image')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>

            <div class="form-group row mt-3">
                <label for="" class="col-sm-3 col-form-label">Location:</label>
                <div class="col-sm-9">
                  <textarea name="location" class=" form-control" rows =5>{{ old('location',$event->location)}}</textarea>
                  @error('location')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
            <div class="form-group row mt-3">
                <label for="" class="col-sm-3 col-form-label">Date:</label>
                <div class="col-sm-9 align-content-center">
                  <input type="datetime-local" class="form-control" name="date" value="{{ old('date',$event->date) }}">
                  @error('date')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
            </div>
              <div class="form-group row mt-3">
                <div class="offset-sm-2 col-sm-10 d-flex justify-content-end">
                  <button type="submit" class="btn bg-dark text-white w-25">Update</button>
                </div>
              </div>
            </form>
          </div>
          </div>
      </div>
    </div>
  </div>
@endsection

