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

        th,
        td {
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

        input[type="text"],
        select {
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
                <option value=""></option>
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
                case 'selesai':
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
                    const diamondWidth = width * 1.2;
                    const diamondHeight = height * 1.2;
                    return `<g>
                <path d="M ${x} ${y - diamondHeight/2}
                         L ${x + diamondWidth/2} ${y}
                         L ${x} ${y + diamondHeight/2}
                         L ${x - diamondWidth/2} ${y} Z"
                    style="fill:white;stroke:black;stroke-width:${strokeWidth}"/>
                <text x="${x}" y="${y}"
                    text-anchor="middle"
                    alignment-baseline="middle"
                    style="font-size: 12px;">${textParts}</text>
            </g>`;

                default:
                    return '';
            }
        }


        function findNextNode(nodeMap, currentId) {
            const [currentRole, currentRow] = currentId.split('-');
            const roles = ['ketua', 'wakil', 'sekretaris'];
            const currentRoleIndex = roles.indexOf(currentRole);
            const row = parseInt(currentRow);

            // First check remaining roles in current row
            for (let i = currentRoleIndex + 1; i < roles.length; i++) {
                const nextId = `${roles[i]}-${row}`;
                if (nodeMap.has(nextId)) return nextId;
            }

            // Then check first available role in next row
            for (const role of roles) {
                const nextId = `${role}-${(row + 1)}`;
                if (nodeMap.has(nextId)) return nextId;
            }

            return null;
        }

        function createConnection(startX, startY, endX, endY, type, nodeMap, currentNode) {
            const verticalGap = 40;

            if (type === 'pilihan') {
                const currentNodeData = nodeMap.get(currentNode);
                if (currentNodeData.branchValue) {
                    const targetNum = parseInt(currentNodeData.branchValue);
                    const targetRow = Math.floor((targetNum - 1) / 3);
                    const targetCol = (targetNum - 1) % 3;
                    const targetX = 450 + targetCol * 150;
                    const targetY = targetRow * 120 + 60;

                    // True path (continues to next node)
                    const truePath = `M ${startX} ${startY + 20}
                            L ${startX} ${endY - verticalGap}
                            L ${endX} ${endY - verticalGap}
                            L ${endX} ${endY}`;

                    // False path (goes to target node)
                    const falsePath = `M ${startX + 40} ${startY}
                             L ${startX + 100} ${startY}
                             L ${startX + 100} ${targetY}
                             L ${targetX} ${targetY}`;

                    return `<path d="${truePath}" fill="none" stroke="black" stroke-width="2" marker-end="url(#arrowhead)"/>
                   <path d="${falsePath}" fill="none" stroke="black" stroke-width="2" marker-end="url(#arrowhead)"/>
                   <text x="${startX + 110}" y="${(startY + targetY)/2}">False</text>
                   <text x="${startX - 20}" y="${(startY + endY)/2}">True</text>`;
                }
            }

            // Default connection
            const path = `M ${startX} ${startY + 20}
                  L ${startX} ${endY - verticalGap}
                  L ${endX} ${endY - verticalGap}
                  L ${endX} ${endY}`;

            return `<path d="${path}" fill="none" stroke="black" stroke-width="2" marker-end="url(#arrowhead)"/>`;
        }

        function getColumnPosition(nodeNumber) {
            const column = (nodeNumber - 1) % 3;
            switch (column) {
                case 0:
                    return 450; // Ketua
                case 1:
                    return 650; // Wakil
                case 2:
                    return 800; // Sekretaris
                default:
                    return 450;
            }
        }

        function getColumnPosition(nodeNumber) {
            const column = (nodeNumber - 1) % 3;
            if (column === 0) return 200; // ketua
            else if (column === 1) return 450; // wakil
            return 700; // sekretaris
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




        function showPreview() {
            const table = document.getElementById('activityTable').getElementsByTagName('tbody')[0];
            const previewTableBody = document.getElementById('previewTableBody');
            const flowchartLayer = document.getElementById('flowchartLayer');

            previewTableBody.innerHTML = '';
            flowchartLayer.innerHTML = '';

            // Positions for each column
            const positions = {
                ketua: 450,
                wakil: 650,
                sekretaris: 800
            };

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
            let nodeMap = new Map();

            // First pass: Create nodes
            rows.forEach((row, rowIndex) => {
                const yPos = rowIndex * 120 + 60;

                // Create preview table row
                const previewRow = previewTableBody.insertRow();
                const cells = Array.from(row.cells);
                cells.forEach((cell, index) => {
                    if (index < 8) {
                        const newCell = previewRow.insertCell();
                        if (index === 0) {
                            newCell.textContent = cell.textContent;
                        } else {
                            newCell.textContent = cell.querySelector('input')?.value ||
                                cell.querySelector('select')?.value || '';
                        }
                    }
                });
                previewRow.insertCell(); // Add keterangan cell

                // Create nodes for each role
                Object.entries(positions).forEach(([role, xPos]) => {
                    const select = row.querySelector(`select[data-position="${role}"]`);
                    if (select && select.value) {
                        const nodeType = select.value;
                        const nodeText = row.cells[1].querySelector('input').value || '';

                        // Create node
                        svg += createNode(nodeType, xPos, yPos, 80, 40, nodeText);

                        // Store node information
                        const nodeId = `${role}-${rowIndex}`;
                        const branchInput = select.nextElementSibling;
                        nodeMap.set(nodeId, {
                            type: nodeType,
                            x: xPos,
                            y: yPos,
                            text: nodeText,
                            branchValue: branchInput?.value || null
                        });
                    }
                });
            });

            // Second pass: Create connections
            nodeMap.forEach((node, id) => {
                const nextNode = findNextNode(nodeMap, id);
                if (nextNode) {
                    const connection = createConnection(
                        node.x, node.y,
                        nodeMap.get(nextNode).x,
                        nodeMap.get(nextNode).y,
                        node.type,
                        nodeMap,
                        id
                    );
                    svg += connection;
                }
            });

            svg += '</g></svg>';
            flowchartLayer.innerHTML = svg;

            // Add any necessary event listeners
            document.querySelectorAll('.branch-input').forEach(input => {
                input.addEventListener('change', showPreview);
            });
        }

        // Update handler for node type changes
        function updateNodeType(select, nodeNumber) {
            const branchInput = select.nextElementSibling;
            if (select.value === 'pilihan') {
                branchInput.style.display = 'inline-block';
            } else {
                branchInput.style.display = 'none';
            }
            showPreview();
        }

        function findNextActiveNode(nodeMap, currentId) {
            const [currentRole, currentRowIndex] = currentId.split('-');
            const roles = ['ketua', 'wakil', 'sekretaris'];
            const currentRoleIndex = roles.indexOf(currentRole);
            const currentRow = parseInt(currentRowIndex);

            // For pilihan nodes, handle True path
            const select = document.querySelector(`select[data-position="${currentRole}"]`);
            if (select?.value === 'pilihan') {
                // Continue to next node for True path
                // Check next node in same row
                for (let i = currentRoleIndex + 1; i < roles.length; i++) {
                    const nextId = `${roles[i]}-${currentRow}`;
                    if (nodeMap.has(nextId)) {
                        return nextId;
                    }
                }
                // Check first node in next row
                const nextRow = currentRow + 1;
                for (const role of roles) {
                    const nextId = `${role}-${nextRow}`;
                    if (nodeMap.has(nextId)) {
                        return nextId;
                    }
                }
            } else {
                // Normal forward progression for non-pilihan nodes
                for (let i = currentRoleIndex + 1; i < roles.length; i++) {
                    const nextId = `${roles[i]}-${currentRow}`;
                    if (nodeMap.has(nextId)) {
                        return nextId;
                    }
                }

                const nextRow = currentRow + 1;
                for (const role of roles) {
                    const nextId = `${role}-${nextRow}`;
                    if (nodeMap.has(nextId)) {
                        return nextId;
                    }
                }
            }

            return null;
        }

        function findPreviousProcessNode(nodeMap, currentId) {
            const [currentRole, currentRowIndex] = currentId.split('-');
            const currentRow = parseInt(currentRowIndex);
            const prevRow = currentRow - 1;

            if (prevRow >= 0) {
                // Look for process nodes in previous row
                for (const [nodeId, node] of nodeMap.entries()) {
                    if (nodeId.endsWith(`-${prevRow}`) && node.type === 'proses') {
                        return nodeId;
                    }
                }
            }
            return null;
        }
        document.addEventListener('DOMContentLoaded', function() {
            addActivity();
        });
        // Add node position validation
        function validateNodePosition(select, rowIndex, position) {
            const nodeNum = getNodeNumber(rowIndex, position);
            const nodeType = select.value;

            if (nodeType === 'mulai' && nodeNum !== 1) {
                alert('Node Mulai hanya bisa ditempatkan di posisi pertama');
                select.value = '';
                return false;
            }

            return true;
        }

        // Improve connection routing
        function createSmartConnection(startX, startY, endX, endY, type) {
            const midY = (startY + endY) / 2;
            const cornerRadius = 10;

            return `
        <path d="
            M ${startX} ${startY}
            L ${startX} ${midY - cornerRadius}
            Q ${startX} ${midY} ${startX + cornerRadius} ${midY}
            L ${endX - cornerRadius} ${midY}
            Q ${endX} ${midY} ${endX} ${midY + cornerRadius}
            L ${endX} ${endY}"
            fill="none" stroke="black" stroke-width="2"
            marker-end="url(#arrowhead)"
        />
    `;
        }

        // Add data persistence
        function saveFlowchartState() {
            const state = {
                activities: [],
                connections: []
            };

            const table = document.getElementById('activityTable');
            Array.from(table.getElementsByTagName('tr')).forEach(row => {
                if (row.cells.length) {
                    state.activities.push({
                        kegiatan: row.cells[1].querySelector('input').value,
                        ketua: row.cells[2].querySelector('select').value,
                        wakil: row.cells[3].querySelector('select').value,
                        sekretaris: row.cells[4].querySelector('select').value
                    });
                }
            });

            localStorage.setItem('flowchartState', JSON.stringify(state));
        }

        // Add undo/redo functionality
        const undoStack = [];
        const redoStack = [];

        function captureState() {
            const state = document.getElementById('activityTable').innerHTML;
            undoStack.push(state);
            redoStack.length = 0;
        }

        function undo() {
            if (undoStack.length > 0) {
                const currentState = document.getElementById('activityTable').innerHTML;
                redoStack.push(currentState);
                const previousState = undoStack.pop();
                document.getElementById('activityTable').innerHTML = previousState;
                showPreview();
            }
        }

        
    </script>
@endsection
