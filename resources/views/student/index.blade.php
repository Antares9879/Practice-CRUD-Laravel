<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Students | Laravel</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous">
    <style>
        .students-table {
            table-layout: fixed;
        }

        .students-table th,
        .students-table td {
            vertical-align: middle;
        }

        .students-table th:nth-child(1),
        .students-table td:nth-child(1),
        .students-table th:nth-child(2),
        .students-table td:nth-child(2) {
            text-align: center;
        }

        .students-table th:last-child,
        .students-table td:last-child {
            text-align: center;
            white-space: nowrap;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="container-fluid mt-4">

            <div class="card">
                <div class="card-header">
                    Data Siswa

                    <a href="{{ route('students.create') }}" type="button" class="btn btn-primary float-right">Tambah</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover students-table mb-0">
                            <colgroup>
                                <col style="width: 8%;">
                                <col style="width: 18%;">
                                <col style="width: 32%;">
                                <col style="width: 17%;">
                                <col style="width: 25%;">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Prodi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ( $students as $index => $data )
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $data->nim }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->prodi }}</td>
                                        <td>
                                            <a href="{{ route('students.edit', $data->id) }}" class="btn btn-sm btn-warning mr-1"><i class="bi bi-search"></i>Edit</a>
                                            <form method="POST" action="{{ route('students.destroy', $data->id) }}"
                                                class="d-inline-block js-confirm-form"
                                                data-confirm-title="Hapus Data?"
                                                data-confirm-text="Data yang dihapus tidak dapat dikembalikan.">
                                                @csrf @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-danger mr-1">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data untuk ditampilkan !</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
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
