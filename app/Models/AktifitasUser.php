<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktifitasUser extends Model
{
    use HasFactory;
    protected $table = 'aktifitas_user';
    protected $fillable = [
        'nama_user','nama_user','jenis_aktifitas','nopel','role','deskripsi','id_user'
    ];
}
