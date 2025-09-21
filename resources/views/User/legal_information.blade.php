@extends('layouts.app')
@section('title', 'Legal Information')
@section('styles')
<style>
    .hero {
      background-size: cover;
      color: black;
      padding: 70px 0;
      /* text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.7); */
    }
</style>
@section('content')
<section class="hero text-center" style="background-color: #f8f8f4;">
<div class="container">
  <h4 class="display-4 fw-bold">Legal Information</h4>
  <p class="lead">Our policies to help you understand how we work and protect your data.</p>
</div>
  <div class="p-4 mt-5 mx-5 rounded text-white" style="background: linear-gradient(to right, #f96b1c, #ef3f37);">
    <h2 class="mb-4">Terms & Conditions</h2>
      <p class="lead">
         By accessing and using FoodFusion, you agree to be bound by the following terms and conditions.
          You agree not to use our content for commercial purposes without permission, and not to engage
          in any activity that could damage or disrupt our service. We reserve the right to update or
          change these terms at any time.
      </p>
  </div>
     <div class="p-4 mt-5 mx-5 rounded text-white" style="background: linear-gradient(to right, #f96b1c, #ef3f37);">
        <h2 class="mb-4">Privacy Policy</h2>
          <p class="lead">
            FoodFusion respects your privacy. We may collect personal information such as your name and
              email when you contact us or submit forms. This information is used solely for communication
              and improvement of our services. We do not sell or share your data with third parties without
              consent. Your data is stored securely.
          </p>
      </div>
     <div class="p-4 mt-5 mx-5 rounded text-white" style="background: linear-gradient(to right, #f96b1c, #ef3f37);">
        <h2 class="mb-4">Cookie Policy</h2>
          <p class="lead">
            Our website uses cookies to enhance user experience, analyze site usage, and deliver
              personalized content. By using FoodFusion, you consent to our use of cookies. You can
              disable cookies in your browser settings, but this may affect your experience on our site.
          </p>
      </div>
</section>
@endsection
