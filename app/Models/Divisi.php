<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(User::class, 'divisi_id', 'id');
    }
}
