@extends('layouts.layout')

@section('title', 'Customer Details')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Customer Details</h1>

    <div style="border: 1px solid; padding: 10px; margin-bottom: 20px;">
        <h3>Customer Information</h3>
        <form action="{{ isset($customer) ? route('customers.update', $customer->id) : route('customers.store') }}" method="POST">
            @csrf
            @if (isset($customer))
                @method('PUT')
                <input type="hidden" name="action" value="update_name">
            @endif
            <label for="name" style="display: block; margin-bottom: 5px;">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $customer->name ?? '') }}" style="width: 100%; margin-bottom: 10px;" required>
            <button type="submit" class="btn btn-primary">{{ isset($customer) ? 'Update Name' : 'Create Customer' }}</button>
        </form>
    </div>

    @if (isset($customer))
        <div style="border: 1px solid; padding: 10px; margin-bottom: 20px;">
            <h3>Borrowed Books</h3>
            @if ($borrowedBooks->isNotEmpty())
                <ul style="list-style-type: none; padding: 0;">
                    @foreach ($borrowedBooks as $book)
                        <li style="margin-bottom: 10px;">
                            {{ $book->title }}
                            <form action="{{ route('customers.update', $customer->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action" value="unborrow">
                                <input type="hidden" name="unborrow_books[]" value="{{ $book->id }}">
                                <button type="submit" class="btn btn-danger btn-sm">Return</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No books borrowed.</p>
            @endif
        </div>

        <div style="border: 1px solid #ccc; padding: 10px;">
            <h3>Borrow a Book</h3>
            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="action" value="borrow">
                <label for="borrowBook" style="display: block; margin-bottom: 5px;">Available Books:</label>
                <select id="borrowBook" name="borrow_books[]" style="width: 100%; margin-bottom: 10px;" required>
                    <option value="">Select a book</option>
                    @foreach ($availableBooks as $book)
                        <option value="{{ $book->id }}">{{ $book->title }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Borrow Book</button>
            </form>
        </div>
    @endif

    <div class="text-center mt-4">
        <a href="{{ route('customers.index') }}" class="btn btn-success">Done</a>
    </div>
</div>
@endsection
