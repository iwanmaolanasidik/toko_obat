<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResepDetail extends Model
{
    use HasFactory;
    protected $table = 'resep_detail';
    protected $fillable = ['kode_resep','nama_resep','obat_kode','obat_nama','signa_kode','signa_nama','qty'];
}
