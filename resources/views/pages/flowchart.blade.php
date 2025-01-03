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
function createNumberedSelectBox(rowIndex, position) {
    // Calculate node number for the position
    let nodeNum;
    if (position === 'ketua') nodeNum = rowIndex * 3 + 1;
    else if (position === 'wakil') nodeNum = rowIndex * 3 + 2;
    else if (position === 'sekretaris') nodeNum = rowIndex * 3 + 3;

    return `
        <div class="select-container">
            <div class="node-number">${nodeNum}</div>
            <select class="node-select" data-position="${position}" onchange="updateNodeType(this, ${nodeNum})">
                <option value="">--Pilih--</option>
                <option value="mulai">Mulai/Selesai</option>
                <option value="proses">Proses</option>
                <option value="pilihan">Pilihan</option>
            </select>
            <input type="text" class="branch-input" placeholder="Nomor tujuan" style="display:none;width:100px"
                   onchange="updateFlowchart()">
        </div>`;
}

const style = document.createElement('style');
style.textContent = `
    .select-container {
        position: relative;
        padding-top: 20px;
    }
    .node-number {
        position: absolute;
        top: 0;
        left: 0;
        font-size: 12px;
        color: #666;
    }
    .node-select {
        width: 100%;
    }
`;
document.head.appendChild(style);

function addActivity() {
    const table = document.getElementById('activityTable').getElementsByTagName('tbody')[0];
    const newRow = table.insertRow();
    const rowCount = table.rows.length;

    newRow.insertCell(0).innerText = rowCount;
    newRow.insertCell(1).innerHTML = '<input type="text" placeholder="Kegiatan">';
    newRow.insertCell(2).innerHTML = createNumberedSelectBox(rowCount - 1, 'ketua');
    newRow.insertCell(3).innerHTML = createNumberedSelectBox(rowCount - 1, 'wakil');
    newRow.insertCell(4).innerHTML = createNumberedSelectBox(rowCount - 1, 'sekretaris');
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

function createNode(type, x, y, width, height, text = '') {
    const textParts = text.split('\n')[0];
    const strokeWidth = 2;

    switch (type) {
        case 'mulai':
            return `<g>
                <rect x="${x - width/2}" y="${y - height/2}"
                    width="${width}" height="${height}"
                    rx="15" ry="15"
                    style="fill:white;stroke:black;stroke-width:${strokeWidth}"/>
                <text x="${x}" y="${y}"
                    text-anchor="middle"
                    alignment-baseline="middle"
                    style="font-size: 12px;">${textParts}</text>
            </g>`;

        case 'proses':
            return `<g>
                <rect x="${x - width/2}" y="${y - height/2}"
                    width="${width}" height="${height}"
                    style="fill:white;stroke:black;stroke-width:${strokeWidth}"/>
                <text x="${x}" y="${y}"
                    text-anchor="middle"
                    alignment-baseline="middle"
                    style="font-size: 12px;">${textParts}</text>
            </g>`;

        case 'pilihan':
            const halfWidth = width/2;
            const halfHeight = height/2;
            return `<g>
                <polygon points="${x},${y-halfHeight}
                    ${x+halfWidth},${y}
                    ${x},${y+halfHeight}
                    ${x-halfWidth},${y}"
                    style="fill:white;stroke:black;stroke-width:${strokeWidth}"/>
                <text x="${x}" y="${y}"
                    text-anchor="middle"
                    alignment-baseline="middle"
                    style="font-size: 12px;">${textParts}</text>
            </g>`;
    }
    return '';
}


function createConnection(startX, startY, endX, endY, type, branchTo = '') {
    const verticalGap = 40;
    const horizontalGap = 30;
    let path = '';

    if (type === 'pilihan') {
        // True path - langsung ke bawah
        const truePath = `
            M ${startX} ${startY}
            L ${startX - horizontalGap} ${startY}
            L ${startX - horizontalGap} ${endY - verticalGap}
            L ${endX} ${endY - verticalGap}
            L ${endX} ${endY}`;

        // False path - ke node berikutnya
        const falsePath = `
            M ${startX} ${startY + 20}
            L ${startX} ${endY}`;
            
        return `
            <path d="${truePath}" fill="none" stroke="black" stroke-width="2" marker-end="url(#arrowhead)"/>
            <path d="${falsePath}" fill="none" stroke="black" stroke-width="2" marker-end="url(#arrowhead)"/>
            <text x="${startX + 15}" y="${startY + 30}" text-anchor="start">True</text>
            <text x="${startX - horizontalGap - 5}" y="${startY}" text-anchor="end">False</text>`;
    } else {
        // Standard connection - vertical then horizontal
        path = `
            M ${startX} ${startY + 20}
            L ${startX} ${startY + verticalGap}
            L ${endX} ${startY + verticalGap}
            L ${endX} ${endY}`;

        return `<path d="${path}" fill="none" stroke="black" stroke-width="2" marker-end="url(#arrowhead)"/>`;
    }
}

function createSelectBox(index) {
    return `
        <select onchange="updateNodeType(this, ${index})">
            <option value=""></option>
            <option value="mulai">Mulai/Selesai</option>
            <option value="proses">Proses</option>
            <option value="pilihan">Pilihan</option>
        </select>
        <input type="text" class="branch-input" placeholder="Nomor tujuan" style="display:none;width:100px"
               onchange="updateFlowchart()">`;
}

function updateNodeType(select, nodeNumber) {
    const row = select.closest('tr');
    const branchInput = select.nextElementSibling;
    if (select.value === 'pilihan') {
        branchInput.style.display = 'inline-block';
    } else {
        branchInput.style.display = 'none';
    }
    showPreview();
}


function showPreview() {
    const table = document.getElementById('activityTable').getElementsByTagName('tbody')[0];
    const previewTableBody = document.getElementById('previewTableBody');
    const flowchartLayer = document.getElementById('flowchartLayer');

    previewTableBody.innerHTML = '';
    flowchartLayer.innerHTML = '';

    let svg = `
        <svg width="100%" height="100%" style="position:absolute;top:0;left:0;pointer-events:none;">
            <defs>
                <marker id="arrowhead" markerWidth="10" markerHeight="7"
                    refX="9" refY="3.5" orient="auto">
                    <polygon points="0 0, 10 3.5, 0 7" fill="black"/>
                </marker>
            </defs>
            <g transform="translate(0,20)">`;

    const rows = Array.from(table.getElementsByTagName('tr'));
    const positions = {
        ketua: 250,
        wakil: 430,
        sekretaris: 610
    };

    rows.forEach((row, rowIndex) => {
        // Copy data to preview table
        const newRow = document.createElement('tr');
        Array.from(row.cells).forEach((cell, cellIndex) => {
            const newCell = document.createElement('td');
            if (cellIndex < 8) {
                newCell.textContent = cellIndex === 0 ? cell.textContent :
                    cell.querySelector('input')?.value ||
                    cell.querySelector('select')?.value || '';
            }
            newRow.appendChild(newCell);
        });
        previewTableBody.appendChild(newRow);

        // Create flowchart elements
        const yPos = rowIndex * 120 + 60;

        // Add nodes and connections
        Object.entries(positions).forEach(([role, xPos], index) => {
            const select = row.querySelector(`select[data-position="${role}"]`);
            if (select && select.value) {
                // Add node
                svg += createNode(select.value, xPos, yPos, 80, 40,
                    row.cells[1].querySelector('input').value);

                // Find next node for connection
                let nextNodeFound = false;

                // Check remaining nodes in current row
                for (let i = index + 1; i < Object.entries(positions).length && !nextNodeFound; i++) {
                    const nextRole = Object.keys(positions)[i];
                    const nextSelect = row.querySelector(`select[data-position="${nextRole}"]`);
                    if (nextSelect && nextSelect.value) {
                        svg += createConnection(xPos, yPos,
                            positions[nextRole], yPos,
                            select.value);
                        nextNodeFound = true;
                    }
                }

                // If no next node in current row, connect to first node in next row
                if (!nextNodeFound && rowIndex < rows.length - 1) {
                    const nextRow = rows[rowIndex + 1];
                    for (const [nextRole, nextXPos] of Object.entries(positions)) {
                        const nextSelect = nextRow.querySelector(`select[data-position="${nextRole}"]`);
                        if (nextSelect && nextSelect.value) {
                            svg += createConnection(xPos, yPos,
                                nextXPos, yPos + 120,
                                select.value);
                            break;
                        }
                    }
                }
            }
        });
    });

    svg += '</g></svg>';
    flowchartLayer.innerHTML = svg;
}

function findNextActiveNode(tableData, currentRowIndex, currentRole) {
    const roles = ['ketua', 'wakil', 'sekretaris'];
    const currentRoleIndex = roles.indexOf(currentRole);

    // Cek node di baris yang sama
    for (let i = currentRoleIndex + 1; i < roles.length; i++) {
        if (tableData[currentRowIndex][roles[i]].type) {
            return {
                role: roles[i],
                rowIndex: currentRowIndex
            };
        }
    }

    // Cek node di baris berikutnya
    if (currentRowIndex + 1 < tableData.length) {
        for (const role of roles) {
            if (tableData[currentRowIndex + 1][role].type) {
                return {
                    role: role,
                    rowIndex: currentRowIndex + 1
                };
            }
        }
    }

    return null;
}
document.addEventListener('DOMContentLoaded', function() {
    addActivity();
});
</script>
@endsection
