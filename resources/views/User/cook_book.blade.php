@extends('layouts.app')
@section('content')

@php
    use Carbon\Carbon;
@endphp
@section('styles')
    <style>
        .progress-circle {
          width: 45px;
          height: 45px;
          border-radius: 50%;
            background: conic-gradient(green 0% 50%, #ddd 50% 100%);
          position: relative;
          display: flex;
          align-items: center;
          justify-content: center;
          margin: auto;
        }

        .progress-circle .inner-circle {
          width: 30px;
          height: 30px;
          background: white;
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          font-weight: 600;
          color: #0d6efd;
        }
        .check-circle {
          width: 40px;
          height: 40px;
          border-radius: 50%;
          background-color: #198754; /* Bootstrap green */
          display: flex;
          align-items: center;
          justify-content: center;
          color: white;
          font-size: 1.5rem;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
<section class=" text-center py-5" style="background-color: #f8f8f4;">
    <div class="container">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show w-50 m-auto my-3" role="alert">
      <strong>Success!</strong> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if (session('status'))
    <div class="alert alert-warning alert-dismissible fade show w-50 m-auto my-3" role="alert">
      <strong>Status!</strong> {{ session('status') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
      <h1 class="display-5 fw-bold">Community Cookbook</h1>
      <p class="lead">Share your favorite recipes, discover new flavors, and connect with fellow food enthusiasts from around the world.</p>
      <a href="{{ route('recipe#addPage')}}" class=" btn btn-warning rounded-4">Share Your Recipe <i class="fa-solid fa-plus"></i></a>
    </div>
  </section>
  <div class="container mt-3">
    @if (count($userCookBooks) >= 1)
    <h4>Your Books</h4>
     @foreach ($userCookBooks as $book )
    <div class="row m-4 shadow-lg rounded-4">
        <div class="col-md-4 mt-2">
          <img src="{{ asset('storage/Recipes/'.$book->image)}}" class="w-100 p-3" alt="Recipe Image" style="height: 300px;">
        </div>
        <div class="col-md-8">
           <div class="d-flex justify-content-between">
            <div class="d-flex mt-4">
               @if ($user->image)
             <img src="{{ asset('storage/user/'.$user->image)}}" class="rounded-5 me-3" alt="" style="width:50px; height: 50px;">
               @else
             <img src="{{ asset('storage/user/default/default_user.jpg')}}" class="rounded-5 me-3" alt="" style="width:50px; height: 50px;">
               @endif
                 <div class=" d-flex flex-column justify-content-between">
                  <span>{{ $user->first_name.' '.$user->last_name}}</span>
                  @if ($book->published_at !== null)
                    <span>{{ Carbon::parse($book->published_at)->diffForHumans() }}</span>
                  @else
                      <span>Not Published Yet!</span>
                  @endif
                 </div>
            </div>
            <div class="mt-4">
                @if ($book->published_at !== null)
                <div class="check-circle">
                    <i class="fa-solid fa-check"></i>
                </div>
                @else
                <div class="progress-circle">
                    <div class="inner-circle"><small>50%</small></div>
                  </div>
                @endif
            </div>
           </div>
           <h3 class=" fw-bold mt-4">{{ $book->title}}</h3>
           <p class=" text-muted">{{$book->description}}</p>
           <div class="mt-4">
            @if ($book->published_at !== null)
            <span class="rounded bg-warning p-2 rounded-4">{{ Str::ucfirst($book->difficulty)}}</span>
            <span class=" ms-3">{{ $book->time_taken}}</span>
            <span class=" ms-3"> {{ number_format($book->average_rating ?? 0, 1) }} <i class="fa-solid fa-star text-warning"></i> </span>
            @endif
           </div>
           <div class=" d-flex justify-content-between mt-4 my-md-4 flex-wrap">
            <div class="">
              @if ($book->published_at !== null)
            <span class=""><i class="fa-regular fa-heart"></i> {{$book->reaction}}</span>
            <span class=" ms-3"><i class="fa-regular fa-comment"></i> {{ $book->comments_count }}</span>
            <span class=" ms-3"><i class="fa-regular fa-share-from-square"></i> Share</span>
            @if ($book->status == 'pending')
            <span class=" ms-3 text-warning"> {{ Str::ucfirst($book->status)}} </span>
            @elseif ($book->status == 'rejected')
            <span class=" ms-3 text-danger"> {{ Str::ucfirst($book->status)}}</span>
            @endif
              @endif
            </div>
            @if ($book->published_at !== null)
            <a href="{{route('recipe#details',$book->recipe_id)}}" class=" btn btn-outline-warning me-3 my-4 my-md-0">View Full Details</a>
            @else
            <a href="{{route('ingredient#addPage',$book->recipe_id)}}" class=" btn btn-outline-warning me-3 mt-4 my-md-0">Complete</a>
            @endif
           </div>
        </div>
      </div>
    @endforeach
    @endif
    <h4>All Books</h4>
     @foreach ($allBooks as $book )
    <div class="row m-4 shadow-lg rounded-4">
        <div class="col-md-4 mt-2">
          <img src="{{ asset('storage/Recipes/'.$book->image)}}" class="w-100 p-3" alt="Recipe Image" style="height: 300px;">
        </div>
        <div class="col-md-8">
           <div class="d-flex justify-content-between">
            <div class="d-flex mt-4">
                 @if ($book->user_image)
                 <img src="{{ asset('storage/user/'.$book->user_image)}}" class="rounded-5 me-3" alt="" style="width:50px; height: 50px;">
                   @else
                 <img src="{{ asset('storage/user/default/default_user.jpg')}}" class="rounded-5 me-3" alt="" style="width:50px; height: 50px;">
                   @endif
                 <div class=" d-flex flex-column justify-content-between">
                  <span>{{ $book->first_name.' '.$book->last_name}}</span>
                    <span>{{ Carbon::parse($book->published_at)->diffForHumans() }}</span>
                 </div>
            </div>
           </div>
           <h3 class=" fw-bold mt-4">{{ $book->title}}</h3>
           <p class=" text-muted">{{$book->description}}</p>
           <div class="mt-4">
            <span class="rounded bg-warning p-2 rounded-4">{{ Str::ucfirst($book->difficulty)}}</span>
            <span class=" ms-3">{{ $book->time_taken}}</span>
            <span class=" ms-3">{{ number_format($book->average_rating ?? 0, 1) }} <i class="fa-solid fa-star text-warning"></i> </span>
           </div>
           <div class=" d-flex justify-content-between mt-4 my-md-4 flex-wrap">
            <div class="">
            <span class=""><i class="fa-regular fa-heart"></i> {{$book->reaction}}</span>
              <span class=" ms-3"><i class="fa-regular fa-comment"></i> {{ $book->comments_count }}</span>
              <span class=" ms-3"><i class="fa-regular fa-share-from-square"></i> Share</span>
            </div>
            <a href="{{route('recipe#details',$book->recipe_id)}}" class=" btn btn-outline-warning me-3 my-4 my-md-0">View Full Details</a>
           </div>
        </div>
      </div>
     @endforeach
  </div>
@endsection
