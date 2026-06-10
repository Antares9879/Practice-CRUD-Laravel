<!DOCTYPE html>
<html>
<head>


    <!-- Custom fonts for this template-->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">


    <!-- Custom styles for this template-->
    <link href="{{ public_path('/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* Tambahkan CSS Anda di sini */
        body {
            font-family: Arial, sans-serif;
            color: black;
        }

        h1 {
            color: #333;
        }

    </style>
</head>
<body>
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
