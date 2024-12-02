@extends('layouts.admin')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tabel Data Bidang {{ $bidang->name }}</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data SOP Bidang {{ $bidang->name }}</h6>
                <div class="mt-3">
                    <!-- Tombol Tambah Data -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        Tambah SOP
                    </button>
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
                            <th>Sub Bidang</th>
                            <th>Tanggal Pembuatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sops as $sop)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sop->no_sop }}</td>
                                <td>{{ $sop->name }}</td>
                                <td>{{ $sop->subBidang->name}}</td>
                                <td>{{ $sop->tgl_pembuatan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>
@endsection
