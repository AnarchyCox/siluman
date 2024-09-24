<?php

namespace App\Http\Controllers;

use App\Exports\LaporanArsipExport;
use App\Exports\LaporanPetaExport;
use App\Models\Desa;
use App\Models\Peta;
use App\Models\Product;
use App\Models\Wilayah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Imagine\Image\Format;
use Maatwebsite\Excel\Facades\Excel;

class Laporan extends Controller
{
    public function index()
    {
        $today = today();
        $startDate = Carbon::today()->format('Y-m-d');
        $endDate = Carbon::today()->format('Y-m-d');
        if (Auth::user()->role == 'God' || Auth::user()->role == 'Pusat'){
        $simpbb = Product::select('*')
                         ->join('jenis_pengajuan','jenis_pengajuan.id_jenis_pengajuan','=','products.id_jenis_pengajuan')
                         ->join('users','users.id_user','=','products.id_user')
                         ->orderBy('products.created_at', 'desc')->get();
        }else{
            $iduser = Auth::user()->id_user;
            $simpbb = Product::select('*')
                         ->where('products.id_user',$iduser)
                         ->join('jenis_pengajuan','jenis_pengajuan.id_jenis_pengajuan','=','products.id_jenis_pengajuan')
                         ->join('users','users.id_user','=','products.id_user')
                         ->orderBy('products.created_at', 'desc')->get();
        }
        // dd($simpbb);
        return view('laporan.berkas',compact('simpbb','startDate','endDate'));
    }
    public function peta()
    {
        $today = today();
        $startDate = Carbon::today()->format('Y-m-d');
        $endDate = Carbon::today()->format('Y-m-d');
        $wilayah = Wilayah::all();
        $desa = Desa::all();
        if (Auth::user()->role == 'God' || Auth::user()->role == 'Pusat'){
        $simpbb = Peta::select('*')
                        ->join('products','products.id','=','peta.id_berkas')
                        ->join('users','users.id_user','=','peta.id_user')
                        ->join('jenis_pengajuan','jenis_pengajuan.id_jenis_pengajuan','=','products.id_jenis_pengajuan')
                        ->orderBy('peta.created_at', 'desc')->get();
        }else{
            $iduser = Auth::user()->id_user;
            $simpbb = Peta::select('*')
                         ->where('peta.id_user',$iduser)
                         ->join('products','products.id','=','peta.id_peta')
                         ->join('users','users.id_user','=','peta.id_user')
                         ->join('jenis_pengajuan','jenis_pengajuan.id_jenis_pengajuan','=','products.id_jenis_pengajuan')
                         ->orderBy('peta.created_at', 'desc')->get();
        }
        // dd($simpbb);
        return view('laporan.peta',compact('simpbb','startDate','endDate','wilayah','desa'));
    }
    public function getFilteredDataBerkas(Request $request)
    {
        // dd($request->start_date);
        $action = $request->action;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        if($action==="filter"){
            if (Auth::user()->role == 'God' || Auth::user()->role == 'Pusat'){
                     $simpbb = Product::select('*')
                     ->whereBetween('products.created_at',[$startDate,Carbon::parse($endDate)->endOfDay()])
                     ->join('jenis_pengajuan','jenis_pengajuan.id_jenis_pengajuan','=','products.id_jenis_pengajuan')
                     ->join('users','users.id_user','=','products.id_user')
                     ->orderBy('products.created_at', 'desc')->get();

                        $jmltoday=Product::whereBetween('updated_at',[$startDate,Carbon::parse($endDate)->endOfDay()])->count();
                        return view('laporan.berkas',compact('simpbb','startDate','endDate'));
            }else{
                    $iduser = Auth::user()->id_user;  
                    $simpbb = Product::select('*')
                    ->where('products.id_user',$iduser)
                    ->whereBetween('products.created_at',[$startDate,Carbon::parse($endDate)->endOfDay()])
                    ->join('jenis_pengajuan','jenis_pengajuan.id_jenis_pengajuan','=','products.id_jenis_pengajuan')
                    ->join('users','users.id_user','=','products.id_user')
                    ->orderBy('products.created_at', 'desc')->get();
                    
                    $jmltoday=Product::whereBetween('updated_at',[$startDate,Carbon::parse($endDate)->endOfDay()])->count();
                    return view('laporan.berkas',compact('simpbb','startDate','endDate'));
            }
        }elseif($action==="export-excell"){
            // Buat instance export dengan rentang tanggal
            $filename = "Laporan-arsip-berkas (" . Carbon::parse($startDate)->format('d-m-Y') . " sd " . Carbon::parse($endDate)->format('d-m-Y') . ").xlsx";
            return Excel::download(new LaporanArsipExport($startDate,$endDate), $filename);
        }
    }
    public function getFilteredDataPeta(Request $request)
    {
        // dd($request->start_date);
        $action = $request->action;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        if($action==="filter"){
            if (Auth::user()->role == 'God' || Auth::user()->role == 'Pusat'){
                     $wilayah = Wilayah::all();
                     $desa = Desa::all();
                     $simpbb =  Peta::select('*')
                    ->whereBetween('peta.created_at',[$startDate,Carbon::parse($endDate)->endOfDay()])
                     ->join('products','products.id','=','peta.id_berkas')
                     ->join('users','users.id_user','=','peta.id_user')
                     ->join('jenis_pengajuan','jenis_pengajuan.id_jenis_pengajuan','=','products.id_jenis_pengajuan')
                     ->orderBy('peta.created_at', 'desc')->get();

                     $jmltoday=Product::whereBetween('updated_at',[$startDate,Carbon::parse($endDate)->endOfDay()])->count();
                        return view('laporan.peta',compact('simpbb','startDate','endDate','wilayah','desa'));
            }else{
                    $iduser = Auth::user()->id_user;
                    $wilayah = Wilayah::all();
                    $desa = Desa::all();;  
                    $simpbb =  Peta::select('*')
                    ->where('products.id_user',$iduser)
                    ->whereBetween('peta.created_at',[$startDate,Carbon::parse($endDate)->endOfDay()])
                     ->join('products','products.id','=','peta.id_berkas')
                     ->join('users','users.id_user','=','peta.id_user')
                     ->join('jenis_pengajuan','jenis_pengajuan.id_jenis_pengajuan','=','products.id_jenis_pengajuan')
                     ->orderBy('peta.created_at', 'desc')->get();

                    $jmltoday=Product::whereBetween('updated_at',[$startDate,Carbon::parse($endDate)->endOfDay()])->count();
                    return view('laporan.peta',compact('simpbb','startDate','endDate','wilayah','desa'));
            }
        }elseif($action==="export-excell-peta"){
            // Buat instance export dengan rentang tanggal
            $filename = "Laporan-arsip-peta (" . Carbon::parse($startDate)->format('d-m-Y') . " sd " . Carbon::parse($endDate)->format('d-m-Y') . ").xlsx";
            return Excel::download(new LaporanPetaExport($startDate,$endDate), $filename);
        }
    }
}
