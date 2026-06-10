@extends('layouts.admin')

@push('title')
Data Siswa
@endpush

@push('addon-script-head')
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

    .foto-student {
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .foto-student:hover {
        transform: scale(1.05);
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.3);
    }
</style>
@endpush

@section('content')

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
                                    <th>Foto</th>
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
                                            @if ($data->foto)
                                                <img src="{{ asset('storage/' . $data->foto) }}" alt="Foto {{ $data->nama }}" class="img-thumbnail foto-student" style="max-width: 100px; max-height: 100px; cursor: pointer;" data-student-name="{{ $data->nama }}">
                                            @else
                                                <span class="text-muted">Tidak ada foto</span>
                                            @endif
                                        </td>
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
