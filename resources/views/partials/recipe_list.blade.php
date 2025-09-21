<div class="d-flex justify-content-evenly flex-wrap mt-4">
    @forelse ($recipes as $recipe)
        <div class="recipe-card mt-4"
             data-difficulty="{{ strtolower($recipe->difficulty) }}"
             data-preferences="{{ strtolower(collect($recipe->preferences)->pluck('name')->implode(',')) }}">
          <div class="recipe-image">
            <img src="{{ asset('storage/Recipes/'.$recipe->image) }}"
                 class="img-fluid w-100"
                 alt="Recipe Image"
                 style="height: 200px">
            <span class="badge-category">{{ $recipe->cuisine_name }}</span>
            <span class="badge-difficulty">{{ Str::ucfirst($recipe->difficulty) }}</span>
          </div>
          <div class="recipe-body">
            <h5 class="fw-bold">{{ $recipe->title }}</h5>
            <div class="d-flex justify-content-between recipe-meta mb-3">
              <span><i class="bi bi-clock"></i> {{ $recipe->time_taken }}</span>
            </div>
            <a class="view-btn btn" href="{{ route('recipe#details',$recipe->id) }}">View Recipe</a>
          </div>
        </div>
    @empty
        <h5 class="mt-5 text-warning">Not Found!</h5>
    @endforelse
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $recipes->links() }}
</div>
