<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class JenisPengajuan extends Model
{
    use HasFactory;
    protected $table = 'jenis_pengajuan';
    protected $fillable = [
        'nama_jenis_pengajuan','id_jenis_pengajuan'
    ];
    public function products()
    {
        return $this->belongsTo(JenisPengajuan::class);
    }
}
