<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\Book;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::with('borrowedBooks')->get();

        return view('customers', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $borrowedBooks = $customer->borrowedBooks;
        $availableBooks = Book::whereDoesntHave('customer')->get();
    
        return view('customerdetails', compact('customer', 'borrowedBooks', 'availableBooks'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $action = $request->input('action');
    
        switch ($action) {
            case 'update_name':
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                ]);
                $customer->update(['name' => $validated['name']]);
                return redirect()->route('customers.edit', $customer->id)->with('success','Name updated successfully!');
    
            case 'borrow':
                $validated = $request->validate([
                    'borrow_books' => 'required|array',
                    'borrow_books.*' => 'exists:books,id',
                ]);
                Book::whereIn('id', $validated['borrow_books'])->update(['customer_id' => $customer->id]);
                return redirect()->route('customers.edit', $customer->id)->with('success', 'Book(s) borrowed successfully!');
    
            case 'unborrow':
                $validated = $request->validate([
                    'unborrow_books' => 'required|array',
                    'unborrow_books.*' => 'exists:books,id',
                ]);
                Book::whereIn('id', $validated['unborrow_books'])->update(['customer_id' => null]);
                return redirect()->route('customers.edit', $customer->id)->with('success', 'Book(s) returned successfully!');
    
            default:
                return redirect()->route('customers.edit', $customer->id)->with('error', 'Invalid action!');
        }
    }
    
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully!');
    }
}
