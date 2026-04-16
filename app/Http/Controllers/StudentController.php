<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Memanggil semua data mahasiswa dari database
        $students = Student::all();

        return view('student.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan form untuk menambahkan data mahasiswa baru
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Menyimpan data mahasiswa baru ke database
        $validatedData = $request->validate([
            'nim' => 'required|string|max:20|unique:students,nim',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'prodi' => 'required',
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'prodi.required' => 'Program studi wajib dipilih.',]
        );

        $students= new Student();
        $students->nim = $validatedData['nim'];
        $students->nama = $validatedData['nama'];
        $students->email = $validatedData['email'];
        $students->prodi = $validatedData['prodi'];
        
    if ($students->save()) {
            return redirect()->route('students.index')->with('success', 'Data mahasiswa berhasil disimpan.');
        } else {
            return redirect()->back()->with('error', 'Gagal menyimpan data mahasiswa. Silakan coba lagi.');
        }
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
