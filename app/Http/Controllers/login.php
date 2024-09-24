<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class login extends Controller
{
    public function index(): View
    {
    return view('simpbb.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ],
        // [
        //     'username.required' => 'Username wajib diisi',
        //     'password.required' => 'Password wajib diisi'
        // ]
    );
    $infologin = [
        'username' => $request->username,
        'password' => $request->password
    ];
    if (Auth::attempt($infologin))
    {
        return redirect('/');
    }else
    {
        return redirect('')->withErrors('Username dan Password tidak sesuai.')->withInput();
    }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
