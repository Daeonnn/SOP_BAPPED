@extends('layouts.admin')

@section('title', 'Tabel Kegiatan')

@section('content')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 5px 10px;
            margin: 5px;
            cursor: pointer;
        }

        .btn-add {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
            border: none;
        }

        .status-images {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 10px;
        }

        .status-image {
            width: 30px;
            height: 30px;
        }
    </style>

    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">Bentuk Flowchart</h3>
                <div class="status-images">
                    <img src="https://via.placeholder.com/30" alt="Mulai/Selesai" class="status-image" title="Mulai/Selesai">
                    <img src="https://via.placeholder.com/30" alt="Proses" class="status-image" title="Proses">
                    <img src="https://via.placeholder.com/30" alt="Pilihan" class="status-image" title="Pilihan">
                </div>
                <button class="btn btn-add" onclick="addActivity()">Tambah Aktivitas</button>
            </div>
            <div class="card-body">
                <table id="activityTable">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Kegiatan</th>
                            <th colspan="3">Pelaksana</th>
                            <th colspan="3">Mutu Buku</th>
                            <th rowspan="2">Keterangan</th>
                            <th rowspan="2">Aksi</th>
                        </tr>
                        <tr>
                            <th>Ketua</th>
                            <th>Wakil</th>
                            <th>Sekretaris</th>
                            <th>Kelengkapan</th>
                            <th>Waktu</th>
                            <th>Output</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Kegiatan A</td>
                            <td>
                                <div>
                                    <select id="statusSelect">
                                        <option value="" disabled selected></option>
                                        <option value="mulai_selesai">Mulai/Selesai</option>
                                        <option value="proses">Proses</option>
                                        <option value="pilihan">Pilihan</option>
                                    </select>
                                </div>
                            </td>
                            <td><div>
                                <select id="statusSelect">
                                    <option value="" disabled selected></option>
                                    <option value="mulai_selesai">Mulai/Selesai</option>
                                    <option value="proses">Proses</option>
                                    <option value="pilihan">Pilihan</option>
                                </select>
                            </div>
                        </td>
                            <td><div>
                                <select id="statusSelect">
                                    <option value="" disabled selected></option>
                                    <option value="mulai_selesai">Mulai/Selesai</option>
                                    <option value="proses">Proses</option>
                                    <option value="pilihan">Pilihan</option>
                                </select>
                            </div>
                        </td>
                            <td>Lengkap</td>
                            <td>On Time</td>
                            <td>Baik</td>
                            <td>Catatan A</td>
                            <td><button class="btn btn-delete" onclick="deleteRow(this)">Hapus</button></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Kegiatan B</td>
                            <td><div>
                                <select id="statusSelect">
                                    <option value="" disabled selected></option>
                                    <option value="mulai_selesai">Mulai/Selesai</option>
                                    <option value="proses">Proses</option>
                                    <option value="pilihan">Pilihan</option>
                                </select>
                            </div></td>
                            <td><div>
                                <select id="statusSelect">
                                    <option value="" disabled selected></option>
                                    <option value="mulai_selesai">Mulai/Selesai</option>
                                    <option value="proses">Proses</option>
                                    <option value="pilihan">Pilihan</option>
                                </select>
                            </div></td>
                            <td><div>
                                <select id="statusSelect">
                                    <option value="" disabled selected></option>
                                    <option value="mulai_selesai">Mulai/Selesai</option>
                                    <option value="proses">Proses</option>
                                    <option value="pilihan">Pilihan</option>
                                </select>
                            </div></td>
                            <td>Kurang</td>
                            <td>Terlambat</td>
                            <td>Cukup</td>
                            <td>Catatan B</td>
                            <td><button class="btn btn-delete" onclick="deleteRow(this)">Hapus</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function addActivity() {
            const table = document.getElementById('activityTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();

            const cellNo = newRow.insertCell(0);
            const cellActivity = newRow.insertCell(1);
            const cellKetua = newRow.insertCell(2);
            const cellWakil = newRow.insertCell(3);
            const cellSekretaris = newRow.insertCell(4);
            const cellKelengkapan = newRow.insertCell(5);
            const cellWaktu = newRow.insertCell(6);
            const cellOutput = newRow.insertCell(7);
            const cellKeterangan = newRow.insertCell(8);
            const cellActions = newRow.insertCell(9);

            const rowCount = table.rows.length;
            cellNo.innerHTML = rowCount;
            cellActivity.innerHTML = `<input type="text" placeholder="Nama Kegiatan">`;
            cellKetua.innerHTML = `<input type="text" placeholder="Ketua">`;
            cellWakil.innerHTML = `<input type="text" placeholder="Wakil">`;
            cellSekretaris.innerHTML = `<input type="text" placeholder="Sekretaris">`;
            cellKelengkapan.innerHTML = `<input type="text" placeholder="Kelengkapan">`;
            cellWaktu.innerHTML = `<input type="text" placeholder="Waktu">`;
            cellOutput.innerHTML = `<input type="text" placeholder="Output">`;
            cellKeterangan.innerHTML = `<input type="text" placeholder="Keterangan">`;
            cellActions.innerHTML = `<button class="btn btn-delete" onclick="deleteRow(this)">Hapus</button>`;
        }

        function deleteRow(button) {
            const row = button.parentElement.parentElement;
            row.parentElement.removeChild(row);

            // Update numbering
            const table = document.getElementById('activityTable').getElementsByTagName('tbody')[0];
            for (let i = 0; i < table.rows.length; i++) {
                table.rows[i].cells[0].innerText = i + 1;
            }
        }
    </script>
@endsection
