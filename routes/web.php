<?php

use App\Http\Controllers\Home;
use App\Http\Controllers\Laporan;
use App\Http\Controllers\login;
use App\Http\Controllers\Petacontroller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Events\Logout;

    Route::middleware(['guest'])->group(function(){
    Route::get('/login',[login::class, 'index'])->name('login');
    Route::post('/login',[login::class, 'login']);

});

    Route::middleware(['auth'])->group(function(){
    Route::get('/peta/{id}/edit', [Petacontroller::class, 'edit'])->name('edit');
    Route::post('/peta/{id}/update', [Petacontroller::class, 'update'])->name('update');
    Route::resource('peta', Petacontroller::class);
    Route::resource('simpbb', ProductController::class);
    Route::post('addberkas', [ProductController::class, 'store'])->name('berkas.store');
    Route::get('add', [ProductController::class, 'show2'])->name('show2');
    Route::get('add2', [ProductController::class, 'create'])->name('add2');
    Route::post('filber', [Laporan::class, 'getFilteredDataBerkas'])->name('filber');
    Route::post('filpet', [Laporan::class, 'getFilteredDataPeta'])->name('filpet');
    Route::post('user/{id}',[UserController::class, 'update'])->name('user.update');
    Route::get('user',[UserController::class, 'index'])->name('user');
    Route::post('user',[UserController::class, 'store'])->name('user.store');
    // Route::resource('user', UserController::class);
    Route::get('/manageuser',[UserController::class, 'manageuser'])->name('manageuser');
    Route::post('/manageuser',[UserController::class, 'store'])->name('tambahuser');
    Route::get('/logout',[login::class, 'logout']);
    Route::get('/',[Home::class, 'index']);
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/manageusers', [UserController::class, 'showForm'])->name('images.form');
    Route::get('/lapberkas', [Laporan::class, 'index'])->name('lapberkas');
    Route::get('/lappeta', [Laporan::class, 'peta'])->name('lappeta');
    Route::post('/manageusers', [UserController::class, 'upload'])->name('images.upload');
    Route::get('tolakpeta',[Petacontroller::class, 'tolakpeta'])->name('tolakpeta');
    Route::get('peta',[Petacontroller::class, 'index'])->name('peta');
    Route::post('password/change',[UserController::class, 'changePassword'])->name('password.update');

    Route::get('/export-laporan-arsip', [Laporan::class, 'export'])->name('export-laporan-arsip');

    // Route::get('user',[UserController::class, 'index'])->name('user');
    
    // Route::get('user',function () {
    //     return view('user'); 
    // });
    // Route::get('/',function () {
    //     return redirect('home'); 
    // });
    // Route::get('peta', function () {
    //     return view('peta');
    // });
    // Route::get('simpbb/create', function () {
    //     return view('simpbb/create');
   
    // });
});


