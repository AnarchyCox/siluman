<?php

namespace App\Http\Controllers;

use App\Models\AktifitasUser;
use App\Models\Desa;
use App\Models\Peta;
use App\Models\Product;
use App\Models\Wilayah;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Petacontroller extends Controller
{
    public function index():View
    {
       

        $frontdate ="2024-08-22";
        $todate = "2024-08-22";
        $simpbb = Product::whereIn('products.id_jenis_pengajuan', ['1','2','5'])
                         // ->join('wilayahs','wilayahs.kode_wilayah','=',substr('products.nop', 6, 3))
                         ->join('jenis_pengajuan','jenis_pengajuan.id_jenis_pengajuan','=','products.id_jenis_pengajuan')
                         ->orderBy('created_at', 'desc')->get();
        $jmltoday=Product::whereBetween('updated_at',[$frontdate,Carbon::parse($todate)->endOfDay()])->count();
        $wilayah = Wilayah::all();
        $desa = Desa::all();
        $chartwil = DB::table('products')->pluck('nop');
        // foreach ($chartwil as $cwil)
        // {
        //     $uniqueArray = array_unique(substr($cwil, 6, 3));
        // }
        
        // // Mengubah koleksi menjadi array
        // // $namesArray = array_column($names, item);

        // // foreach ($names as $nm){
        // //     {{ $nm; }};
        // // }
        // // Menampilkan data chat peta
        // // $subs =(substr(nama_wilayah, 6, 3);
        // // $nama_wilayah = Product::->join('wilayahs','wilayahs.nama_wilayah','')
        // // ->groupBy('nama_wilayah')
        // // ->get();
        // // $nama_wilayah = ((substr($nama_wilayah->nama_wilayah, 6, 3)));

        // dd($uniqueArray);

        return view('peta.index',compact('simpbb','jmltoday','wilayah','chartwil','desa'));
    }
    public function tolakpeta():View
    {
        
        $frontdate ="2024-08-22";
        $todate = "2024-08-22";
        $simpbb = Product::whereIn('products.id_jenis_pengajuan', ['1','2','5'])
                         ->where('products.status_peta', '=', 'Rejected')
                         ->join('jenis_pengajuan','jenis_pengajuan.id_jenis_pengajuan','=','products.id_jenis_pengajuan')
                         ->join('peta','peta.id_berkas','=','products.id')
                         ->orderBy('products.created_at', 'desc')->get();
        $jmltoday=Product::whereBetween('updated_at',[$frontdate,Carbon::parse($todate)->endOfDay()])->count();
        $wilayah = Wilayah::all();
        $chartwil = DB::table('products')->pluck('nop');

        return view('peta.tolakpeta',compact('simpbb','jmltoday','wilayah','chartwil'));
    }
    public function edit($id)
    {
        $data = Product::findOrFail($id);
        return response()->json($data);
    }
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'status_peta' => 'required',
        // ]);
        // Product::find($simpbb);
        $data = Product::findOrFail($id);
        $data->status_peta = $request->input('status_peta');
        $data->save();
        // dd($data);
        
        $status = $data->status_peta;
        if($status == 'Approved'){
            $status = 'mengupdate peta';
        }else{
            $status = 'menolak untuk diupdate peta';
        }
        // Menambahkan aktifitas user
        AktifitasUser::create([
            'jenis_aktifitas' => $data->id_jenis_pengajuan,
            'nopel' => $data->nopel,
            'deskripsi' => 'telah ' . $status . ' dengan berkas nopel :',
            'nama_user' => Auth::user()->id_user,
            'role' => Auth::user()->role,
        ]);

        // Menambahkan keterangan detail di tabel peta
        $exists = Peta::where('id_berkas', $id)->exists();
        if ($exists) {
            if($request->input('alasan') <> ''){
                Peta::where('id_berkas', $id)->update([
                    'alasan' => $request->input('alasan'),
                    'id_user' => Auth::user()->id_user,
                    'id_berkas' => $id,
                ]);
            }else{
                Peta::where('id_berkas', $id)->update([
                    'alasan' => '',
                    'id_user' => Auth::user()->id_user,
                    'id_berkas' => $id,
                ]);
            }
        } else {
            if($request->input('alasan') <> ''){

                Peta::create([
                    'alasan' => $request->input('alasan'),
                    'id_user' => Auth::user()->id_user,
                    'id_berkas' => $id,
                ]);
            }else{
                Peta::create([
                    'alasan' => '',
                    'id_user' => Auth::user()->id_user,
                    'id_berkas' => $id,
                ]);
            }
        }
        
        return redirect()->route('peta')
        ->with('success', 'Update status peta Sukses');
    }
        // public function update(Request $request, $id)
        // {
        //     $item = Product::findOrFail($id);
        //     $item->name = $request->input('status_peta');
        //     $item->save();

        //     return response()->json($item);
        // }
        //
}
