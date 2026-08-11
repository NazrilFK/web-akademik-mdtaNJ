<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'user_id',
        'judul',
        'isi',
        'warna',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}