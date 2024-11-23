<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $customers = Customer::all(); 

        $query = Book::with(['categories', 'customer']);
    
        if ($request->has('categories') && is_array($request->categories)) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('categories.id', $request->categories);
            });
        }
        if ($request->has('borrowed_by') && is_array($request->borrowed_by)) {
            $query->whereIn('customer_id', $request->borrowed_by);
        }


        $books = $query->get();
    
        return view('books', compact('books', 'categories','customers'));
    }
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $customers = Customer::all();
        return view('bookdetails', compact('categories', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'categories' => 'nullable|array',
            'customer_id' => 'nullable|exists:customers,id',
        ]);

        $book = Book::create([
            'title' => $validated['title'],
            'customer_id' => $validated['customer_id'] ?? null,
        ]);

        if (!empty($validated['categories'])) {
            $book->categories()->attach($validated['categories']);
        }

        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
    $categories = Category::all();

    $customers = Customer::all();

    return view('bookdetails', compact('book', 'categories', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {

    $validated = $request->validate([
        'title' => 'required|string|max:255', 
        'customer_id' => 'nullable|exists:customers,id', 
        'categories' => 'nullable|array', 
    ]);

    $book->update([
        'title' => $validated['title'],
        'customer_id' => $validated['customer_id'] ?? null,
    ]);

    if (!empty($validated['categories'])) {
        $book->categories()->sync($validated['categories']);
    } else {
        $book->categories()->detach(); 
    }

    return redirect()->route('books.index')->with('success', 'Book updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
    $book->categories()->detach();

    $book->delete();

    return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }
}
