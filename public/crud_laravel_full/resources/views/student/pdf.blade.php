<!DOCTYPE html>
<html>
<head>

    {{-- Include CSS --}}
    <link href="{{ public_path('/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body>

    <h3>Data Siswa</h3>
    <hr>


    <table class="table table-bordered tabl">
        <thead>
            <th>No</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Prodi</th>
        </thead>

        <tbody>
            @forelse ( $student as $key => $value)
            <tr>
                <td>{{ $key+1}}</td>
                <td>{{ $value->nim}}</td>
                <td>{{ $value->nama}}</td>
                <td>{{ $value->prodi}}</td>
            </tr>
            @empty
            <tr>
                <td>Tidak ada data yang ditemukan !</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
