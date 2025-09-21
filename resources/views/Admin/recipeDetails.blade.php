@extends('layouts.admin_app')
@section('title','Recipe Details')
@section('styles')
<style>
    select {
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #ccc;
        background-color: #fff;
        font-size: 14px;
        color: #333;
        outline: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    select:hover {
        border-color: #007bff;
        box-shadow: 0 3px 6px rgba(0, 123, 255, 0.2);
    }
    select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.3);
    }
    option {
        padding: 10px;
    }
</style>
@endsection
@section('content')
@php
use Carbon\Carbon;
@endphp
<a href="{{ route('recipes#list')}}" class=" text-decoration-none text-dark"><i class="fa-solid fa-arrow-left fs-4"></i></a>
  <div class="mt-3">
    @if ($recipe->status == 'pending')
    <select name="status" class="statusSelect" data-id="{{ $recipe->id }}">
        <option value="">Set Status</option>
        <option value="approved">Approved</option>
        <option value="rejected">rejected</option>
    </select>
    @else
        {{-- nothing --}}
    @endif
    <h4 class="mt-3">{{$recipe->title}}</h4>
    <img src="{{ asset('storage/Recipes/'.$recipe->image)}}" class=" rounded" alt="" style="width:400px; height: 350px;">
    <small class=" d-block ">Category#{{$recipe->category_name}}.</small>
     <small class=" d-block">CuisineType#{{$recipe->cuisine_name}}.</small>

    <h4 class=" text-muted mt-3">Description</h4>
    <p>{{ $recipe->description}}</p>
    <h5 class=" text-muted">Ingredients:</h5>
    @if (count($ingredients) <= 0)
        <p class=" text-warning">Not Added!</p>
    @endif
    @foreach ($sections as $section )
    @if ($hasPreparation)
    <p class=" text-decoration-underline">{{ $section->title}}:</p>
    @endif
    <ul>
         @foreach ($ingredients as $i )
        <li>{{$i->ingredient}}</li>
        @endforeach
    </ul>
    @endforeach
    <h5 class=" text-muted">Directions:</h5>
    @if (count($directions) <= 0)
        <p class=" text-warning">Not Added!</p>
    @endif
    @foreach ($sections as $section )
    @if ($hasPreparation)
    <p class=" text-decoration-underline">{{ $section->title}}:</p>
    @endif
    <ul>
        @foreach ($directions as $i )
        <li>{{$i->direction}}</li>
        @endforeach
    </ul>
    @endforeach
</div>
<div class="mt-3">
    <p>Recipe By: {{ $recipe->last_name.' '.$recipe->first_name}}</p>
    @if ($recipe->published_at !== null)
    <p>Published: {{Carbon::parse($recipe->published_at)->format('l - jS/M/Y') }}</p>
    @else
    <div class="my-2 text-warning"> Not published Yet!</div>
    @endif
     <form action="{{ route('recipe#delete', $recipe->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
    </form>
</div>
@endsection
@section('scripts')
<script>
    document.querySelectorAll('.statusSelect').forEach(select => {
        select.addEventListener('change', async function () {
            let status = this.value;
            let recipeId = this.dataset.id;
            if (!status) return;
            try {
                let response = await fetch(`/recipe/change/status/${recipeId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: status })
                });

                let result = await response.json();
                if (result.success) {
                    location.href = 'http://127.0.0.1:8000/recipes/list'
                } else {
                    alert('Failed to update status.');
                }
            } catch (error) {
                console.error(error);
                alert('Error updating status.');
            }
        });
    });
    </script>
</script>
@endsection
