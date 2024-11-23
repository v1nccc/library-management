<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Book;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return view('categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::all(); 
        return view('categorydetails', compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255', 
            'books' => 'nullable|array', 
        ]);
    
        $category = Category::create([
            'name' => $validated['name'],
        ]);
    
        if (!empty($validated['books'])) {
            $category->books()->attach($validated['books']);
        }
    
        return redirect()->route('categories.index')->with('success', 'Category added successfully!');
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $books = Book::all(); 
        return view('categorydetails', compact('category', 'books'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'books' => 'nullable|array',
        ]);
    
        $category->update([
            'name' => $validated['name'],
        ]);
    
        if (!empty($validated['books'])) {
            $category->books()->sync($validated['books']);
        } else {
            $category->books()->detach();
        }
    
        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->books()->detach();
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}
