@extends('layouts.layout')

@section('title', 'Customers')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Library Customers</h1>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Borrowed Books</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>
                            @if ($customer->borrowedBooks->isNotEmpty())
                                @foreach ($customer->borrowedBooks as $book)
                                    <span class="badge bg-secondary">{{ $book->title }}</span>
                                @endforeach
                            @else
                                <span>No borrowed books</span>
                            @endif
                        </td>                        
                        <td>
                            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">

                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this customer?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No customers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
