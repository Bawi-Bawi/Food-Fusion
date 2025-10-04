@extends('layouts.app')
@section('title', 'Change Password')
@section('styles')
<style>
    .password-card {
      max-width: 380px;
      margin: auto;
      margin-top: 50px;
      margin-bottom: 50px;
      background: white;
      padding: 25px;
      border-radius: 20px;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
    }

    .form-control {
      border-radius: 10px;
      padding-left: 40px;
    }
    .input-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: gray;
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
<div class="password-card">
<h4 class=" text-center">Change Password</h4>
  <form class="mt-4" method="POST" action="{{ route('change#password',$user->id)}}" >
    @csrf
    <div class="mb-3 position-relative">
      <i class="bi bi-person input-icon"></i>
      <input type="password" class="form-control" name="old_password" placeholder="Enter your Password" >
      @error('old_password')
        <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>
    <div class="mb-3 position-relative">
      <i class="bi bi-person input-icon"></i>
      <input type="password" class="form-control" name="new_password" placeholder="Enter your new password">
      @error('new_password')
        <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>
    <div class="mb-3 position-relative">
      <i class="bi bi-person input-icon"></i>
      <input type="password" class="form-control" name="confirm_password" placeholder="Confirm password">
      @error('confirm_password')
        <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>
    <button type="submit" class="btn btn-update btn-warning w-100">Change</button>
  </form>
<a href="{{ route('profile#information',$user->id)}}" class="cancel-btn">Cancel</a>
</div>
@endsection

