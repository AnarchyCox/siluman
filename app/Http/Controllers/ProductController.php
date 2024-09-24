<?php
  
namespace App\Http\Controllers;

use App\Models\AktifitasUser;
use App\Models\Desa;
use App\Models\JenisPengajuan;
use App\Models\Product;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Carbon;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return response()
     */
    public function index(): View
    {
        $frontdate ="2024-08-22";
        $todate = "2024-08-22";
        $simpbb = User::select('jenis_pengajuan.*','users.*','products.created_at','products.*')
                         ->join('products','products.id_user','=','users.id_user')
                         ->join('jenis_pengajuan','jenis_pengajuan.id_jenis_pengajuan','=','products.id_jenis_pengajuan')
                         ->orderBy('products.created_at', 'desc')->get();

        $jmltoday=Product::whereBetween('updated_at',[$frontdate,Carbon::parse($todate)->endOfDay()])->count();
        return view('simpbb.index',compact('simpbb','jmltoday'));
        
        // return view('simpbb.show2');
    }
    public function show2(Request $request)
    {


        $jenis_layanan = $request->input('jenis_layanan');
        $tahun = $request->input('tahun');
        $nopel = $request->input('nomor_layanan');
        $nopberkas = Product::where('nopel', $nopel)->get();
        $desa = Desa::all();
        $kecamatan = Wilayah::all();

        // URL API dengan parameter jenia layanan
        $url = 'https://esppt.id/simpbb/api/data-nopel?jenis_layanan=' . $jenis_layanan . '&tahun='. $tahun;
        $mergedData = [];

        // Mengambil data dari API menggunakan Http facade
        $response = Http::post($url);
        // Mengecek apakah response berhasil
        if ($response->successful()) {
            // Mengambil data dari response
            $data = $response['data'];
            $filteredData = array_filter($data, function($item) use ($nopel) {
                return $item['nomor_layanan'] === $nopel;
            });

            $databaseDataByIdAndName = $nopberkas->keyBy(function ($item) {
                return $item->nopel . '-' . preg_replace('/[^a-zA-Z0-9]/', '', $item->nop);
            });
        
            foreach ($filteredData as $apiItem) {
                $key = $apiItem['nomor_layanan'] . '-' . $apiItem['nop_proses'];
        
                if (isset($databaseDataByIdAndName[$key])) {
                    // Menggabungkan data dari API dan database
                    $mergedData[] = array_merge($apiItem, $databaseDataByIdAndName[$key]->toArray());
                } else {
                    // Jika tidak ada data yang cocok di database, hanya tambahkan data dari API
                    $mergedData[] = $apiItem;
                }
            }
            return view('simpbb.show2', compact('mergedData','desa','kecamatan'));
        } else {
            // Mengembalikan pesan error jika API request gagal
            // return response()->json(['error' => 'Unable to fetch data'], 500);
            return view('simpbb.show2');
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $nopel = $request->input('nopel');
        $jl = $request->input('jela');
        $nop = preg_replace("/(\d{2})(\d{2})(\d{3})(\d{3})(\d{3})(\d{4})(\d{1})/","$1.$2.$3.$4.$5-$6.$7", $request->input('nop'));
        $jenis_pengajuan = JenisPengajuan::all();
        // dd($jl);
        return view('simpbb.create',compact('jenis_pengajuan','nop','nopel','jl'));
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'berkas' => 'required|file|mimes:pdf|max:2048',
            'ktp' => 'required|file|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $input = $request->all();
    
        if ($berkas = $request->file('berkas')) {
            $destinationPath = 'public/berkas/';
            $namaberkas = $input['nopel'] ."_". $input['nop'] . "." . $berkas->getClientOriginalExtension();
            $berkas->move($destinationPath, $namaberkas);
            $input['berkas'] = "$namaberkas";
        }
      
        // Product::create($input);
        // dd($input['ktp']);
        if ($ktp = $request->file('ktp')) {
            $destinationPath = 'public/ktp/';
            $namaktp = $input['nopel'] ."_". $input['nop'] . "." . $ktp->getClientOriginalExtension();
            $ktp->move($destinationPath, $namaktp);
            $input['ktp'] = "$namaktp";
        }else{
            $input['ktp'] = "no-image-ktp.png";
        }

        Product::create($input);

        AktifitasUser::create([
            'jenis_aktifitas' => $input['id_jenis_pengajuan'],
            'nopel' => $input['nopel'],
            'deskripsi' => 'telah menambahkan berkas dengan Nopel :',
            'nama_user' => Auth::user()->id_user,
            'role' => Auth::user()->role,
        ]);
    
        return redirect()->route('simpbb.index')
                         ->with('success', 'Input berkas sukses.');
    }
  
    /**
     * Display the specified resource.
     */
    public function show(Product $simpbb): View
    {
        $jenis_pengajuan = JenisPengajuan::all();
        $idjenispengajuan = JenisPengajuan::where('id_jenis_pengajuan','=', $simpbb->id_jenis_pengajuan)->get();
        $idjenispengajuan=$idjenispengajuan[0];
        return view('simpbb.show', compact('simpbb','jenis_pengajuan','idjenispengajuan'));
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $simpbb)
    {
        if ($simpbb->id_user == Auth::user()->id_user || Auth::user()->role == 'God' || Auth::user()->id_user == '104') {
            $jenis_pengajuan = JenisPengajuan::all();
            $idjenispengajuan = JenisPengajuan::where('id_jenis_pengajuan','=', $simpbb->id_jenis_pengajuan)->get();
            $idjenispengajuan=$idjenispengajuan[0];
            return view('simpbb.edit', compact('simpbb','jenis_pengajuan','idjenispengajuan'));
        }else{
            return redirect()->route('simpbb.index')
                         ->with('alert', 'Anda Tidak Mempunyai Akses Untuk Mengedit Berkas ini!');
        }
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $simpbb): RedirectResponse
    {
        
        $input = $request->all();
        
        if ($berkas = $request->file('berkas')) {
            File::delete('public/berkas/'.$simpbb->berkas);
            $destinationPath = 'public/berkas/';
            $namaberkas = $input['nopel'] ."_". $input['nop'] . "." . $berkas->getClientOriginalExtension();
            
            $berkas->move($destinationPath, $namaberkas);
            $input['berkas'] = "$namaberkas";
        }else{
            unset($input['berkas']);
        }
            
        $simpbb->update($input);
      
        if ($berkas = $request->file('ktp')) {
            File::delete('public/ktp/'.$simpbb->berkas);
            $destinationPath = 'public/ktp/';
            $namaberkas = $input['nopel'] ."_". $input['nop'] . "." . $berkas->getClientOriginalExtension();
            
            $berkas->move($destinationPath, $namaberkas);
            $input['ktp'] = "$namaberkas";
        }else{
            unset($input['ktp']);
        }
            
        $simpbb->update($input);

        AktifitasUser::create([
            'jenis_aktifitas' => $input['id_jenis_pengajuan'],
            'nopel' => $input['nopel'],
            'deskripsi' => 'telah mengubah data berkas dengan Nopel :',
            'nama_user' => Auth::user()->id_user,
            'role' => Auth::user()->role,
        ]);
        return redirect()->route('simpbb.index')
                         ->with('success', 'Edit berkas sukses');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    
    public function destroy(Product $simpbb): RedirectResponse
    {
        $berkas =Product::find($simpbb);
        file::delete('berkas/'.$simpbb->berkas);
        $berkas->each->delete();

        AktifitasUser::create([
            'jenis_aktifitas' => $simpbb['id_jenis_pengajuan'],
            'nopel' => $simpbb['nopel'],
            'deskripsi' => 'telah menghapus berkas dengan Nopel :',
            'nama_user' => Auth::user()->id_user,
            'role' => Auth::user()->role,
        ]);
        return redirect()->route('simpbb.index')
                         ->with('success', 'Hapus sukses.');
    }
}
