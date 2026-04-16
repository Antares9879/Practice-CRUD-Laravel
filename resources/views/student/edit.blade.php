<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Students Edit | Laravel</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="container-fluid mt-4">

            <div class="card">
                <div class="card-header">
                    Edit Siswa

                    <a href="{{ route('students.index') }}" type="button" class="btn btn-danger float-right">Kembali</a>
                </div>

                <form action="{{ route('students.update', $student->id) }}" method="POST"
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
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('students.index') }}" class="btn btn-danger">Batal</a>
                        <button type="reset" class="btn btn-warning">Reset</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <div id="flash-data"
        data-message="{{ session('success') ?? session('error') ?? session('notifikasi') }}"
        data-type="{{ session('success') ? 'success' : (session('error') ? 'error' : (session('type') ?? '')) }}">
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
</body>

</html>
