@extends('layouts.app')
@section('title','add ingredients')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h4 text-center py-3">Add Ingredients And Directions</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('ingredient#addIngredient', $recipe->id) }}">
                        @csrf
                        <h3>{{ $recipe->title}}</h3>
                        <div class="mb-3">
                            <label for="difficulty" class="form-label">Difficulty</label>
                            <select name="difficulty" class="form-control" id="">
                                <option value="easy">Easy</option>
                                <option value="medium">Medium</option>
                                <option value="hard">Hard</option>
                            </select>
                            @error('difficulty')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="time_taken" class="form-label">Time Taken</label>
                            <input type="text" name="timeTaken" id="" class="form-control" value="{{old('timeTaken')}}" placeholder="e.g. 30 minutes or 1 hour" required >
                            @error('timeTaken')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="ingredient" class="form-label">Ingredients:</label>
                             <textarea class="form-control" id="ingredient" name="ingredients" rows="10" required placeholder="List ingredients (one per line - )">{{old('ingredients')}}</textarea>
                            @error('ingredients')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="direction" class="form-label">Directions:</label>
                             <textarea class="form-control" id="direction" name="directions" rows="10" required placeholder="Step-by-step instructions" >{{old('directions')}}</textarea>
                            @error('directions')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-warning">Publish</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
