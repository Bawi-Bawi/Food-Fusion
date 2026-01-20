@extends('layouts.app')
@section('title','Add a Recipe')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h4 text-center py-3">Add Recipe</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('recipe#addRecipe')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Recipe Title</label>
                            <input type="text" class="form-control" id="title" name="title" required >
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required ></textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                              <input type="text" class="form-control" id="category" name="category" required >
                            @error('category')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="cuisine" class="form-label">Cuisine Type</label>
                              <input type="text" class="form-control" id="cuisine" name="cuisine" required>
                            @error('cuisine')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="Preference" class="form-label">Preference</label>
                            @foreach ($preferences as $p)
                                <div>
                                    <input type="checkbox" name="preference[]" value="{{ $p->id }}" id="pref_{{ $p->id }}">
                                    <label for="pref_{{ $p->id }}">{{ $p->name }}</label><br>
                                </div>
                            @endforeach
                            @error('preference')
                                <div class="text-danger">{{ $message }}</div>

                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Recipe Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept=".jpg, .jpeg, .png, .gif" required>
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-warning">Add Recipe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
