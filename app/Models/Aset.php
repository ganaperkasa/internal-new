<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Aset extends Model
{
    protected $table = "adm_aset";

     protected $fillable = [
        'barang_id',
        'instansi_id',
        'number',
        'name',
        'nominal',
        'keterangan',
        'spesifikasi',
        'kondisi',
        'document',
        'tanggal_pembelian',
        'tanggal_penerimaan',
        'time_perawatan',
        'created_by',
        'updated_by',
        'status',
    ];

    public $timestamps = true;

}
