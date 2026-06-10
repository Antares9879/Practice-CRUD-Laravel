<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function proses_register(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'email' => 'required|unique:admins,username',
            'password' => 'required',
            'password_confirm' => 'required|same:password'

        ], [
            'nama.required' => 'Kolom Nama tidak boleh kosong !',
            'email.required' => 'Kolom Email tidak boleh kosong !',
            'email.unique' => 'Email sudah digunakan !',
            'password.required' => 'Kolom Password tidak boleh kosong !',
            'password_confirm.required' => 'Kolom Konfirmasi Password tidak boleh kosong !',
            'password_confirm.same' => 'Password tidak sama !',

        ]);

        $admin = new Admin();

        // $user->name = $request->nama;
        // $user->email = $request->email;


        // $user->name = $request->nama;
        $admin->username = $request->email;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);

        if ($admin->save()) {
            return redirect()->back()->with([
                'notifikasi' => 'Register berhasil !',
                'type' => 'success'
            ]);
        } else {
            return redirect()->back()->with([
                'notifikasi' => 'Register gagal, silahkan coba lagi !',
                'type' => 'error'
            ]);
        }
    }


    public function halaman_register()
    {
        return view('auth/register');
    }

    public function halaman_login()
    {
        return view('auth/login');
    }

    public function proses_login(Request $request)
    {

        if (Auth::guard('admin')->attempt([
            'username' => $request->email,
            'password' => $request->password
        ])) {
            return redirect('/student')->with([
                'notifikasi' => 'Login berhasil !',
                'type' => 'success'
            ]);
        } else {
            return back()->with([
                'notifikasi' => 'Login gagal, E-Mail atau Password salah !',
                'type' => 'error'
            ]);
        }
    }

    public function proses_logout(Request $request)
    {
        Auth::guard('admin')->logout();

        return redirect('/login')->with([
            'notifikasi' => 'Logout berhasil !',
            'type' => 'success'
        ]);
    }
}
