<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableObserver;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use HasFactory;
    use Sluggable;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'synopsis',
        'author_id',
        'category_id',
        'publisher_id',
        'isbn',
        'year_publication',
        'jumlah_halaman',
        'panjang',
        'lebar',
        'berat',
        'book_main_image',
        'slug',
    ];

    protected $appends = ['short_synopsis', 'author_name', 'category_name', 'publisher_name', 'storage_image'];

    public function getShortSynopsisAttribute()
    {
        $synopsis = strip_tags($this->synopsis);
        $dot      = strlen($synopsis) > 200 ? '...' : '';
        $synopsis = substr($synopsis,0,200).$dot;
        return ($this->synopsis == null) ? '-' : $synopsis;
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'publisher_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function details()
    {
        return $this->hasMany(BookDetail::class, 'book_id');
    }

    public function getAuthorNameAttribute()
    {
        return @$this->author()->first()->name;
    }

    public function getCategoryNameAttribute()
    {
        return @$this->category()->first()->name;
    }

    public function getPublisherNameAttribute()
    {
        return @$this->publisher()->first()->name;
    }

    public function getStorageImageAttribute()
    {
        $url = ($this->book_main_image != '') ? url(Storage::url($this->book_main_image)) : asset('img/no_img.jpg');
        return $url;
    }
}
