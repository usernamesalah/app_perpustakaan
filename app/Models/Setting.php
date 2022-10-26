<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'denda',
        'max_pinjam',
        'hari_pinjam',
        'hari_extend',
        'alamat',
        'telpon',
        'email',
        'pemangku',
        'nip_pemangku',
        'hari_kerja',
        'jam_kerja',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
    ];

    public function getDendaAttribute($value)
    {
        return number_format($value, 0, ",", ".");
    }

    public function setDendaAttribute($value)
    {
        $this->attributes['denda'] = str_replace(",", ".", str_replace(".", "", $value));
    }
}
