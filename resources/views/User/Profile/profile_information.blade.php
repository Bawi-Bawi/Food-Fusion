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
    .profile-img .add-icon {
      position: absolute;
      bottom: 5px;
      right: 5px;
      background: white;
      border-radius: 50%;
      padding: 5px;
      border: 1px solid #ccc;
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

<div class="profile-card">
  <div class="profile-img">
    @if ($user->image)
        <img src="{{ asset('storage/user/'.$user->image) }}" alt="Profile Image" id="profilePreview" >
    @else
        <img src="{{ asset('storage/user/default/default_user.jpg')}}" alt="Profile" id="profilePreview">
    @endif
    <div class="add-icon" style="cursor: pointer;">
        <i class="fa-solid fa-circle-plus"></i>
    </div>
  </div>
  <form class="mt-4" method="POST" action="{{ route('profile#update', $user->id) }}" enctype="multipart/form-data">
    @csrf
    <input type="file" id="imageInput" name="image" class="mb-3 d-none" accept="image/*">
    @error('image')
    <div class="text-danger text-center mb-3" >{{ $message}}</div>
    @enderror

    <div class="mb-3 position-relative">
      <i class="bi bi-person input-icon"></i>
      <input type="text" class="form-control" name="first_name" placeholder="First Name" value="{{ $user->first_name}}" >
      @error('first_name')
        <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>
    <div class="mb-3 position-relative">
      <i class="bi bi-person input-icon"></i>
      <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="{{ $user->last_name}}" >
      @error('last_name')
        <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>
    <div class="mb-3 position-relative">
      <i class="bi bi-envelope input-icon"></i>
      <input type="email" class="form-control" disabled value="{{ $user->email }}" placeholder="Email Address">
    </div>
    <button type="submit" class="btn btn-update btn-warning w-100">Update Profile</button>
    <a href="{{ route('home#page')}}" class="cancel-btn">Cancel</a>
  </form>
</div>
@endsection
@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const plusIcon = document.querySelector('.add-icon');
        const imageInput = document.getElementById('imageInput');
        const profilePreview = document.getElementById('profilePreview');

        plusIcon.addEventListener('click', function() {
            imageInput.value = "";
            imageInput.click();
        });

        // Preview selected image
        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePreview.src = e.target.result;

                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection
