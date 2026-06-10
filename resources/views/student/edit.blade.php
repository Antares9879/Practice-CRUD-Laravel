@extends('layouts.admin')

@push('title')
Edit Siswa
@endpush

@section('content')

            <div class="card">
                <div class="card-header">
                    Edit Siswa

                    <a href="{{ route('students.index') }}" type="button" class="btn btn-danger float-right">Kembali</a>
                </div>

                <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data"
                    class="js-confirm-form"
                    data-confirm-title="Update Data?"
                    data-confirm-text="Pastikan data yang diubah sudah benar.">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="form-group">
                            <label for="nim">NIM <b class="text-danger">*</b></label>
                            <input required placeholder="Masukkan NIM" type="text" id="nim" name="nim"
                                class="form-control @error('nim') is-invalid @enderror"
                                value="{{ old('nim', $student->nim) }}">
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama <b class="text-danger">*</b></label>
                            <input required placeholder="Masukkan Nama" type="text" id="nama" name="nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $student->nama) }}">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">E-Mail <b class="text-danger">*</b></label>
                            <input required placeholder="Masukkan E-Mail" type="email" id="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $student->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="prodi">Prodi <b class="text-danger">*</b></label>
                            <select required id="prodi" name="prodi"
                                class="form-control @error('prodi') is-invalid @enderror">
                                <option value="">- Pilih Prodi -</option>
                                <option value="Teknik Rekayasa Keamanan Siber"
                                    {{ old('prodi', $student->prodi) == 'Teknik Rekayasa Keamanan Siber' ? 'selected' : '' }}>
                                    Teknik Rekayasa Keamanan Siber
                                </option>
                                <option value="Logistik Perdagangan Internasional"
                                    {{ old('prodi', $student->prodi) == 'Logistik Perdagangan Internasional' ? 'selected' : '' }}>
                                    Logistik Perdagangan Internasional
                                </option>
                                <option value="Teknologi Rekayasa Perangkat Lunak"
                                    {{ old('prodi', $student->prodi) == 'Teknologi Rekayasa Perangkat Lunak' ? 'selected' : '' }}>
                                    Teknologi Rekayasa Perangkat Lunak
                                </option>
                                <option value="Teknologi Game"
                                    {{ old('prodi', $student->prodi) == 'Teknologi Game' ? 'selected' : '' }}>
                                    Teknologi Game
                                </option>
                                <option value="Animasi" {{ old('prodi', $student->prodi) == 'Animasi' ? 'selected' : '' }}>
                                    Animasi
                                </option>
                            </select>

                            @error('prodi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="foto">Foto (ukuran maksimum 2MB, format: jpg/jpeg/png)</label>
                            <input type="file" id="foto" name="foto"
                                class="form-control-file @error('foto') is-invalid @enderror" accept=".jpg,.jpeg,.png">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    <div class="card-footer">
                        <a href="{{ route('students.index') }}" class="btn btn-danger">Batal</a>
                        <button type="reset" class="btn btn-warning">Reset</button>
                        <button type="submit" class="btn btn-success">Update</button>

            </div>
        </div>
    </div>

@endsection

@push('addon-script-footer')
<div id="flash-data"
    data-message="{{ session('success') ?? session('error') ?? session('notifikasi') }}"
    data-type="{{ session('success') ? 'success' : (session('error') ? 'error' : (session('type') ?? '')) }}">
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const flashElement = document.getElementById('flash-data');
        const flashMessage = flashElement ? flashElement.dataset.message : '';
        const flashType = flashElement ? flashElement.dataset.type : '';
        const swalIcon = ['success', 'error', 'warning', 'info', 'question'].includes(flashType) ? flashType : 'info';

        if (flashMessage) {
            Swal.fire({
                icon: swalIcon,
                title: swalIcon === 'success' ? 'Berhasil' : (swalIcon === 'error' ? 'Gagal' : 'Informasi'),
                text: flashMessage,
                confirmButtonText: 'OK'
            });
        }

        // tampilkan foto dalam modal saat diklik
        document.querySelectorAll('.foto-student').forEach(function (img) {
            img.addEventListener('click', function () {
                const studentName = this.getAttribute('data-student-name') || 'Foto Siswa';
                Swal.fire({
                    title: 'Foto - ' + studentName,
                    imageUrl: this.src,
                    imageAlt: studentName,
                    showCloseButton: true,
                    showConfirmButton: false,
                    imageWidth: 400,
                    imageHeight: 500,
                });
            });
        });

        // validasi foto client-side
        const fotoInput = document.getElementById('foto');
        if (fotoInput) {
            fotoInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!validTypes.includes(file.type)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Format Tidak Valid',
                            text: 'Hanya file JPG, JPEG, dan PNG yang diperbolehkan.',
                        });
                        this.value = '';
                    } else if (file.size > 2048 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ukuran Terlalu Besar',
                            text: 'Ukuran file tidak boleh lebih dari 2MB.',
                        });
                        this.value = '';
                    }
                }
            });
        }

        document.querySelectorAll('.js-confirm-form').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                Swal.fire({
                    title: form.dataset.confirmTitle || 'Konfirmasi',
                    text: form.dataset.confirmText || 'Apakah Anda yakin?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, lanjutkan',
                    cancelButtonText: 'Batal'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
