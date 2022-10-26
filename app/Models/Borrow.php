<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $table = 'borrows';

    protected $fillable = [
        'user_id',
        'member_id',
        'exemplar_id',
        'date_borrow',
        'due_date',
        'date_return',
        'is_extend',
        'denda',
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
