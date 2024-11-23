@extends('layouts.layout')

@section('title', isset($book) ? 'Edit Book' : 'Add New Book')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">{{ isset($book) ? 'Edit Book' : 'Add New Book' }}</h1>

    <form action="{{ isset($book) ? route('books.update', $book->id) : route('books.store') }}" method="POST">
        @csrf
        @if (isset($book))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="title" class="form-label">Book Title</label>
            <input type="text" id="title" name="title" class="form-control" 
                   value="{{ old('title', $book->title ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="categories" class="form-label">Categories</label>
            <div class="border p-2 rounded" style="max-height: 200px; overflow-y: auto;">
                @foreach ($categories as $category)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" id="category-{{ $category->id }}" 
                               value="{{ $category->id }}" 
                               {{ isset($book) && $book->categories->contains($category->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="category-{{ $category->id }}">
                            {{ $category->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mb-3">
            <label for="borrowed_by" class="form-label">Borrowed By</label>
            <select id="borrowed_by" name="customer_id" class="form-select">
                <option value="" {{ !isset($book) || !$book->customer ? 'selected' : '' }}>Not Borrowed</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" 
                        {{ isset($book) && $book->customer_id == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">{{ isset($book) ? 'Update Book' : 'Add Book' }}</button>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
