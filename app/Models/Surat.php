<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Surat extends Model
{
    protected $table = "adm_surat";

    protected $fillable = [
        'number',
        'msk_char',
        'instansi_id',
        'address',
        'perihal',
        'type',
        'tanggal',
        'document',
        'created_by',
        'updated_by',
        'status'
    ];

}
