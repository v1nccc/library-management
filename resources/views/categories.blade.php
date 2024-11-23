@extends('layouts.layout')

@section('title', 'Categories')

@section('content')
<div class="container">
    <h1 class="mb-4">Categories</h1>

    <div class="mb-3">
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Add New Category</a>
    </div>

    <table class="table  table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No categories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection