<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryDirectory extends Model
{
    use HasFactory;

    protected $table = 'gallery_directory';

    protected $fillable = [
        'title',
        'description',
    ];

    public function files()
    {
        return $this->hasMany(GalleryFiles::class, 'id_directory');
    }
}
