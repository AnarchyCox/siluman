<?php

namespace App\Exports;

use App\Models\Desa;
use App\Models\Peta;
use App\Models\Product;
use App\Models\Wilayah;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanPetaExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    /**
     * Create a new instance of the export class.
     *
     * @param \Illuminate\Support\Carbon $startDate
     * @param \Illuminate\Support\Carbon $endDate
     * @return void
     */
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        if (Auth::user()->role == 'God' || Auth::user()->role == 'Pusat'){
        return Peta::select('peta.created_at','peta.alasan','users.name','jenis_pengajuan.nama_jenis_pengajuan','products.nop','products.status_peta','products.nopel')
                         ->whereBetween('peta.created_at',[$this->startDate,Carbon::parse($this->endDate)->endOfDay()])
                         ->join('users','users.id_user','=','peta.id_user')
                         ->join('products','products.id','=','peta.id_berkas')
                         ->join('jenis_pengajuan','jenis_pengajuan.id_jenis_pengajuan','=','products.id_jenis_pengajuan')
                         ->orderBy('peta.created_at', 'asc')->get();
        }else{
        $iduser = Auth::user()->id_user;  
        return Peta::select('peta.created_at','peta.alasan','users.name','jenis_pengajuan.nama_jenis_pengajuan','products.nop','products.nopel','products.status_peta')
                         ->where('peta.id_user',$iduser)
                         ->whereBetween('peta.created_at',[$this->startDate,Carbon::parse($this->endDate)->endOfDay()])
                         ->join('users','users.id_user','=','peta.id_user')
                         ->join('products','products.id','=','peta.id_berkas')
                         ->join('jenis_pengajuan','jenis_pengajuan.id_jenis_pengajuan','=','products.id_jenis_pengajuan')
                         ->orderBy('peta.created_at', 'asc')->get();
        }
    }

    public function headings(): array
    {
        return [
            'Tanggal Input',
            'Nomor Pelayanan',
            'Nomor Objek Pajak',
            'Kecamatan',
            'Desa',
            'Jenis Pengajuan',
            'Nama User',
            'Status Peta',
            'Alasan ditolak',
        ];
    }

    public function map($product): array
    {
        // dd($product);
       $desa = substr(preg_replace('/[^a-zA-Z0-9]/', '', $product->nop), 0, 10);
       $kec = substr($product->nop, 6, 3);
       $desa = Desa::where('kode_desa','=',$desa)->get()->first();
       $kec = Wilayah::where('kode_wilayah','=',$kec)->get()->first();
       if ($kec !== null) {
        return [
            Carbon::parse($product->created_at)->format('d/m/Y'),
            $product->nopel,
            $product->nop,
            $kec->nama_wilayah,
            $desa->nama_desa,
            $product->nama_jenis_pengajuan,
            $product->name,
            $product->status_peta,
            $product->alasan,
        ];
    } else {
        return [
            Carbon::parse($product->created_at)->format('d/m/Y'),
            $product->nopel,
            $product->nop,
            'tidak ditemukan',
            $desa->nama_desa,
            $product->nama_jenis_pengajuan,
            $product->name,
            $product->status_peta,
            $product->alasan,
        ];
    }
    }
}