<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index () {

        $nama_saya = 'Gilang';
        return view('about', ['nama' => $nama_saya]); 
    }
}
