@extends('layouts.app')
@section('title', 'About Us')
@section('styles')
<style>
     .hero {
      background-size: cover;
      color: black;
      padding: 80px 0;
      /* text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.7); */
    }
    .box {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #F97316;
      font-size: 1.5rem;
      background-color: #FFEED9;
      margin: auto;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
</style>
@section('content')
 <section class="hero text-center" style="background-color: #f8f8f4;">
    <div class="container">
      <h1 class="display-4 fw-bold">Welcome to FoodFusion</h1>
      <p class="lead">Where passion meets flavor and creativity meets tradition</p>
    </div>
      <div class="p-4 mt-5 mx-5 rounded text-white" style="background: linear-gradient(to right, #f96b1c, #ef3f37);">
        <h2 class="mb-4">Our Philosophy</h2>
          <p class="lead">
            At FoodFusion, we believe that cooking is more than just a task—it's an art form, a tradition,
            and a way to bring people together. Our goal is to make cooking accessible, enjoyable, and inspiring
            for everyone, from beginners to experienced chefs.
          </p>
      </div>
    <h2 class="mt-5 mb-4 text-center">Our Values</h2>
    <div class="mt-5 d-flex justify-content-around flex-wrap">
       <div style="width:300px" >
         <div class="box"><i class="fa-regular fa-heart fs-3"></i></div>
         <h4>Passion for Food</h4>
         <p>We believe that cooking is an expression of love and creativity that nourishes both body and soul.</p>
       </div>
        <div style="width:300px" class=" mt-3 mt-lg-0">
            <div class="box"><i class="fa-solid fa-people-group fs-3"></i></div>
            <h4>Community First</h4>
            <p>Our vibrant community of food enthusiasts shares knowledge, recipes, and culinary adventures.</p>
        </div>
        <div style="width:300px" class=" mt-3 mt-lg-0">
            <div class="box"><i class="fa-solid fa-globe fs-3"></i></div>
            <h4>Global Flavors</h4>
            <p>We celebrate diverse cuisines from around the world, bringing global flavors to your kitchen.</p>
        </div>
        <div style="width:300px" class=" mt-3 mt-lg-0">
            <div class="box"><i class="fa-solid fa-award fs-3"></i></div>
            <h4>Quality Content</h4>
            <p>Every recipe, tip, and tutorial is carefully curated to ensure the highest quality experience.</p>
        </div>
    </div>
    <h2 class="mt-5">Meet the Team</h2>
    <div class=" d-flex justify-content-around flex-wrap mt-4">
        <div class="card " style="width: 18rem;">
          <img src="{{ asset('storage/Team/adam.jpg')}}" class="card-img-top" alt="..." height="200px">
          <div class="card-body">
            <h5 class="card-title">Chef Adam</h5>
            <div class="text-warning">Founder & Head Chef</div>
            <p class="card-text">25+ years of culinary experience across Mediterranean and Latin American cuisines.</p>
          </div>
        </div>
        <div class="card  mt-4 mt-md-0" style="width: 18rem;">
          <img src="{{ asset('storage/Team/james.jpg')}}" class="card-img-top" alt="..." height="200px">
          <div class="card-body">
            <h5 class="card-title">James Chen</h5>
            <div class="text-warning">Community Manager</div>
            <p class="card-text">Passionate about building connections through food and fostering our global community.</p>
          </div>
        </div>
        <div class="card mt-4 mt-lg-0" style="width: 18rem;">
          <img src="{{ asset('storage/Team/sarah.jpg')}}" class="card-img-top" alt="..." height="200px">
          <div class="card-body">
            <h5 class="card-title">Sarah Thompson</h5>
             <div class="text-warning">Recipe Developer</div>
            <p class="card-text">Culinary school graduate specializing in healthy, accessible recipes for home cooks.</p>
          </div>
        </div>
    </div>
  </section>
@endsection
