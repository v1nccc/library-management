@extends('layouts.layout')

@section('title', 'Books')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Books</h1>
        <form action="{{ route('books.index') }}" method="GET" class="mb-4">
            <div class="row">

                <div class="col-md-6">
                    <label for="category" class="form-label">Filter by Category:</label>
                    <div class="border p-2 rounded" style="max-height: 100px; overflow-y: auto;">
                        @foreach ($categories as $category)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}"
                                    id="category-{{ $category->id }}"
                                    {{ is_array(request('categories')) && in_array($category->id, request('categories')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="category-{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="borrowed_by" class="form-label">Filter by Borrowed By:</label>
                    <div class="border p-2 rounded" style="max-height: 100px; overflow-y: auto;">
                        @foreach ($customers as $customer)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="borrowed_by[]" value="{{ $customer->id }}"
                                    id="borrowed_by-{{ $customer->id }}"
                                    {{ is_array(request('borrowed_by')) && in_array($customer->id, request('borrowed_by')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="borrowed_by-{{ $customer->id }}">
                                    {{ $customer->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>

        <div class="mb-3">
            <a href="{{ route('books.create') }}" class="btn btn-primary    ">Add New Book</a>
        </div>

        @if($books->isEmpty())
            <p class="text-center">No books available</p>
        @else
        
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Categories</th>
                        <th>Borrowed By</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->title }}</td>
                            <td>
                                @foreach ($book->categories as $category)
                                    <span class="badge bg-secondary">{{ $category->name }}</span>
                                @endforeach
                            </td>
                            <td>{{ $book->customer->name ?? 'Not Borrowed' }}</td>
                            <td>
                                @if ($book->customer)
                                    <text>Borrowed</text>
                                @else
                                    <text>Available</text>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this book?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
