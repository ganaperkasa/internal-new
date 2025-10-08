<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Instansi;
use DB;

class Project extends Model
{
    protected $table = "adm_project";

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'instansi_id', 'id');
    }

}
