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

        .flowchart-info {
            display: flex;
            justify-content: start;
            gap: 5px;
            margin-bottom: 20px;
        }

        .flowchart-item {
            display: flex;
            align-items: center;
            gap: 5px;
            position: relative;
            padding-right: 20px;
        }

        .flowchart-item:not(:last-child)::after {
            content: "|";
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            color: #000;
            font-weight: bold;
            font-size: 18px;
        }

        .flowchart-item span {
            font-weight: bold;
            color: #333;
        }

        .flowchart-item i {
            font-size: 24px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">Bentuk Flowchart</h3>
                <div class="card-body">
                    <div class="flowchart-info">
                        <div class="flowchart-item">
                            <span>Mulai/Selesai :</span>
                            <i class="bi bi-app"></i>
                        </div>
                        <div class="flowchart-item">
                            <span>Proses :</span>
                            <i class="bi bi-square"></i>
                        </div>
                        <div class="flowchart-item">
                            <span>Pilihan :</span>
                            <i class="bi bi-diamond"></i>
                        </div>
                    </div>
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
                                <select id="statusSelect">
                                    <option value="" disabled selected></option>
                                    <option value="mulai_selesai">Mulai/Selesai</option>
                                    <option value="proses">Proses</option>
                                    <option value="pilihan">Pilihan</option>
                                </select>
                            </td>
                            <td>
                                <select id="statusSelect">
                                    <option value="" disabled selected></option>
                                    <option value="mulai_selesai">Mulai/Selesai</option>
                                    <option value="proses">Proses</option>
                                    <option value="pilihan">Pilihan</option>
                                </select>
                            </td>
                            <td>
                                <select id="statusSelect">
                                    <option value="" disabled selected></option>
                                    <option value="mulai_selesai">Mulai/Selesai</option>
                                    <option value="proses">Proses</option>
                                    <option value="pilihan">Pilihan</option>
                                </select>
                            </td>
                            <td>Lengkap</td>
                            <td>On Time</td>
                            <td>Baik</td>
                            <td>Catatan A</td>
                            <td><button class="btn btn-delete" onclick="deleteRow(this)">Hapus</button></td>
                        </tr>
                    </tbody>
                </table>
                <button id="submit" type="button" class="btn btn-primary mt-2" style="display: none" onclick="submitTable()">Submit</button>
                <button id="previewButton" class="btn btn-success mt-2" onclick="previewTable()">Preview</button>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="previewTableContainer" style="display: none;">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Flowchart</h6>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Kegiatan</th>
                            <th colspan="3">Pelaksana</th>
                            <th colspan="3">Mutu Buku</th>
                            <th rowspan="2">Keterangan</th>
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
                        <!-- Tabel preview akan diisi dengan data tabel kegiatan -->
                        <tr>
                            <td>1</td>
                            <td>Kegiatan A</td>
                            <td>Mulai/Selesai</td>
                            <td>Proses</td>
                            <td>Pilihan</td>
                            <td>Lengkap</td>
                            <td>On Time</td>
                            <td>Baik</td>
                            <td>Catatan A</td>
                        </tr>
                    </tbody>
                </table>
                <a href="{{ route('generate.pdf') }}" class="btn btn-primary mt-2">Generate PDF</a>
            </div>
        </div>
    </div>

    <script>
        function previewTable() {
            // Show preview table
            document.getElementById('previewTableContainer').style.display = 'block';
            document.getElementById('submit').style.display = 'inline-block'; // Show submit button
            document.getElementById('previewButton').style.display = 'none'; // Hide preview button

            // Get data from activity table and populate preview table
            const rows = document.getElementById('activityTable').rows;
            const previewTable = document.querySelector('#previewTableContainer tbody');
            previewTable.innerHTML = ''; // Clear existing rows

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].cells;
                const newRow = previewTable.insertRow();
                for (let j = 0; j < cells.length - 1; j++) {
                    const newCell = newRow.insertCell(j);
                    newCell.textContent = cells[j].textContent || cells[j].querySelector('select')?.value || '';
                }
            }
        }

        function submitTable() {
            // Disable editing and hide buttons
            const table = document.getElementById('activityTable');
            const submitButton = document.getElementById('submit');
            const previewButton = document.getElementById('previewButton');
            const deleteButtons = table.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => button.disabled = true);
            previewButton.disabled = true;
            submitButton.style.display = 'none'; // Hide submit button
        }

        function deleteRow(button) {
            const row = button.parentElement.parentElement;
            row.parentElement.removeChild(row);

            // Update numbering
            updateRowNumbers();
        }

        function addActivity() {
            const table = document.getElementById('activityTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            const rowCount = table.rows.length;

            newRow.insertCell(0).innerText = rowCount;

            newRow.insertCell(1).innerHTML = `<input type="text" placeholder="Nama Kegiatan">`;
            newRow.insertCell(2).innerHTML = `<select><option value="mulai_selesai">Mulai/Selesai</option><option value="proses">Proses</option><option value="pilihan">Pilihan</option></select>`;
            newRow.insertCell(3).innerHTML = `<select><option value="mulai_selesai">Mulai/Selesai</option><option value="proses">Proses</option><option value="pilihan">Pilihan</option></select>`;
            newRow.insertCell(4).innerHTML = `<select><option value="mulai_selesai">Mulai/Selesai</option><option value="proses">Proses</option><option value="pilihan">Pilihan</option></select>`;
            newRow.insertCell(5).innerHTML = `<input type="text" placeholder="Kelengkapan">`;
            newRow.insertCell(6).innerHTML = `<input type="text" placeholder="Waktu">`;
            newRow.insertCell(7).innerHTML = `<input type="text" placeholder="Output">`;
            newRow.insertCell(8).innerHTML = `<input type="text" placeholder="Keterangan">`;
            newRow.insertCell(9).innerHTML = `<button class="btn btn-delete" onclick="deleteRow(this)">Hapus</button>`;

            // Update nomor urut setelah baris baru ditambahkan
            updateRowNumbers();
        }

        function updateRowNumbers() {
            const table = document.getElementById('activityTable').getElementsByTagName('tbody')[0];
            const rows = table.rows;

            for (let i = 0; i < rows.length; i++) {
                rows[i].cells[0].innerText = i + 1; // Update nomor urut
            }
        }
    </script>
@endsection
