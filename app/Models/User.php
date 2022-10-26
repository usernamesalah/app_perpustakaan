<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'image',
        'location_id',
        'status',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['location_name', 'role_name', 'storage_image'];

    public function member()
    {
        return $this->hasOne(Member::class, 'user_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function getLocationNameAttribute()
    {
        $location = $this->location()->first();
        return isset($location) ? $location->name : 'Dinas Perpustakaan';
    }

    public function getRoleNameAttribute()
    {
        $role = $this->roles()->first(); 
        return $role->name.' '.$role->keterangan;
    }

    public function getStorageImageAttribute()
    {
        $url = ($this->image != '') ? url(Storage::url($this->image)) : asset('img/no_img.jpg');
        return $url;
    }
}
