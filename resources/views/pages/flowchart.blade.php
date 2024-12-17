@extends('layouts.admin')

@section('title', 'Tabel Kegiatan')

@section('content')
<style>
    /* Mengatur tampilan tabel */
    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
        word-wrap: break-word;
        position: relative;
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

    input, select {
        width: 100%;
        box-sizing: border-box;
    }

    /* Styling untuk Flowchart Preview */
    .flowchart-preview {
        margin-top: 20px;
        text-align: center;
    }

    .flowchart-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        position: relative;
    }

    .flowchart-box {
        border: 2px solid #ccc;
        padding: 10px;
        margin-top: 20px;
        text-align: center;
        position: relative;
        display: inline-block;
    }

    .flowchart-cell {
        position: relative;
        text-align: center;
        display: inline-block;
        margin: 10px;
    }

    .flowchart-shape {
        display: inline-block;
        padding: 10px;
        margin: 5px;
        text-align: center;
        position: relative;
    }

    .rounded-rect {
        border: 2px solid #4CAF50;
        border-radius: 12px;
        background-color: #f9f9f9;
        width: 100px;
        height: 60px;
    }

    .rect {
        border: 2px solid #2196F3;
        background-color: #f9f9f9;
        width: 100px;
        height: 60px;
    }

    .diamond {
        border: 2px solid #FF9800;
        background-color: #f9f9f9;
        width: 100px;
        height: 100px;
        transform: rotate(45deg);
        position: relative;
        margin: 10px;
    }

    /* Garis penghubung flowchart di dalam tabel */
    .flowchart-line {
        position: absolute;
        width: 2px;
        background-color: #333;
        height: 60px;
        top: 50%;
        left: 100%;
        transform: translateY(-50%);
    }

    /* Garis penghubung horizontal */
    .horizontal-line {
        position: absolute;
        width: 60px;
        background-color: #333;
        top: 50%;
        left: 50%;
        transform: translateY(-50%);
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/mermaid/dist/mermaid.min.js"></script>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Tabel Kegiatan</h3>
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
                <tbody></tbody>
            </table>
            <button class="btn btn-preview" onclick="showPreview()">Preview</button>
        </div>
    </div>

    <!-- Preview Section -->
    <div class="flowchart-preview" id="previewSection" style="display: none;">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Preview Tabel Kegiatan dan Flowchart</h6>
            </div>
            <div class="card-body">
                <!-- Table Preview -->
                <h5>Tabel Kegiatan</h5>
                <table id="previewTable" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kegiatan</th>
                            <th>Ketua</th>
                            <th>Wakil</th>
                            <th>Sekretaris</th>
                            <th>Kelengkapan</th>
                            <th>Waktu</th>
                            <th>Output</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="previewTableBody"></tbody>
                </table>

                {{-- <!-- Flowchart Preview -->
                <div class="flowchart-container" id="flowchartContainer"></div> --}}
            </div>
        </div>
    </div>
</div>

<script>
    function addActivity() {
        const table = document.getElementById('activityTable').getElementsByTagName('tbody')[0];
        const newRow = table.insertRow();
        const rowCount = table.rows.length;

        newRow.insertCell(0).innerText = rowCount; // Nomor
        newRow.insertCell(1).innerHTML = '<input type="text" placeholder="Kegiatan">'; // Kegiatan
        newRow.insertCell(2).innerHTML = createSelectBox(); // Ketua
        newRow.insertCell(3).innerHTML = createSelectBox(); // Wakil
        newRow.insertCell(4).innerHTML = createSelectBox(); // Sekretaris
        newRow.insertCell(5).innerHTML = '<input type="text" placeholder="Kelengkapan">'; // Kelengkapan
        newRow.insertCell(6).innerHTML = '<input type="text" placeholder="Waktu">'; // Waktu
        newRow.insertCell(7).innerHTML = '<input type="text" placeholder="Output">'; // Output
        newRow.insertCell(8).innerHTML = '<input type="text" placeholder="Keterangan">'; // Keterangan
        newRow.insertCell(9).innerHTML = '<button class="btn btn-delete" onclick="deleteRow(this)">Hapus</button>'; // Hapus button
    }

    function createSelectBox() {
        return `
            <select>
                <option value="">--Pilih--</option>
                <option value="mulai">Mulai/Selesai</option>
                <option value="proses">Proses</option>
                <option value="pilihan">Pilihan</option>
            </select>
        `;
    }

    function deleteRow(button) {
        const row = button.parentElement.parentElement;
        row.parentElement.removeChild(row);
    }

    function showPreview() {
        const table = document.getElementById('activityTable').getElementsByTagName('tbody')[0];
        let previewTableContent = '';
        let flowchartContent = '';

        for (let i = 0; i < table.rows.length; i++) {
            const row = table.rows[i];
            const kegiatan = row.cells[1].querySelector('input').value || `Kegiatan ${i + 1}`;
            const ketua = row.cells[2].querySelector('select').value;
            const wakil = row.cells[3].querySelector('select').value;
            const sekre = row.cells[4].querySelector('select').value;
            const kelengkapan = row.cells[5].querySelector('input').value;
            const waktu = row.cells[6].querySelector('input').value;
            const output = row.cells[7].querySelector('input').value;
            const keterangan = row.cells[8].querySelector('input').value;

            // Menambahkan data ke dalam tabel preview
            previewTableContent += `
                <tr>
                    <td>${i + 1}</td>
                    <td>${kegiatan}</td>
                    <td>${getFlowchartShapeHTML(ketua)}</td>
                    <td>${getFlowchartShapeHTML(wakil)}</td>
                    <td>${getFlowchartShapeHTML(sekre)}</td>
                    <td>${kelengkapan}</td>
                    <td>${waktu}</td>
                    <td>${output}</td>
                    <td>${keterangan}</td>
                </tr>
            `;

            // Menambahkan flowchart dengan garis konektor di dalam sel kotak tabel
            flowchartContent += `
                <div class="flowchart-shape-container">
                    <div class="flowchart-box">
                        ${getFlowchartShapeHTML(ketua)}
                        <div class="horizontal-line"></div>
                        ${getFlowchartShapeHTML(wakil)}
                        <div class="horizontal-line"></div>
                        ${getFlowchartShapeHTML(sekre)}
                    </div>
                </div>
            `;
        }

        document.getElementById('previewTableBody').innerHTML = previewTableContent;
        // document.getElementById('flowchartContainer').innerHTML = flowchartContent;
        document.getElementById('previewSection').style.display = 'block';
    }

    function getFlowchartShapeHTML(value) {
        switch (value) {
            case 'mulai':
                return `<div class="flowchart-shape rounded-rect">Mulai/Selesai</div>`;
            case 'proses':
                return `<div class="flowchart-shape rect">Proses</div>`;
            case 'pilihan':
                return `<div class="flowchart-shape diamond">Pilihan</div>`;
            default:
                return '';
        }
    }
</script>
@endsection
