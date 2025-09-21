@extends('layouts.admin_app')
@section('title','Add Video')
@section('content')
<div class="col-12">
    <div class=" d-flex justify-content-center">
    <div class="card col-md-8 mt-3">
      <div class="card-header p-2 d-flex ">
        <a href="{{ route('admin#resources')}}" class="mt-1 ms-3 text-dark"><i class=" fa-solid fa-arrow-left"></i></a>
        <legend class="text-center">Add New Tutorial Video</legend>
        </div>
      <div class="card-body">
        <div class="tab-content">
            <form action="{{ route('add#videoResources')}}" method="POST" class="form-horizontal">
                @csrf
              <div class="form-group row">
                <label for="" class="col-sm-3 col-form-label">Name:</label>
                <div class="col-sm-9">
                  <input type="text" name="title" class="form-control" placeholder="Title">
                  @error('title')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
            <div class="form-group row mt-3">
                <label for="" class="col-sm-3 col-form-label">Description:</label>
                <div class="col-sm-9">
                  <textarea name="description" id="" class="form-control" rows="5" placeholder="Description"></textarea>
                  @error('description')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              <div class="form-group row mt-3">
                <label for="" class="col-sm-3 col-form-label">Type:</label>
                <div class="col-sm-9 align-content-center ">
                  <select name="resource_type" id="" class="form-control">
                    <option value="">--Select Resources Type--</option>
                    <option value="Culinary Resources">Culinary Resources</option>
                    <option value="Educational Resources">Education Resources</option>
                  </select>
                  @error('resource_type')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              <div class="form-group row mt-3">
                <label for="" class="col-sm-3 col-form-label">Video Link:</label>
                <div class="col-sm-9 align-content-center">
                  <input type="text" class="form-control"  placeholder="Url" name="video_url" value="{{ old('link')}}">
                  @error('video_url')
                  <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              <div class="form-group row mt-3">
                <div class="offset-sm-2 col-sm-10 d-flex justify-content-end">
                  <button type="submit" class="btn bg-dark text-white w-25">Add</button>
                </div>
              </div>
            </form>
          </div>
          </div>
      </div>
    </div>
  </div>
@endsection
