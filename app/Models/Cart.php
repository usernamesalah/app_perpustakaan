<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    protected $fillable = [
        'member_id',
        'book_id'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}
