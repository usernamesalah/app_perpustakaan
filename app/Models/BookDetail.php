<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BookDetail extends Model
{
    use HasFactory;

    protected $table = 'book_details';

    protected $fillable = [
        'book_id',
        'location_id',
        'position',
        'source_id',
        'price',
        'status_id',
        'code'
    ];

    protected $appends = ['location_name', 'source_name', 'status_name', 'tgl_pengadaan'];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function getLocationNameAttribute()
    {
        return $this->location()->first()->name;
    }

    public function getSourceNameAttribute()
    {
        return $this->source()->first()->name;
    }

    public function getStatusNameAttribute()
    {
        return $this->status()->first()->name;
    }

    public function getPriceAttribute($value)
    {
        return number_format($value, 0, ",", ".");
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = str_replace(",", ".", str_replace(".", "", $value));
    }

    public function getTglPengadaanAttribute()
    {
        return Carbon::parse($this->created_at)->format('d-m-Y');
    }
}
