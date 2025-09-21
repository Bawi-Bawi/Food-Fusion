@extends('layouts.app')
@section('title', 'Culinary Resources')
@section('content')
@section('styles')
<style>
     .recipe-card {
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      background: #fff;
      width: 20rem;
    }
    .recipe-image {
      position: relative;
    }
    .badge-category, .badge-difficulty {
      position: absolute;
      top: 10px;
      padding: 5px 12px;
      border-radius: 50px;
      font-size: 0.8rem;
      font-weight: bold;
    }
    .badge-category {
      left: 10px;
      background: white;
      color: #333;
    }
    .badge-difficulty {
      right: 10px;
      background: #ff6b35;
      color: white;
    }
    .recipe-body {
      padding: 20px;
    }
    .recipe-meta {
      font-size: 0.9rem;
      height: 50px;
      color: #6c757d;
    }
    .recipe-meta i {
      margin-right: 5px;
    }
    .view-btn {
      background-color: #ff6b35;
      border: none;
      width: 100%;
      padding: 10px;
      font-weight: bold;
      border-radius: 8px;
      color: white;
      transition: background 0.3s;
    }
    .view-btn:hover {
      background-color: #e85c2c;
    }
</style>
@endsection
<section class="pt-5" style="background-color: #f8f8f4;">
<div class="container">
  <h1 class="display-5 fw-bold text-center">Culinary Resources</h1>
  <p class="lead text-center">Enhance your cooking skills with our comprehensive collection of downloadable guides, video tutorials, recipe cards, and educational materials.</p>
</div>
    <form action="">
        <input type="text" placeholder="Search resources..." name="search" class="form-control mb-4" style="max-width: 350px; margin: auto;" value="{{ request('search')}}">
    </form>
    <div class=" d-flex justify-content-center gap-3 mb-4">
        <a href="{{ route('resources', ['name'=>'Culinary Resources','filter' => 'all']) }}" class=" btn border rounded-4 {{ request('filter','all') === 'all' ? 'btn-warning' : '' }}">All</a>
        <a href="{{ route('resources', ['name'=>'Culinary Resources','filter' => 'video']) }}" class=" btn border rounded-4 {{ request('filter') === 'video' ? 'btn-warning' : '' }}">Videos</a>
        <a href="{{ route('resources', ['name'=>'Culinary Resources','filter' => 'pdf']) }}" class=" btn border rounded-4 {{ request('filter') === 'pdf' ? 'btn-warning' : '' }}">PDF Files</a>
    </div>
    @if (count($resources) == 0)
        <div class="text-center mt-3 fs-3 fw-bold">No resources found.</div>
    @else
    <div class="d-flex justify-content-center gap-3 flex-wrap p-3">
        @foreach ($resources as $resource)
            <div class="recipe-card mt-4">
              <div class="recipe-image">
                @if ( $resource->link == null)
                <img src="{{ asset('storage/image/'.$resource->image) }}"
                     class="img-fluid w-100"
                     alt="Recipe Image"
                     style="height: 200px">
                <span class="badge-difficulty">PDF</span>
                @else
                @php
                    $youtubeLink = str_replace("watch?v=", "embed/", $resource->link);
                @endphp
                <iframe
                    width="100%"
                    height="200"
                    src="{{$youtubeLink}}?autoplay=1&mute=1"
                    title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
                <span class="badge-difficulty">YouTube</span>
                @endif
              </div>
              <div class="recipe-body">
                <h5 class="fw-bold">{{ $resource->title}}</h5>
                <div class="d-flex justify-content-between recipe-meta mb-3">
                  <span><i class="bi bi-clock"></i> {{ $resource->description}}</span>
                </div>
                @if ( $resource->link == null)
                    <a class="view-btn btn" href="{{ asset('storage/file/'.$resource->file_path)}}" target="_blank"><i class="fa-solid fa-download"></i> Download </a>
                @else
                <a class="view-btn btn" href="{{ $resource->link}}" target="_blank"><i class="fa-solid fa-play" ></i> Play</a>
                @endif
              </div>
            </div>
        @endforeach
    </div>
    @endif
</section>
@endsection
@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
    })
</script>
@endsection
