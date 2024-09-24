<?php

namespace App\Http\Controllers;

use App\Models\AktifitasUser;
use App\Models\Desa;
use App\Models\Peta;
use App\Models\Product;
use App\Models\Quote;
use App\Models\Wilayah;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Contracts\View\View;

class Home extends Controller
{
    // @return response();

    public function index(): View
    {
        $today = Carbon::yesterday();
        // $type = '2';
        // $jenispengajuan = [
        //     '1','2','3','4','5','6','7','8','9'
        // ];
        // foreach ($jenispengajuan as $jenispengajuans){
            //     $event[] = $qry->where('id_jenis_pengajuan', $jenispengajuans);
            // }
            // $event = $qry->where('id_jenis_pengajuan', '2');
            // dd($jenispengajuan);
        $hariIni = Carbon::today(); 
        $Kemaren = Carbon::yesterday(); 
        $data = [];

        $dates = [];
        for ($i = 6; $i >= 0; $i--) {
        $dates[] = $hariIni->copy()->subDays($i);
        }

        $qry = Product::query();
        $totals = $qry->select('id_jenis_pengajuan')
                      ->selectRaw('count(*) as total')
                      ->groupBy('id_jenis_pengajuan')
                      ->pluck('total','id_jenis_pengajuan');
        // dd($totals->get('3', 0));

        // Query untuk menampilkan daftar data peta
        $qrypetas = Product::whereIn('products.id_jenis_pengajuan', ['1','2','5'])
                           ->join('jenis_pengajuan','jenis_pengajuan.id_jenis_pengajuan','=','products.id_jenis_pengajuan')
                           ->orderBy('created_at', 'desc')->get();
        $peta = Peta::all();
        foreach ($qrypetas as $qrypeta) 
        {
        // Proses data dan simpan dalam array
        $data[] = substr($qrypeta->detail, 6, 3);
        }
        
        $wilayah = Wilayah::all();
        $desa = Desa::all();
        
        // Mengambil satu produk secara acak
        $randomquotes = Quote::inRandomOrder()->first();

        // Query untuk menjumlah berkas pusat
        $qrycountpusat = Product::join('users','users.id_user','=','products.id_user')
                                ->whereDate('products.created_at', Carbon::parse($hariIni))
                                ->whereIn('users.role', ['God','pusat']);
        $qrycountpusatkmren = Product::join('users','users.id_user','=','products.id_user')
                                ->whereDate('products.created_at', Carbon::parse($Kemaren))
                                ->whereIn('users.role', ['God','pusat'])->count();                       

        // Query untuk menjumlah berkas pusat
        $qrycountupt = Product::join('users','users.id_user','=','products.id_user')
                                ->whereDate('products.created_at', Carbon::parse($hariIni))
                                ->whereIn('users.role', ['UPT']);
        // dd($qrycountpusat->count());
        // Mulai query count untuk update peta
        $qrycountpeta = Product::whereIn('id_jenis_pengajuan', ['1','2','5'])
                                ->where('status_peta', 'Approved');

        // data report selama 7 hari terakhir
        foreach ($dates as $date){
        $pusat[] = Product::whereIn('users.role', ['God','pusat'])
                            ->whereDate('products.created_at', Carbon::parse($date))
                            ->join('users','users.id_user','=','products.id_user')->count();
        $upt[] = Product::where('users.role', 'upt')
                            ->whereDate('products.created_at', Carbon::parse($date))
                            ->join('users','users.id_user','=','products.id_user')->count();
        $jmlpeta[] = Peta::whereDate('created_at', Carbon::parse($date))->count();
                }
        // dd($pusat);
        $qrycountpeta = Product::whereIn('id_jenis_pengajuan', ['1','2','5'])
                                ->where('status_peta', 'Approved');

        // Hitung total amount
        $jmlupdatepeta = $qrycountpeta->count();
        // Hitung total berkas pusat
        $jmlupdatepusat = $qrycountpusat->count();
        // Hitung total berkas upt
        $jmlupdateupt = $qrycountupt->count();
        // aktitifitas user
        $recentActivities = AktifitasUser::select('*')
                                         ->selectRaw('aktifitas_user.created_at as jam')
                                         ->join('jenis_pengajuan','jenis_pengajuan.id_jenis_pengajuan','=','aktifitas_user.jenis_aktifitas')
                                         ->join('users','users.id_user','=','aktifitas_user.nama_user')
                                         ->orderBy('aktifitas_user.created_at', 'desc')->limit(10)->get();

        // dd($recentActivities);
        return view('simpbb.home',compact('totals','dates','jmlpeta','pusat','upt','qrypetas','jmlupdatepeta','jmlupdatepusat','jmlupdateupt','data','wilayah','randomquotes','recentActivities','desa','peta','qrycountpusatkmren','qrycountpusat'));
    }
    public function RandomQuote()
{

}
}
