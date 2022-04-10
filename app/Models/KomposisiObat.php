<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomposisiObat extends Model
{
    use HasFactory;
    protected $table = 'komposisi_obat';
    protected $fillable = ['racikan_kode','racikan_nama','obatalkes_kode','obatalkes_nama','obat_qty'];
}
