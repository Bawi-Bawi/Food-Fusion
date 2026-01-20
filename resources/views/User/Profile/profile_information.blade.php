@extends('layouts.app')
@section('title', 'Profile Information')
@section('styles')
<style>
    .profile-card {
      max-width: 380px;
      margin: auto;
      margin-top: 50px;
      margin-bottom: 50px;
      background: white;
      padding: 25px;
      border-radius: 20px;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
    }
    .profile-img {
      position: relative;
      width: 120px;
      height: 120px;
      margin: auto;
    }
    .profile-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 50%;
      background: #f0f0f0;
    }
    .btn-update {
      background-color: #00a497;
      color: white;
      border-radius: 8px;
      padding: 10px;
    }
    .btn-update:hover {
      background-color: #008f85;
    }
    .cancel-btn {
      margin-top: 10px;
      display: block;
      text-align: center;
      color: gray;
      text-decoration: none;
    }
</style>
@section('content')
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show w-50 m-auto my-3" role="alert">
  <strong>Success!</strong> {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="profile-card">
  <div class="profile-img">
    @if ($user->image)
        <img src="{{ asset('storage/user/'.$user->image) }}" alt="Profile Image" id="profilePreview" >
    @else
        <img src="{{ asset('storage/user/default/default_user.jpg')}}" alt="Profile" id="profilePreview">
    @endif
  </div>
  <div class="mt-4">
    <div class="mb-3 position-relative border-bottom  pb-1">
      <span>{{  $user->first_name }}</span>
    </div>
    <div class="mb-3 position-relative border-bottom pb-1">
        <span>{{  $user->last_name }}</span>
    </div>
    <div class="mb-3 position-relative border-bottom pb-1">
        <span>{{  $user->email }}</span>
    </div>
    <a href="{{ route('profile#updatePage',$user->id)}}" class="btn btn-update btn-warning w-100">Update Profile</a>
  </div>
  <a href="{{ route('change#passwordPage',$user->id)}}" class="btn btn-update btn-warning w-100 mt-3">Change Password</a>
  <form action="{{  route('account#logout') }}" class=" mt-3" method="POST">
    @csrf
     <button type="submit" class="btn btn-update btn-outline-dark w-100">logout</button>
  </form>
</div>
@endsection

