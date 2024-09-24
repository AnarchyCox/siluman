<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JenisPengajuan;
  
class Product extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'created_at as tglinput','nopel', 'nop', 'berkas','id_jenis_pengajuan','ktp','status_peta','id_user'
    ];
    public function jenispengajuan() 
    {
    return $this->belongsTo(JenisPengajuan::class);

    }
    public function user() 
    {
    return $this->belongsTo(User::class);
    }
}
