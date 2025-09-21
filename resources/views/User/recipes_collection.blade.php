@extends('layouts.app')
@section('title','recipes collection')
@section('content')
@section('styles')
<style>
    .recipe-card {
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      background: #fff;
      width: 15rem;
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
@php
use Carbon\Carbon;
@endphp
<section>
 <!-- recipe collection -->
  <div class="container">
    <div class="row my-5">
      <div class="col-sm-9">
        <form action="{{ route('recipes#collection')}}" method="GET">
            @csrf
            <input type="text" class="form-control w-75 mb-3" name="search" placeholder="Search by recipe or cuisine type" aria-label="Search" value="{{ request('search')}}">
        </form>
        <div class="d-flex justify-content-between">
          <h5>Recipes</h5>
            <div class="dropdown">
                <button class="btn border dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Category Type
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a href="{{ route('recipes#collection')}}" class="dropdown-item">All</a>
                @foreach ($categories as $category )
                <a class="dropdown-item"
                   href="{{ route('recipes#collection', ['categoryId' => $category->id]) }}">
                    {{ $category->name }}
                </a>
                @endforeach
                </div>
              </div>
        </div>
        <div id="recipes-container">
            @include('partials.recipe_list', ['recipes' => $recipes])
        </div>
      </div>
      <div class="col-sm-3">
        <h4>Filter</h4>
        <hr>
        <h6>Preferences</h6>
            @foreach ($preferences as $p )
            <div class="">
                 <input type="checkbox" class="preference-filter" value="{{ strtolower($p->name) }}"><span> {{$p->name}}</span>
            </div>
            @endforeach
        <hr>
        <h6>Difficulty</h6>
        <div class="">
          <input type="checkbox" name="" class="difficulty-filter" value="hard"><span> Hard</span>
        </div>
        <div class="">
          <input type="checkbox" name="" class="difficulty-filter" value="medium"><span> Medium</span>
        </div>
        <div class="">
          <input type="checkbox" name="" class="difficulty-filter" value="easy"><span> Easy</span>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('scripts')
{{-- <script>
document.addEventListener("DOMContentLoaded", function() {
    const difficultyCheckboxes = document.querySelectorAll(".difficulty-filter");
    const preferenceCheckboxes = document.querySelectorAll(".preference-filter");

    const recipeCards = document.querySelectorAll(".recipe-card");

    function filterRecipes() {
        const selectedDifficulties = Array.from(difficultyCheckboxes)
                                          .filter(cb => cb.checked)
                                          .map(cb => cb.value.toLowerCase());

        const selectedPreferences = Array.from(preferenceCheckboxes)
                                         .filter(cb => cb.checked)
                                         .map(cb => cb.value.toLowerCase());

        recipeCards.forEach(card => {
            const difficulty = card.dataset.difficulty;
            const preferences = card.dataset.preferences.split(',');

            // Difficulty check
            const difficultyMatch = (selectedDifficulties.length === 0 || selectedDifficulties.includes(difficulty));

            // Preference check (at least one selected preference must match recipe's preferences)
            const preferenceMatch = (selectedPreferences.length === 0 ||
                                     preferences.some(pref => selectedPreferences.includes(pref)));

            // Show/hide card
            if (difficultyMatch && preferenceMatch) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    }

    // Attach events
    difficultyCheckboxes.forEach(cb => cb.addEventListener("change", filterRecipes));
    preferenceCheckboxes.forEach(cb => cb.addEventListener("change", filterRecipes));
}); --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const difficultyCheckboxes = document.querySelectorAll(".difficulty-filter");
        const preferenceCheckboxes = document.querySelectorAll(".preference-filter");
        const recipesContainer = document.getElementById("recipes-container");
        let isFiltered = false;

        function checkIfFiltered() {
            const hasDifficultyFilter = Array.from(difficultyCheckboxes).some(cb => cb.checked);
            const hasPreferenceFilter = Array.from(preferenceCheckboxes).some(cb => cb.checked);
            isFiltered = hasDifficultyFilter || hasPreferenceFilter;
            return isFiltered;
        }

        function fetchFilteredRecipes(url = '/recipes/filter') {
            // Check current filter state
            const currentlyFiltered = checkIfFiltered();

            // If no filters are active and we're not on a filter page, do normal navigation
            if (!currentlyFiltered && url === '/recipes/filter') {
                window.location.href = '/recipes/collection';
                return;
            }

            const selectedDifficulties = Array.from(difficultyCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            const selectedPreferences = Array.from(preferenceCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            const params = new URLSearchParams();
            selectedDifficulties.forEach(d => params.append('difficulty[]', d));
            selectedPreferences.forEach(p => params.append('preferences[]', p));

            if (url !== '/recipes/filter') {
                const newUrl = new URL(url);
                selectedDifficulties.forEach(d => newUrl.searchParams.append('difficulty[]', d));
                selectedPreferences.forEach(p => newUrl.searchParams.append('preferences[]', p));
                url = newUrl.toString();
            }

            fetch(currentlyFiltered ? `${url}?${params.toString()}` : url)
                .then(res => res.json())
                .then(data => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        recipesContainer.innerHTML = data.html;
                        bindPaginationLinks();
                    }
                });
        }

        function bindPaginationLinks() {
            recipesContainer.querySelectorAll('.pagination a').forEach(link => {
                link.addEventListener('click', function (e) {
                    if (checkIfFiltered()) {
                        e.preventDefault();
                        fetchFilteredRecipes(this.href);
                    }
                });
            });
        }

        // Initial binding
        bindPaginationLinks();

        difficultyCheckboxes.forEach(cb => cb.addEventListener("change", () => {
            if (!checkIfFiltered()) {
                window.location.href = '/recipes/collection';
            } else {
                fetchFilteredRecipes();
            }
        }));

        preferenceCheckboxes.forEach(cb => cb.addEventListener("change", () => {
            if (!checkIfFiltered()) {
                window.location.href = '/recipes/collection';
            } else {
                fetchFilteredRecipes();
            }
        }));
    });
</script>
@endsection
