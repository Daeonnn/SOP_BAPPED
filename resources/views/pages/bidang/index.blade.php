@extends('layouts.admin')

@section('content')
    <style>
        .status-perlu-dilengkapi {
            color: white;
            background-color: red;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .status-diterima {
            color: white;
            background-color: green;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .status-revisi {
            color: white;
            background-color: yellow;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .status-menunggu {
            color: white;
            background-color: orange;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tabel Data Bidang {{ $bidang->name }}</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data SOP Bidang {{ $bidang->name }}</h6>
                <div class="mt-3">
                    <!-- Tombol Tambah Data -->
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        Tambah SOP
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor SOP</th>
                            <th>Nama SOP</th>
                            <th>Tanggal Pembuatan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sops as $sop)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('cover_sop.edit', ['sop_id' => $sop->id]) }}">
                                        {{ $sop->no_sop }}
                                    </a>
                                </td>
                                <td>{{ $sop->name }}</td>
                                <td>{{ $sop->tgl_pembuatan }}</td>
                                <td>
                                    @if ($sop->status == 'Perlu Dilengkapi')
                                        <span class="status-perlu-dilengkapi">{{ $sop->status }}</span>
                                    @elseif ($sop->status == 'Diterima')
                                        <span class="status-diterima">{{ $sop->status }}</span>
                                    @elseif ($sop->status == 'Revisi')
                                        <span class="status-revisi">{{ $sop->status }}</span>
                                    @elseif ($sop->status == 'Menunggu')
                                        <span class="status-menunggu">{{ $sop->status }}</span>
                                    @else
                                        <span>{{ $sop->status }}</span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('cover_sop.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Cover SOP</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="bidang_id" value="{{ $bidang->id }}">
                        <div class="form-group">
                            <label for="no_sop">No SOP</label>
                            <input type="text" class="form-control" name="no_sop" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_sop">Nama SOP</label>
                            <input type="text" class="form-control" name="nama_sop" required>
                        </div>
                        <div class="form-group">
                            <label for="tgl_pembuatan">Tanggal Pembuatan</label>
                            <input type="date" class="form-control" name="tgl_pembuatan" required>
                        </div>
                        @if ($subBidangList->isNotEmpty())
                            <div class="form-group">
                                <label for="sub_bidang_id">Sub Bidang</label>
                                <!-- Cek jika subBidangList tidak kosong -->
                                <select class="form-control" id="sub_bidang_id" name="sub_bidang_id">
                                    <option value="" disabled selected>Pilih Sub Bidang</option>
                                    @foreach ($subBidangList as $subBidang)
                                        <option value="{{ $subBidang->id }}">{{ $subBidang->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="pelaksana">Pelaksana</label>
                            <div id="pelaksana-container">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="pelaksana[]"
                                        placeholder="Nama Pelaksana">
                                    <button type="button"
                                        class="btn btn-danger btn-sm remove-pelaksana ms-2">&times;</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success btn-sm mt-2" id="add-pelaksana">+ Tambah
                                Pelaksana</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('add-pelaksana').addEventListener('click', function() {
            const container = document.getElementById('pelaksana-container');
            const inputGroup = document.createElement('div');
            inputGroup.className = 'input-group mb-2';
            inputGroup.innerHTML = `
            <input type="text" class="form-control" name="pelaksana[]" placeholder="Nama Pelaksana">
            <button type="button" class="btn btn-danger btn-sm remove-pelaksana ms-2">&times;</button>
        `;
            container.appendChild(inputGroup);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-pelaksana')) {
                e.target.parentElement.remove();
            }
        });
    </script>

@endsection
