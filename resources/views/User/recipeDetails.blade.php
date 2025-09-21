@extends('layouts.app')
@section('content')
@section('styles')
<style>
    .star-rating {
      direction: rtl;
      font-size: 2.5rem;
      display: inline-flex;
    }

    .star-rating input[type="radio"] {
      display: none;
    }

    .star-rating label {
      color: #ccc;
      cursor: pointer;
      transition: color 0.2s;
    }

    .star-rating input:checked ~ label {
      color: #ffc107;
    }
    .heart-btn {
      font-size: 2.5rem;
      color: #ccc;
      background-color: transparent;
      border: none;
      cursor: pointer;
      transition: color 0.3s, background-color 0.3s;
      border-radius: 50%;
      padding: 10px;
    }

    .heart-btn.liked {
      color: #e25555;
    }
     .comment-box {
      border-bottom: 1px solid #e0e0e0;
      padding-bottom: 1rem;
      margin-bottom: 1rem;
    }

    .comment-user-icon {
      font-size: 2rem;
      color: #6c757d;
    }

    .comment-input {
      resize: none;
    }
</style>
@endsection
@php
use Carbon\Carbon;
@endphp
<section>
    <div class="container">
        <h3 class=" my-4">{{ $recipe->title }}</h3>
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('storage/Recipes/'.$recipe->image)}}" class="w-100 rounded" style="height: 400px;" alt="">
                    <input type="hidden" name="bookId" id="book" value="{{$book->id}}">
                <h4 class=" mt-4">Rate this recipe:</h4>
                   <div class=" d-flex justify-content-between">
                     <div class="star-rating">
                          <input type="radio" name="rating" id="star5" value="5">
                          <label for="star5"><i class="fa-regular fa-star"></i></label>

                          <input type="radio" name="rating" id="star4" value="4">
                          <label for="star4"><i class="fa-regular fa-star"></i></label>

                          <input type="radio" name="rating" id="star3" value="3">
                          <label for="star3"><i class="fa-regular fa-star"></i></label>

                          <input type="radio" name="rating" id="star2" value="2">
                          <label for="star2"><i class="fa-regular fa-star"></i></label>

                          <input type="radio" name="rating" id="star1" value="1">
                          <label for="star1"><i class="fa-regular fa-star"></i></label>
                      </div>
                    <button id="heartButton" class="heart-btn">
                        <i id="heartIcon" class="fa-regular fa-heart"></i>
                    </button>
                   </div>
                @auth
                 <h4 class=" mt-2">Comments</h4>
                 <form id="commentForm" class="mt-4">
                    <div class="mb-3">
                      <label for="comment" class="form-label">Add a comment</label>
                      <textarea class="form-control comment-input" id="comment" rows="3" placeholder="Write your comment..."></textarea>
                    </div>
                    <input type="hidden" id="book_id" value="{{ $book->id}}">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning">Post Comment</button>
                    </div>
                  </form>
                @else
                 <p class="mt-3"><a class=" text-warning" href="{{ route('login') }}">Join us</a> to comment this recipe.</p>
                @endauth

                 @if (count($comments) >= 1)
                <div class=" overflow-scroll " style="height:300px">
                    @foreach ($comments as $comment )
                    <div class="comment-box d-flex">
                      <div class="me-3">
                        <i class="fas fa-user-circle comment-user-icon"></i>
                      </div>
                      <div>
                        <strong>{{ $comment->user->last_name.' '. $comment->user->first_name}}</strong> <small class="text-muted">{{ Carbon::parse($comment->created_at)->diffForHumans() }}</small>
                        <p class="mb-0">{{ $comment->comment}}</p>
                      </div>
                    </div>
                    @endforeach
                  </div>
                 @else
                     <textarea class="form-control mt-3 text-center" disabled rows="3" placeholder="Not Comment yet!"></textarea>
                 @endif
            </div>
            <div class="col-md-6 mt-4 mt-md-0">
                <h4 class=" text-muted">Description</h4>
                <p>{{ $recipe->description}}</p>
                <h5 class=" text-muted">Ingredients:</h5>
                @foreach ($sections as $section )
                @if ($hasPreparation)
                <p class=" text-decoration-underline">{{ $section->title}}:</p>
                @else
                    {{-- nothing --}}
                @endif
                <ul>
                    @foreach ($ingredients as $i )
                    <li>{{$i->ingredient}}</li>
                    @endforeach
                </ul>
                @endforeach
                <h5 class=" text-muted">Directions:</h5>
                @foreach ($sections as $section )
                @if ($hasPreparation)
                <p class=" text-decoration-underline">{{ $section->title}}:</p>
                @else
                    {{-- nothing --}}
                @endif
                <ul>
                    @foreach ($directions as $i )
                    <li>{{$i->direction}}</li>
                    @endforeach
                </ul>
                @endforeach
            </div>
        </div>
        <div class=" mt-3">
            <p>Recipe By: {{ $user->last_name.' '.$user->first_name}}</p>
            <p>Published: {{Carbon::parse($recipe->published_at)->format('l - jS/M/Y') }}</p>
          @auth
            @if (Auth::user()->id == $recipe->user_id)
            <button class=" btn btn-danger" onclick="document.getElementById('deleteModal').style.display='block'" >Delete</button>
           @else
          @endauth
            {{-- nothing --}}
           @endif
        </div>
    </div>
</section>
 <!-- Modal -->
  <div id="deleteModal" class="modal" tabindex="-1" style="display:none;">
    <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
          <h5 class="" id="exampleModalLabel">Delete?</h5>
        </div>
        <div class="modal-body">
          Are you sure you want to delete?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary"  onclick="document.getElementById('deleteModal').style.display='none'">No</button>
          <a href="{{ route('recipe#delete',$recipe->id)}}" id="deleteUrl">
            <button type="submit" id="deleteBtn" class="btn btn-primary">Yes</button>
          </a>
        </div>
      </div>
    </div>
  </div>
{{-- model end --}}
@endsection
@section('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const bookIdInput = document.getElementById('book');
    const bookId = bookIdInput ? bookIdInput.value : null;

    //Rating stars
    document.querySelectorAll('input[name="rating"]').forEach(radio => {
      radio.addEventListener('change', function () {
        const rating = this.value;

        fetch('/rate', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({ rating: rating, book_id: bookId })
        })
        .then(res => res.json())
        .then(data => {
          alert(data.message);
        });
      });
    });
    //Heart
    const heartButton = document.getElementById('heartButton');
    const heartIcon = document.getElementById('heartIcon');

    if (heartButton && heartIcon) {
      heartButton.addEventListener('click', function () {
        heartButton.classList.toggle('liked');

        fetch('/love', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({ book_id: bookId })
        })
        .then(res => res.json())
        .then(data => {
          alert(data.message);
        });

        if (heartIcon.classList.contains('fa-regular')) {
          heartIcon.classList.remove('fa-regular', 'fa-heart');
          heartIcon.classList.add('fa-solid', 'fa-heart');
        } else {
          heartIcon.classList.remove('fa-solid', 'fa-heart');
          heartIcon.classList.add('fa-regular', 'fa-heart');
        }
      });
    }

    //Comment
    const commentForm = document.getElementById("commentForm");
    if (commentForm) {
      commentForm.addEventListener("submit", function(e) {
        e.preventDefault();
        const commentText = document.getElementById("comment").value;

        fetch("/add-comment", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({
            cook_book_id: bookId,
            comment: commentText
          })
        })
        .then(res => res.json())
        .then(data => {
          window.location.reload();
        })
        .catch(err => console.error(err));
      });
    }
  });
</script>

@endsection
