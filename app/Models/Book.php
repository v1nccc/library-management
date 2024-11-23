<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'customer_id',
    ];

    public function customer()
{
    return $this->belongsTo(Customer::class, 'customer_id');
}

public function categories()
{
    return $this->belongsToMany(Category::class, 'book_category');
}


}
