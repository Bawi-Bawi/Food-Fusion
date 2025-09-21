@extends('layouts.app')
@section('styles')
<style>
    .cardBody {
      background-color:#f8f8f4;
    }
    .modal-content {
      max-width: 400px;
      margin: 0 auto;
    }
    .home-img {
      width: 100%;
      height: 100%;
    }
    .card-container{
      scroll-behavior: smooth;
      width: 940px;
    }
    .card-wrapper {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-wrapper:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .event-name {
      text-decoration: none;
      color: black;
      transition: text-decoration 0.3s ease;
    }

    .cuisine-card {
        position: relative;
        width: 300px;
        height: 270px;
    }

    .cuisine-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .cuisine-name-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
        text-shadow: 0px 2px 6px rgba(0,0,0,0.7);
        background: rgba(0, 0, 0, 0.4);
        padding: 5px 12px;
        border-radius: 8px;
        text-align: center;
    }
    .cookie-consent {
      position: fixed;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      background: #fff;
      border-radius: 12px;
      box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.15);
      padding: 20px;
      max-width: 420px;
      z-index: 1050;
    }
    .cookie-icon {
      font-size: 1.5rem;
      margin-right: 10px;
      color: #ff7a00;
    }
    .cookie-header {
      font-weight: 600;
      font-size: 1.1rem;
    }
    @media (max-width: 975px) {
      .card-container {
        width: 620px;
      }
    }
    @media (max-width: 670px) {
      .card-container {
        width: 310px;
      }
    }
</style>
@section('content')
{{-- error alert start --}}
@error('email')
<div class="alert alert-danger alert-dismissible fade show w-50 m-auto my-3" role="alert">
  <strong>Email!</strong> {{ $message }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@enderror
@error('password')
<div class="alert alert-danger alert-dismissible fade show w-50 m-auto my-3" role="alert">
  <strong>Password!</strong> {{ $message }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@enderror
{{-- error alert end --}}
{{-- success alert start --}}
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show w-50 m-auto my-3" role="alert">
  <strong>Success!</strong> {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (session('error'))
<div class="alert alert-warning alert-dismissible fade show w-50 m-auto my-3" role="alert">
  <strong>Error!</strong> {{ session('error') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
{{-- success alert end --}}
<section>
  <!-- Intro Section with Background Image -->
  <div class="row m-4 shadow-sm rounded cardBody">
    <div class="col-md-7 p-5">
      <h3 class="">Cook Like a Pro With</h3>
      <h3>Our <span class="text-warning">Easy</span> and <span class=" text-warning">Tasty</span></h3>
      <h3>Recipes</h3>
      <p>Discover step-by-step guides to create delicious meals in no time. Whether you’re a beginner or a seasoned cook, our recipes make cooking simple, fun, and full of flavor. Learn new techniques, explore exciting dishes, and impress your family and friends with every bite. You can also share your recipe by joining our community.</p>
       @if (Auth::check())
        <button class=" btn btn-warning w-lg-25" onclick="document.getElementById('logoutModal').style.display='block'" >Joined</button>
       @else
     <button class=" btn btn-warning w-lg-25" onclick="document.getElementById('joinModal').style.display='block'">Join Us</button>
       @endif
    </div>
    <div class="col-md-5">
      <img src="{{ asset('image/young-beautiful-asian-woman-chef-removebg-preview.png')}}" class="home-img" alt="">
    </div>
  </div>
  <!-- Recipe Cards Section -->
  <h3 class=" text-center mt-5">Popular Recipes You Can't Miss</h3>
  <p class=" text-muted text-center">Explore our most-loved dishes that everyone is talking about. From quick weeknight dinners to indulgent desserts, these recipes are guaranteed to become your new favorites.</p>
  <div class="mt-4 d-flex justify-content-evenly flex-wrap">
    @foreach ($recipes as $recipe)
    <div class="card mb-4 mb-lg-0" style="width: 15rem;">
      <img src="{{ asset('storage/Recipes/'.$recipe->image)}}" class="card-img-top" style="height: 200px" alt="...">
      <div class="card-body">
        <h5 class="card-title">{{ $recipe->title}}</h5>
        <p class="card-text text-muted">{{ Str::limit($recipe->description,70)}}</p>
      </div>
      <div class="card-body ">
        <a href="{{ route('recipe#details',$recipe->id)}}" class=" btn btn-outline-warning w-100">See Full Details</a>
      </div>
    </div>
    @endforeach


  </div>
<!-- explore by Cuisine -->
<h3 class=" text-center mt-5">Explore By Cuisine Type</h3>
<p class=" text-muted text-center">Take your taste buds on a journey around the world. Discover authentic flavors from Italian pastas to Asian stir-fries, Mexican tacos to Indian curries—find recipes that match your cravings.</p>
  <div class="d-flex justify-content-center">
    <div class="card-container mt-4 d-flex overflow-hidden" id="cardContainer">
        @foreach ($byCuisines as $recipe)
        <a href="{{ route('recipes#collection', ['search' => $recipe->cuisine_name]) }}"
           class="cuisine-card flex-shrink-0 me-3 position-relative text-decoration-none">
            <img src="{{ asset('storage/Recipes/'.$recipe->image) }}"
                 class="rounded cuisine-image" alt="{{ $recipe->cuisine_name }}">
            <div class="cuisine-name-overlay">
                {{ $recipe->cuisine_name }}
            </div>
        </a>
        @endforeach
    </div>
  </div>
  <div class="mt-4 text-center">
      <button id="leftButton" class="btn btn-outline-warning rounded-5 fs-3"><i class="fa-solid fa-chevron-left"></i></button>
      <button id="rightButton" class="btn btn-outline-warning rounded-5 ms-3 fs-3"><i class="fa-solid fa-chevron-right"></i></button>
  </div>
<!-- Upcoming event -->
  <h3 class=" text-center mt-5">Upcoming Event</h3>
  <div class=" d-flex justify-content-center flex-wrap my-5">
    @foreach ($events as $event)
    <div class="card-wrapper rounded shadow-lg mb-4 mb-lg-0 me-4" style="width: 12rem; height: 330px;">
      <img src="{{ asset('storage/event/'.$event->image)}}" class="w-100 rounded-top" style="height: 200px;" alt="...">
      <div class="card-body d-flex align-items-center flex-column">
        <p class="event-name fw-bold fs-5 mt-3">{{ $event->name}}</p>
      </div>
      <div class="my-2">
        <small class=" d-block ms-3"><i class="fa-solid fa-calendar"></i> {{ \Carbon\Carbon::parse($event->date)->format('d M, g:i a') }}</small>
        <small class=" d-block ms-3"><i class="fa-solid fa-location-dot"></i> {{ $event->location}}</small>
      </div>
    </div>
    @endforeach
  </div>
</section>
  <!-- Join Us Modal register -->
  <div id="joinModal" class="modal" tabindex="-1" style="display:none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Join FoodFusion</h5>
          <button type="button" class="btn-close" onclick="document.getElementById('joinModal').style.display='none'"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('account#register')}}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="fname" class="form-label">First Name</label>
              <input type="text" name="fname" class="form-control" id="fname" required>
            </div>
            <div class="mb-3">
              <label for="lname" class="form-label">Last Name</label>
              <input type="text" name="lname" class="form-control" id="lname" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-warning">Register</button>
                <span onclick="
                    document.getElementById('joinModal').style.display='none';
                    document.getElementById('loginModal').style.display='block';
                ">Already a member?</span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<!-- Join Us Modal login -->
<div id="loginModal" class="modal" tabindex="-1" style="display:none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Login to FoodFusion</h5>
          <button type="button" class="btn-close" onclick="document.getElementById('loginModal').style.display='none'"></button>
        </div>
        <div class="modal-body">
          <form action="{{route('account#login')}}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" class="form-control" id="password" required>
            </div>
                <button type="submit" class="btn btn-warning">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
    <!-- Logout Modal -->
<div id="logoutModal" class="modal" tabindex="-1" style="display:none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Logout?</h5>
          <button type="button" class="btn-close" onclick="document.getElementById('logoutModal').style.display='none'"></button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to logout?</p>
        </div>
        <div class="modal-footer">
            <form action="{{ route('account#logout')}}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Yes</button>
            </form>
          <button type="button" class="btn btn-secondary" class="btn-close" onclick="document.getElementById('logoutModal').style.display='none'">No</button>
        </div>
      </div>
    </div>
  </div>
<div id="cookieConsent" class="cookie-consent d-flex align-items-start">
    <div class="me-2 ">
      <span class="cookie-icon"><i class="fa-solid fa-cookie-bite"></i></span>
    </div>
    <div class="flex-grow-1">
      <div class="cookie-header">We use cookies</div>
      <p class="mb-3 small text-muted">
        We use cookies to enhance your experience, analyze site traffic, and personalize content.
        By continuing to use our site, you consent to our use of cookies.
      </p>
      <div class="d-flex gap-2">
        <button class="btn btn-warning btn-sm text-white" id="acceptBtn">Accept</button>
        <button class="btn btn-outline-secondary btn-sm" id="declineBtn">Decline</button>
      </div>
    </div>
    <div>
        <span id="cancelBtn"><i class="fa-solid fa-xmark"></i></span>
    </div>
  </div>
@endsection
@section('scripts')
 <script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('cardContainer');
        const leftButton = document.getElementById('leftButton');
        const rightButton = document.getElementById('rightButton');
        const cookieBox = document.getElementById("cookieConsent");
        const acceptBtn = document.getElementById("acceptBtn");
        const declineBtn = document.getElementById("declineBtn");
        const cancelBtn = document.getElementById("cancelBtn");
          // Scroll distance per click
          const scrollAmount = 315;

          leftButton.addEventListener('click', () => {
              container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
              console.log('Left button clicked');

          });

          rightButton.addEventListener('click', () => {
              console.log('Right button clicked');
              container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
          });


        // Check if cookie consent was already given
        if (localStorage.getItem("cookieConsent")) {
            cookieBox.classList.add('d-none');
        }

        acceptBtn.addEventListener("click", () => {
          localStorage.setItem("cookieConsent", "accepted");
          cookieBox.classList.add('d-none');
        });

        declineBtn.addEventListener("click", () => {
          localStorage.setItem("cookieConsent", "declined");
          cookieBox.classList.add('d-none');
        });
        cancelBtn.addEventListener("click",()=>{
            cookieBox.classList.add('d-none');
        })
    })
  </script>
@endsection
