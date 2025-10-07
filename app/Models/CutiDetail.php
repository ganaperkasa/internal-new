<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CutiDetail extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function cuti()
    {
        return $this->belongsTo(Cuti::class, 'cuti_id');
    }
}
