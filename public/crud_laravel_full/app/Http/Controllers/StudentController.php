<?php

namespace App\Http\Controllers;



use Dompdf\Dompdf;
use App\Models\Student;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller
{

    public function pdf()
    {

        $student = Student::all();
        $dompdf = new Dompdf();


        // Konfigurasi Dompdf untuk menghubungkan file CSS eksternal:
        $dompdf->getOptions()->setIsRemoteEnabled(true);
        $dompdf->getOptions()->setIsHtml5ParserEnabled(true);
        $dompdf->getOptions()->setChroot(public_path());
        $dompdf->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ])
        );


        // Render view dan load HTML
        $html = View::make('student.pdf', ['student' => $student])->render();
        $dompdf->loadHtml($html);

        // Set Ukuran Kertas dan Orientasi
        $dompdf->setPaper('A4', 'portrait');

        // Render ke PDF
        $dompdf->render();

        // Return pdf
        $dompdf->stream( uniqid(). '.pdf', ['Attachment' => false]);
    }

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // Memanggil seluruh data dari table Student
        $students = Student::all();

        // Reponse dalam bentuk Views
        return view(
            'student.index',
            [
                'students' => $students
            ]
        );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nim' => 'required|unique:students,nim',
            'nama' => 'required',
            'email' => 'required|email',
            'prodi' => 'required',

            // New Line 
            'foto' => 'required'
        ], [
            'nim.required' => 'NIM harus diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
            'nama.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'prodi.required' => 'Program studi harus diisi.',

            // New Line
            'foto.required' => 'Foto harus diupload.'
        ]);


        // New Line
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('public/foto');
            $foto = basename($foto);
        } else {
            $foto = null;
        }


        // Menambah Data Student Baru
        // Eloquent
        $students = new Student();
        $students->nim = $request->nim;
        $students->nama = $request->nama;
        $students->email = $request->email;
        $students->prodi = $request->prodi;
        $students->foto = $foto ? 'foto/' . $foto : null;

        if ($students->save()) {
            return redirect('/student')->with([
                'notifikasi' => 'Data Berhasil disimpan !',
                'type' => 'success'
            ]);
        } else {
            return redirect()->back()->with([
                'notifikasi' => 'Data gagal disimpan !',
                'type' => 'error'
            ]);
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

        $student = Student::where(['nim' => $id]);
        
        // DB::from('student')->where(['nim' => $id]);

        if ($student->count() != 1) {
            return redirect('/student')->with([
                'notifikasi' => 'Data Mahasiswa tidak ditemukan !',
                'type' => 'error'
            ]);
        }

        return view(
            'student.edit',
            ['student' => $student->first()]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $student = Student::where('nim', $id);

        if ($student->count() != 1) {
            return redirect('/student')->with([
                'notifikasi' => 'Data Mahasiswa tidak ditemukan !',
                'type' => 'error'
            ]);
        }

        $student = $student->first();


        $validatedData = $request->validate([
            'nim' => [
                'required',
                'unique:students,nim,' . $request->old_nim . ',nim',
            ],
            'nama' => 'required',
            'email' => 'required|email',
            'prodi' => 'required'
        ], [
            'nim.required' => 'NIM harus diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
            'nama.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'prodi.required' => 'Program studi harus diisi.'
        ]);

        // Cek Apakah Ganti Foto
        if ($request->ganti_foto == 1) {
            $request->validate([
                'foto' => 'required'
            ], [
                'foto.required' => 'Foto harus diupload.',
            ]);


            // New Line
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto')->store('public/foto');
                $foto = basename($foto);
                $foto = 'foto/' . $foto;
            } else {
                $foto = null;
            }
        } else {
            $foto = $student->foto;
        }

        // Foto lama
        $old_foto = $student->foto;

        $student->nim = $request->nim;
        $student->nama = $request->nama;
        $student->email = $request->email;
        $student->prodi = $request->prodi;
        $student->foto = $foto ?? null;

        if ($student->save()) {

            // Hapus file foto lama jika ada dan jika ganti foto
            if ($request->ganti_foto == 1) {

                if (!empty($old_foto) && is_file('storage/' . $old_foto)) {
                    unlink('storage/' . $old_foto);
                }
            }

            return redirect('/student')->with([
                'notifikasi' => 'Data Berhasil diedit !',
                'type' => 'success'
            ]);
        } else {

            return redirect()->back()->with([
                'notifikasi' => 'Data gagal diedit !',
                'type' => 'error'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Menambahkan fungsi firstOrFail
        $student = Student::where(['nim' => $id]);


        if ($student->count() != 1) {
            return redirect('/student')->with([
                'notifikasi' => 'Data Mahasiswa tidak ditemukan !',
                'type' => 'error'
            ]);
        }

        $student = $student->first();

        // Mengambil data foto
        $foto_siswa = $student->foto;

        if ($student->delete()) {

            // Hapus file foto jika ada
            if (!empty($foto_siswa) && is_file('storage/' . $foto_siswa)) {
                unlink('storage/' . $foto_siswa);
            }

            // Redirect dengan notifikasi
            return redirect('/student')->with([
                'notifikasi' => 'Data Berhasil dihapus !',
                'type' => 'success'
            ]);
        } else {
            return redirect()->back()->with([
                'notifikasi' => 'Data gagal dihapus !',
                'type' => 'error'
            ]);
        }
    }

    public function download(string $id)
    {
        $student = Student::where('nim', $id)->firstOrFail();

        $file_path = public_path('storage/' . $student->foto);
        $file_name = 'foto-' . $student->nim . '.' . pathinfo($file_path, PATHINFO_EXTENSION);

        return response()->download($file_path, $file_name);
    }

    public function preview(string $id)
    {
        $student = Student::where('nim', $id)->firstOrFail();

        $file_path = public_path('storage/' . $student->foto);

        return response()->file($file_path);
    }
}
