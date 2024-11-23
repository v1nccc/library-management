@extends('layouts.layout')

@section('title', isset($category) ? 'Edit Category' : 'Add New Category')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">{{ isset($category) ? 'Edit Category' : 'Add New Category' }}</h1>

    <form action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}" method="POST">
        @csrf
        @if (isset($category))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" id="name" name="name" class="form-control" 
                   value="{{ old('name', $category->name ?? '') }}" required>
        </div>

<div class="mb-3">
    <label for="books" class="form-label">Associated Books</label>
    <div class="border p-2 rounded" style="max-height: 200px; overflow-y: auto;">
        @foreach ($books as $book)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="books[]" id="book-{{ $book->id }}" 
                       value="{{ $book->id }}" 
                       {{ isset($category) && $category->books->contains($book->id) ? 'checked' : '' }}>
                <label class="form-check-label" for="book-{{ $book->id }}">
                    {{ $book->title }}
                </label>
            </div>
        @endforeach
    </div>
</div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">{{ isset($category) ? 'Update Category' : 'Add Category' }}</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
