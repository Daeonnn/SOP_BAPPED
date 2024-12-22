<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF SOP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .header-content {
            text-align: center;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .header-content img {
            width: 80px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="header-content">
        <img src="{{ public_path('img/bappeda.png') }}" alt="LOGO">
        <h1>PEMERINTAH KOTA PONTIANAK</h1>
        <p>Badan Perencanaan Pembangunan Daerah</p>
        <strong>{{ $bidang->name ?? 'Bidang tidak tersedia' }}</strong>
        <p>{{ $subBidang ? 'Subbag ' . $subBidang->name : '' }}</p>
    </div>

    <table>
        <tr>
            <th>No SOP</th>
            <td>{{ $sop->no_sop }}</td>
        </tr>
        <tr>
            <th>Tgl Pembuatan</th>
            <td>{{ $sop->tgl_pembuatan }}</td>
        </tr>
        <tr>
            <th>Tgl Revisi</th>
            <td>{{ $sop->tgl_revisi }}</td>
        </tr>
        <tr>
            <th>Tgl Aktif</th>
            <td>{{ $sop->tgl_aktif }}</td>
        </tr>
        <tr>
            <th>Nama SOP</th>
            <td>{{ $sop->name }}</td>
        </tr>
    </table>

    <h3>Dasar Hukum:</h3>
    <p>{{ $sop->dasar_hukum }}</p>

    <h3>Kualifikasi Pelaksana:</h3>
    <p>{{ $sop->kualifikasi_pelaksana }}</p>

    <h3>Keterkaitan:</h3>
    <p>{{ $sop->keterkaitan }}</p>

    <h3>Perlengkapan:</h3>
    <p>{{ $sop->perlengkapan }}</p>

    <h3>Peringatan:</h3>
    <p>{{ $sop->peringatan }}</p>

    <h3>Pencatatan:</h3>
    <p>{{ $sop->pencatatan }}</p>
</body>
</html>
