<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Agenda extends Model
{
    protected $table = "agendas";
    protected $fillable = [
        'judul',
        'tanggal',
        'tempat',
        'perihal',
        'pelaksana',
        'jam1',
        'jam2',
        'user_by',
        'status',
    ];


}
