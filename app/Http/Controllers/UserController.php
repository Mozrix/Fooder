<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function tampilkanFormMasuk()
    {
        return view('auth.login');
    }

    public function tampilkanFormDaftar()
    {
        return view('auth.register');
    }


    public function prosesDaftar(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:user,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        $user = User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => 'customer',
        ]);
    
        Auth::login($user);
    
        $request->session()->regenerate();
    
        return redirect()->route('customer.home');
    }    

    public function prosesMasuk(Request $request)
    {
        $kredensial = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($kredensial, $request->remember)) {
            $request->session()->regenerate();
            return $this->arahkanBerdasarkanRole(Auth::user()->role);
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ])->onlyInput('email');
    }

    public function prosesKeluar(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    private function arahkanBerdasarkanRole($role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'seller':
                return redirect()->route('seller.dashboard');
            default:
                return redirect()->route('customer.home');
        }
    }

    public function berandaCustomer()
    {
        return view('customer.home');
    }

    public function dashboardToko()
    {
        return view('seller.dashboard');
    }

    public function dashboardAdmin()
    {
        return view('admin.dashboard');
    }
}