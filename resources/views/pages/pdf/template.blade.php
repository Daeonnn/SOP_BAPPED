<!DOCTYPE html>
<html>
<head>
    <title>Data Bidang</title>
    <style>
        .tg {
            border-collapse: collapse;
            width: 100%;
        }
        .tg th, .tg td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>
    <table class="tg">
        <thead>
            <tr>
                <th colspan="3" class="center">
                    <img src="{{ public_path('img/bappeda.png') }}" alt="LOGO" style="height: 50px;">
                    <h3>PEMERINTAH KOTA PONTIANAK</h3>
                    <h4>Badan Perencanaan Pembangunan Daerah</h4>
                    <h5>{{ $data['bidang'] ?? 'Bidang tidak tersedia' }}</h5>
                </th>
            </tr>
            <tr>
                <th>No SOP</th>
                <th colspan="2">{{ $data['noSop'] }}</th>
            </tr>
            <tr>
                <th>Tgl Pembuatan</th>
                <th colspan="2">{{ $data['tglPembuatan'] }}</th>
            </tr>
            <tr>
                <th>Tgl Revisi</th>
                <th colspan="2">{{ $data['tglRevisi'] }}</th>
            </tr>
            <tr>
                <th>Tgl Aktif</th>
                <th colspan="2">{{ $data['tglAktif'] }}</th>
            </tr>
            <tr>
                <th>Nama SOP</th>
                <th colspan="2">{{ $data['namaSop'] }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Dasar Hukum</td>
                <td colspan="2">{{ $data['dasarHukum'] }}</td>
            </tr>
            <tr>
                <td>Kualifikasi Pelaksana</td>
                <td colspan="2">{{ $data['kualifikasiPelaksana'] }}</td>
            </tr>
            <tr>
                <td>Keterkaitan</td>
                <td colspan="2">{{ $data['keterkaitan'] }}</td>
            </tr>
            <tr>
                <td>Perlengkapan</td>
                <td colspan="2">{{ $data['perlengkapan'] }}</td>
            </tr>
            <tr>
                <td>Peringatan</td>
                <td colspan="2">{{ $data['peringatan'] }}</td>
            </tr>
            <tr>
                <td>Pencatatan</td>
                <td colspan="2">{{ $data['pencatatan'] }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
