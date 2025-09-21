@extends('layouts.app')
@section('title', 'Contact Us')
@section('styles')
<style>
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
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
</style>
@section('content')
<section class="pt-5" style="background-color: #f8f8f4;">
    <div class="container">
      <h1 class="display-5 fw-bold text-center">Contact Us</h1>
      <p class="lead text-center">We’d love to hear from you! Send us your feedback, requests, or questions.</p>
    </div>
    <div class="row">
        <div class="col-md-6 p-5">
          <form action="{{ route('user#contact')}}" method="POST" class=" bg-white p-4 rounded rounded-4  shadow">
            @csrf
            <div class="mb-3">
            <label for="name" class="form-label">Your Name</label>
             <input type="text" name="name" class="form-control" id="name" required placeholder="John Doe" @auth value="{{ Auth::user()->first_name .' '. Auth::user()->last_name}} " @endauth>
             @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" id="email" required placeholder="john@exma" @auth value="{{ Auth::user()->email}}" @endauth>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            </div>
            <div class="mb-3">
              <label for="inquiry" class="form-label">Inquiry Type</label>
              <select name="inquiry_type" id="inquiry_type" class="form-select" required>
                <option value="general">General Inquiry</option>
                <option value="recipe">Recipe Request</option>
                <option value="feedback">Feed Back</option>
                <option value="partner_ship">Partner Ship</option>
                <option value="technical_support">Technical Support</option>
              </select>
                @error('inquiry_type')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
              <label for="name" class="form-label">Subject</label>
              <input type="text" name="subject" class="form-control" id="name" required placeholder="What's this about?" >
                @error('subject')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">Message</label>
              <textarea name="message" id="message" rows="5" class="form-control" required></textarea>
                @error('message')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-warning w-100 p-1">Send Message</button>
          </form>
        </div>
        <div class="col-md-6 p-5 text-white">
            <div class="p-4 rounded rounded-5"  style="background: linear-gradient(to right, #f96b1c, #ef3f37);">
                <h2>Get in Touch</h2>
                <p class=" fs-4">We're here to help you on your culinary journey. Whether you're a beginner cook or a seasoned chef, our team is ready to assist you with any questions or suggestions.</p>
                <div class="d-flex justify-content-start align-items-center">
                    <div class="box"><i class="fa-solid fa-envelope fs-3"></i></div>
                    <div class=" mt-3 ms-3">
                        <h5>Email Us</h5>
                        <p>hello@foodfusion.com</p>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-center">
                    <div class="box"><i class="fa-solid fa-phone fs-3"></i></div>
                    <div class=" mt-3 ms-3">
                        <h5>Call Us</h5>
                        <p>+95 9457014248</p>
                    </div>
                </div>
                <div class="d-flex justify-content-start align-items-center">
                    <div class="box"><i class="fa-solid fa-location-dot fs-3"></i></div>
                    <div class=" mt-3 ms-3">
                        <h5>Visit Us</h5>
                        <p>18 YanKine Street / Yangon, FC 12345</p>
                    </div>
                </div>
            </div>
             <div class="p-4 rounded rounded-4 bg-white shadow-sm text-dark mt-3" >
                <h4><i class="fa-regular fa-message" style=" color:#f96b1c"></i> Frequently Asked Questions</h4>
                <div class="mt-4">
                    <h5>How can I submit my own recipe?</h5>
                    <p class=" text-muted">Visit our Community Cookbook section and click "Share Your Recipe" to submit your culinary creations.</p>
                </div>
                <div class="mt-4">
                    <h5>Can I request specific recipes?</h5>
                    <p class=" text-muted">Absolutely! Use the contact form above and select "Recipe Request" to let us know what you'd like to see.</p>
                </div>
                <div class="mt-4">
                    <h5>How do I join cooking events?</h5>
                    <p class=" text-muted">Check our homepage for upcoming events and click "Register Now" to join our live cooking sessions.</p>
                </div>
            </div>
        </div>
      </div>
</section>
@endsection
