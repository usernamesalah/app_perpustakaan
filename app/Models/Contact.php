<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $fillable = [
        'name',
        'email',
        'no_telp',
        'subject',
        'message',
        'status',
    ];

    protected $appends = ['short_message', 'tgl_notif'];

    public function getShortMessageAttribute()
    {
        $message = substr(strip_tags($this->message),0,110);
        return $message;
    }

    public function getTglNotifAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}
