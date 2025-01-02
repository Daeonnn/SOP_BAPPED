@extends('layouts.admin')

@section('title', 'Tabel Kegiatan')

@section('content')
<style>
    .table-container {
        position: relative;
        width: 100%;
        margin-top: 20px;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        background: white;
        position: relative;
        z-index: 1;
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
        word-wrap: break-word;
        vertical-align: top;
        height: 120px;
    }

    th {
        background-color: #f2f2f2;
        height: auto;
    }

    .flowchart-layer {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 2;
    }

    .node-container {
        position: relative;
        height: 100%;
        min-height: 120px;
    }

    .btn {
        padding: 8px 12px;
        margin: 8px;
        cursor: pointer;
        border-radius: 4px;
    }

    .btn-add {
        background-color: #4CAF50;
        color: white;
        border: none;
    }

    .btn-preview {
        background-color: #007bff;
        color: white;
        border: none;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
        border: none;
    }

    input[type="text"], select {
        width: 100%;
        padding: 6px;
        margin: 4px 0;
        box-sizing: border-box;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    select {
        background-color: white;
    }
</style>

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
                        <th>No</th>
                        <th>Kegiatan</th>
                        <th>Ketua</th>
                        <th>Wakil</th>
                        <th>Sekretaris</th>
                        <th>Kelengkapan</th>
                        <th>Waktu</th>
                        <th>Output</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <button class="btn btn-preview" onclick="showPreview()">Preview</button>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Preview Tabel Kegiatan</h6>
        </div>
        <div class="card-body">
            <div class="table-container">
                <table id="previewTable">
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
                <div id="flowchartLayer" class="flowchart-layer"></div>
            </div>
        </div>
    </div>
</div>

<script>
function createSelectBox() {
    return `
        <select>
            <option value="">--Pilih--</option>
            <option value="mulai">Mulai/Selesai</option>
            <option value="proses">Proses</option>
            <option value="pilihan">Pilihan</option>
        </select>`;
}

function addActivity() {
    const table = document.getElementById('activityTable').getElementsByTagName('tbody')[0];
    const newRow = table.insertRow();
    const rowCount = table.rows.length;

    newRow.insertCell(0).innerText = rowCount;
    newRow.insertCell(1).innerHTML = '<input type="text" placeholder="Kegiatan">';
    newRow.insertCell(2).innerHTML = createSelectBox();
    newRow.insertCell(3).innerHTML = createSelectBox();
    newRow.insertCell(4).innerHTML = createSelectBox();
    newRow.insertCell(5).innerHTML = '<input type="text" placeholder="Kelengkapan">';
    newRow.insertCell(6).innerHTML = '<input type="text" placeholder="Waktu">';
    newRow.insertCell(7).innerHTML = '<input type="text" placeholder="Output">';
    newRow.insertCell(8).innerHTML = '<button class="btn btn-delete" onclick="deleteRow(this)">Hapus</button>';
}

function deleteRow(button) {
    const row = button.parentElement.parentElement;
    row.parentElement.removeChild(row);
    renumberRows();
}

function renumberRows() {
    const table = document.getElementById('activityTable').getElementsByTagName('tbody')[0];
    const rows = table.getElementsByTagName('tr');
    for (let i = 0; i < rows.length; i++) {
        rows[i].cells[0].innerText = i + 1;
    }
}

function createNode(type, x, y, width, height) {
    switch (type) {
        case 'mulai':
            return `<rect x="${x - width/2}" y="${y - height/2}"
                         width="${width}" height="${height}"
                         rx="15" ry="15"
                         style="fill:white;stroke:black;stroke-width:2"/>`;
        case 'proses':
            return `<rect x="${x - width/2}" y="${y - height/2}"
                         width="${width}" height="${height}"
                         style="fill:white;stroke:black;stroke-width:2"/>`;
        case 'pilihan':
            const halfWidth = width/2;
            const halfHeight = height/2;
            return `<polygon points="${x},${y-halfHeight}
                                   ${x+halfWidth},${y}
                                   ${x},${y+halfHeight}
                                   ${x-halfWidth},${y}"
                           style="fill:white;stroke:black;stroke-width:2"/>`;
        default:
            return '';
    }
}

function createConnection(startX, startY, endX, endY, type, nextType) {
    if (type === 'pilihan') {
        // Untuk node diamond (pilihan)
        const falseBranchX = startX + 80;
        const verticalOffset = 40;

        // Jalur false (ke samping dan ke bawah)
        const falsePath = `M ${startX + 40} ${startY}
                          L ${falseBranchX} ${startY}
                          L ${falseBranchX} ${endY}
                          L ${endX} ${endY}`;

        // Jalur true (langsung ke bawah)
        const truePath = `M ${startX} ${startY + 20}
                         L ${startX} ${endY}`;

        return `<path d="${falsePath}" fill="none" stroke="black" stroke-width="2" marker-end="url(#arrowhead)"/>
                <path d="${truePath}" fill="none" stroke="black" stroke-width="2" marker-end="url(#arrowhead)"/>`;
    } else {
        // Koneksi normal vertikal
        return `<path d="M ${startX} ${startY + 20}
                        L ${startX} ${endY - 20}"
                style="fill:none;stroke:black;stroke-width:2;marker-end:url(#arrowhead)"/>`;
    }
}

function showPreview() {
    const table = document.getElementById('activityTable').getElementsByTagName('tbody')[0];
    const rows = table.getElementsByTagName('tr');
    const previewTableBody = document.getElementById('previewTableBody');
    const flowchartLayer = document.getElementById('flowchartLayer');

    // Clear previous content
    previewTableBody.innerHTML = '';
    flowchartLayer.innerHTML = '';

    // Add arrow marker definitions
    let markersDefinition = `<svg width="100%" height="100%"><defs>
        <marker id="arrowhead" markerWidth="10" markerHeight="7"
                refX="9" refY="3.5" orient="auto">
            <polygon points="0 0, 10 3.5, 0 7" fill="black"/>
        </marker>
    </defs>`;

    // Build table data
    const tableData = Array.from(rows).map(row => ({
        no: row.cells[0].innerText,
        kegiatan: row.cells[1].querySelector('input').value,
        ketua: row.cells[2].querySelector('select').value,
        wakil: row.cells[3].querySelector('select').value,
        sekretaris: row.cells[4].querySelector('select').value,
        kelengkapan: row.cells[5].querySelector('input').value,
        waktu: row.cells[6].querySelector('input').value,
        output: row.cells[7].querySelector('input').value
    }));

    // Create table rows
    tableData.forEach((data, index) => {
        const newRow = previewTableBody.insertRow();
        newRow.innerHTML = `
            <td>${data.no}</td>
            <td>${data.kegiatan}</td>
            <td class="node-container"></td>
            <td class="node-container"></td>
            <td class="node-container"></td>
            <td>${data.kelengkapan}</td>
            <td>${data.waktu}</td>
            <td>${data.output}</td>
            <td></td>
        `;
    });

    // Add flowchart elements
    let flowchartSVG = markersDefinition;
    const cellHeight = 120;
    const nodeWidth = 60;
    const nodeHeight = 40;

    tableData.forEach((data, rowIndex) => {
        const baseY = (rowIndex * cellHeight) + (cellHeight / 2);

        ['ketua', 'wakil', 'sekretaris'].forEach((role, colIndex) => {
            const x = 250 + (colIndex * 150);
            const y = baseY;

            if (data[role]) {
                // Create node
                flowchartSVG += createNode(data[role], x, y, nodeWidth, nodeHeight);

                // Create connections
                if (rowIndex < tableData.length - 1) {
                    const nextY = baseY + cellHeight;
                    const nextType = tableData[rowIndex + 1][role];
                    flowchartSVG += createConnection(x, y, x, nextY, data[role], nextType);

                    // Add "False" label for diamond shapes
                    if (data[role] === 'pilihan') {
                        flowchartSVG += `<text x="${x + 45}" y="${y-5}"
                                        font-size="12">False</text>`;
                    }
                }
            }
        });
    });

    flowchartSVG += '</svg>';
    flowchartLayer.innerHTML = flowchartSVG;
}

document.addEventListener('DOMContentLoaded', function() {
    addActivity();
});
</script>
@endsection
