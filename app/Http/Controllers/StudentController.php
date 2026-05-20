<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;

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
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'prodi.required' => 'Program studi wajib dipilih.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Hanya file JPG, JPEG, dan PNG yang diperbolehkan.',
            'foto.max' => 'Ukuran file tidak boleh lebih dari 2MB.',]
        );

        $students= new Student();
        $students->nim = $validatedData['nim'];
        $students->nama = $validatedData['nama'];
        $students->email = $validatedData['email'];
        $students->prodi = $validatedData['prodi'];
        
        // Simpan foto jika ada
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('fotos', 'public');
            $students->foto = $fotoPath;
        }
        
        if ($students->save()) {
            return redirect()->route('students.index')->with('success', 'Data mahasiswa berhasil disimpan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data mahasiswa. Silakan coba lagi.');
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
        // Menampilkan form untuk mengedit data mahasiswa
        $student = Student::findOrFail($id);
        return view('student.edit', compact('student'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Memperbarui dan validasi data mahasiswa di database
        $validatedData = $request->validate([
            'nim' => 'required|string|max:20|unique:students,nim,' . $id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'prodi' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'prodi.required' => 'Program studi wajib dipilih.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Hanya file JPG, JPEG, dan PNG yang diperbolehkan.',
            'foto.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        $student = Student::findOrFail($id);

        $student->nim = $validatedData['nim'];
        $student->nama = $validatedData['nama'];
        $student->email = $validatedData['email'];
        $student->prodi = $validatedData['prodi'];

        // Simpan foto jika ada file baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($student->foto && Storage::disk('public')->exists($student->foto)) {
                Storage::disk('public')->delete($student->foto);
            }
            // Simpan foto baru
            $fotoPath = $request->file('foto')->store('fotos', 'public');
            $student->foto = $fotoPath;
        }

        if ($student->save()) {
            return redirect()->route('students.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data mahasiswa. Silakan coba lagi.');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Menambah fungsi firstOrFail untuk memastikan data ditemukan sebelum dihapus
        $student = Student::findOrFail($id);

        // Mengambil data foto
        $fotoPath = $student->foto;

        // Menghapus data mahasiswa dari database
        if ($student->delete()) {
            // Jika ada foto, hapus file foto dari storage
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath); 
            }
            // Redirect dengan pesan sukses
            return redirect()->route('students.index')->with('success', 'Data mahasiswa berhasil dihapus.');
        } else {
            // Redirect dengan pesan error jika gagal menghapus data mahasiswa
            return redirect()->route('students.index')->with('error', 'Gagal menghapus data mahasiswa. Silakan coba lagi.');
        }
    }
}
