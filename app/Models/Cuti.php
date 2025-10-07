<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\CutiDetail;

class Cuti extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function detail()
    {
        return $this->hasMany(CutiDetail::class, 'cuti_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_cuti');
    }

    public function pj(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_pj');
    }

    public function mg(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_tau');
    }

    public function mn(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_setuju');
    }
}
