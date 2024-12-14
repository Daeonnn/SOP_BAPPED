<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $nama_sop }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header-content {
            text-align: center;
            margin-bottom: 20px;
        }
        .header-content img {
            width: 100px;
            height: auto;
        }
        .header-content strong {
            display: block;
            font-size: 18px;
            margin-top: 5px;
        }
        .table-container {
            width: 100%;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        textarea {
            width: 100%;
            border: none;
            resize: none
            padding: 5px;
            font-family: inherit;
            font-size: inherit;
        }
        .signatory {
            text-align: center;
            margin-top: 30px;
        }
        .signatory img {
            width: 100px;
            height: auto;
        }
        .signatory div {
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header-content">
            <img src="{{ asset('img/bappeda.png') }}" alt="LOGO">
            <strong>PEMERINTAH KOTA PONTIANAK</strong>
            Badan Perencanaan Pembangunan Daerah
            <div style="margin-top: 20px; text-transform: uppercase;">
                {{ $bidang->name ?? 'Bidang tidak tersedia' }}
            </div>
            <div>
                {{ $subBidang ? 'Subbag ' . $subBidang->name : '' }}
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No SOP</th>
                    <td>{{ $no_sop }}</td>
                </tr>
                <tr>
                    <th>Tgl Pembuatan</th>
                    <td>{{ $tgl_pembuatan }}</td>
                </tr>
                <tr>
                    <th>Tgl Revisi</th>
                    <td>{{ $tgl_revisi }}</td>
                </tr>
                <tr>
                    <th>Tgl Aktif</th>
                    <td>{{ $tgl_aktif }}</td>
                </tr>
                <tr>
                    <th>Disahkan Oleh</th>
                    <td class="signatory">
                        <div>Ketua MUI Hizbullah</div>
                        <div>
                            <img src="{{ asset('img/ttd.png') }}" alt="Tanda Tangan">
                        </div>
                        <div style="text-decoration: underline;">Doni Hasan Nasarallah</div>
                        <div>NIP: 123456789</div>
                        <div>Sekretaris Pembina IV/A</div>
                    </td>
                </tr>
                <tr>
                    <th>Nama SOP</th>
                    <td>{{ $nama_sop }}</td>
                </tr>
            </thead>
        </table>

        <table>
            <thead>
                <tr>
                    <th>Dasar Hukum</th>
                    <th>Kualifikasi Pelaksana</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <textarea readonly>{{ $dasar_hukum }}</textarea>
                    </td>
                    <td>
                        <textarea readonly>{{ $kualifikasi_pelaksana }}</textarea>
                    </td>
                </tr>
                <tr>
                    <th>Keterkaitan</th>
                    <th>Perlengkapan</th>
                </tr>
                <tr>
                    <td>
                        <textarea readonly>{{ $keterkaitan }}</textarea>
                    </td>
                    <td>
                        <textarea readonly>{{ $perlengkapan }}</textarea>
                    </td>
                </tr>
                <tr>
                    <th>Peringatan</th>
                    <th>Pencatatan</th>
                </tr>
                <tr>
                    <td>
                        <textarea readonly>{{ $peringatan }}</textarea>
                    </td>
                    <td>
                        <textarea readonly>{{ $pencatatan }}</textarea>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>
</html>
