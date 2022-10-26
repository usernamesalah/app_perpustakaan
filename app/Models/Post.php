<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'content',
        'status',
    ];

    protected $appends = ['tgl'];

    public function getTglAttribute()
    {
        return Carbon::parse($this->created_at)->isoFormat('MMMM Do YYYY');
    }
}
