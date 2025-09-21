<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title')</title>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('build/style/admin_app.css') }}">
@yield('styles')
</head>
<body>
  <!-- Sidebar -->
    <nav class="sidebar" id="sidebar" aria-label="Sidebar Navigation">
    <div class="border-bottom d-flex">
      <img src="{{ asset('image/logo.png')}}" class="logo " alt="">
      <a href="{{ route('admin#dashboard')}}" class="bar"><span class="sidebar-text ms-2 fs-5 fw-bold">FoodFusion</span></a>
    </div>
    <a href="{{ route('admin#dashboard')}}" class="{{ request()->is('dashboard') ? 'active' : '' }} bar"><i class="fa-solid fa-user"></i><span class="sidebar-text ms-2">Users</span></a>
    <a href="{{ route('recipes#list')}}" class="{{ request()->is('recipes/list') ? 'active' : '' }} bar"><i class="fas fa-list"></i><span class="sidebar-text ms-2">Recipes</span></a>
    <a href="{{ route('admin#resources')}}" class="{{ request()->is('resources') ? 'active' : '' }} bar"><i class="fa-solid fa-book-atlas"></i><span class="sidebar-text ms-2">Resources</span></a>
    <a href="{{ route('event#list')}}" class="{{ request()->is('events/list') ? 'active' : '' }} bar"><i class="fa-solid fa-calendar"></i><span class="sidebar-text ms-2">Events</span></a>
    <a href="{{ route('contact#list')}}" class="{{ request()->is('contact/list') ? 'active' : '' }} bar"><i class="fa-solid fa-address-book"></i><span class="sidebar-text ms-2">Contacts</span></a>
    <form action="{{ route('account#logout')}}" class="bar" method="post">
        @csrf
        <button class="nav-link text-start" type="submit"><i class="fas fa-sign-out-alt me-2"></i><span class="sidebar-text ms-2">Logout</span></button>
    </form>

  </nav>

<!-- Mobile backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop"></div>
<!-- Main Content -->
    <main class="main-content" id="mainContent">
    <div class="d-flex align-items-center gap-2 mb-4">
      <button class="btn btn-outline-secondary" id="toggleBtn" aria-label="Toggle sidebar" aria-expanded="true" type="button">☰</button>
      <h1 class="h4 mb-0">Admin Dashboard</h1>
    </div>
    <hr>
    @yield('content')
    </main>
<script src="{{ asset('build/js/app.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
@yield('scripts')
</body>
</html>
