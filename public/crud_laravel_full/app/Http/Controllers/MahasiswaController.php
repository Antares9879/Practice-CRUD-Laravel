<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class MahasiswaController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $perPage = $request->input('perPage', 10) ?? 10; // Ambil nilai perPage dari input

        $client = new Client(['base_uri' => env('APP_URL_LOCAL')]);
        $response = $client->request('GET', '/api/mahasiswa');
        $mahasiswa = json_decode($response->getBody()->getContents());
    
        // Ubah data ke dalam format array agar dapat digunakan untuk pagination
        $mahasiswa = collect($mahasiswa->data);
    
        // Hitung offset untuk pagination
        $currentPage = Paginator::resolveCurrentPage();
        $offset = ($currentPage - 1) * $perPage;
    
        // Potong data pada halaman tertentu
        $items = $mahasiswa->forPage($currentPage, $perPage);
    
        // Buat objek LengthAwarePaginator
        $paginator = new LengthAwarePaginator($items, $mahasiswa->count(), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath()
        ]);
    
        return view('mahasiswa.index', ['mahasiswa' => $paginator]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
