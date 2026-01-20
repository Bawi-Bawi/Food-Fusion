<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('build/style/app.css') }}">
@yield('styles')
</head>
<body>
  <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
        <div class="container-fluid my-2">
            <a class="navbar-brand" href="{{ route('admin#dashboard') }}"><img src="{{ asset('image/logo.png')}}" class="logo" alt="">FoodFusion</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav w-100 justify-content-evenly">
                <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
                  <a class="nav-link item" href="{{ asset('home#page')}}">Home</a>
                </li>
                <li class="nav-item {{ request()->is('recipes/collection') ? 'active' : '' }}">
                    <a class="nav-link item" href="{{ route('recipes#collection')}}">Recipes Collection</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button">
                        Resources
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('resources','Culinary Resources')}}">Culinary Resources</a></li>
                        <li><a class="dropdown-item" href="{{ route('resources','Educational Resources')}}">Educational Resources</a></li>
                    </ul>
                </li>
                <li class="nav-item {{ request()->is('cook_book') ? 'active' : '' }}">
                    <a class="nav-link item" href="{{route('cook_book#page')}}">Community Cookbook</a>
                </li>
                <li class="nav-item {{ request()->is('about/us') ? 'active' : '' }}">
                    <a class="nav-link item" href="{{ route('about#us')}}">About Us</a>
                </li>
                <li class="nav-item {{ request()->is('contact/us') ? 'active' : '' }}">
                    <a class="nav-link item " href="{{ route('contact#us')}}">Contact Us</a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link item " href="{{ route('profile#information',Auth::user()->id)}}"><i class="fa-solid fa-user fs-5"></i></a>
                </li>
                @else
                <li class="nav-item {{ request()->is('home') ? '' : 'd-none' }}">
                    <button class="nav-link item" onclick="document.getElementById('joinModal').style.display='block'">Join Us</button>
                </li>
                @endauth
                </ul>
            </div>
        </div>
    </nav>
@yield('content')
  <!-- Footer Section with Privacy & Cookie Links -->
  <footer class="bg-light text-dark">
    <div class="container pt-5">
      <h4 class=" fw-bold">FoodFusion</h4>
      <div class="row">
        <div class="col-lg-7 mt-3">
          <ul class=" d-flex justify-content-evenly">
            <li class=""><a href="{{ route('about#us')}}" class="text-decoration-none text-black">About</a></li>
            <li class=""><a href="{{ route('contact#us')}}" class="text-decoration-none text-black">Contact</a></li>
            <li class=""><a href="{{ route('cook_book#page')}}" class="text-decoration-none text-black">Community</a></li>
            <li class=""><a href="{{ route('resources','Culinary Resources')}}" class="text-decoration-none text-black">Resource</a></li>
          </ul>
        </div>
        <div class="col">
          <h6 class=" fw-bold">Get the fresh news</h6>
          <form action="subscribe.php" method="POST">
            <div class="input-group mb-3">
              <input type="email" class="mail-box" placeholder="Enter your email" name="email" required>
              <button  class="subscribeBtn btn btn-warning" type="submit">Subscribe</button>
            </div>
        </div>
      </div>
      <hr class="mt-5">
      <div class="row">
        <a class="col-lg-6 d-block text-dark" href="{{ route('legal#information') }}">
          <span>Term & Conditions</span> |
          <span>Privacy Policy</span> |
          <span>Cookie Policy</span>
        </a>
        <div class="offset-lg-2 col mt-4 mt-lg-0">
          <span class="mx-3  "><a href="https://www.facebook.com/"><i class="fa-brands fa-facebook  icon"></i></a></span>
          <span class="mx-3  "><a href="https://www.instagram.com/"><i class="fa-brands fa-instagram icon"></i></a></span>
          <span class="mx-3  "><a href="https://www.twitter.com/"><i class="fa-brands fa-twitter icon"></i></a></span>
          <span class="mx-3  "><a href="https://www.youtube.com/"><i class="fa-brands fa-youtube icon"></i></a></span>
        </div>
      </div>
      <p class="mt-4">&copy; 2025 FoodFusion. All rights reserved.</p>
    </div>
  </footer>
  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
@yield('scripts')
</body>
</html>
