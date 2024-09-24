<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peta extends Model
{
    use HasFactory;
    protected $table = 'peta';
    protected $fillable = [
        'id_peta','id_berkas', 'alasan','id_user', 'updated_at', 'created_at'
    ];
}
