<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'no_member',
        'name',
        'user_id',
        'no_identity',
        'address',
        'agency',
        'no_telp',
        'type',
        'gender'
    ];

    protected $appends = ['tgl_daftar'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getTglDaftarAttribute()
    {
        return Carbon::parse($this->created_at)->isoFormat('Do-MMMM-YYYY');;
    }
}
