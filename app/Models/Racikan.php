<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Racikan extends Model
{
    use HasFactory;
    protected $table = 'racikan';
    protected $fillable = ['racikan_kode','racikan_nama','obatalkes_kode','obatalkes_nama', 'signa_kode','signa_nama'];
}
