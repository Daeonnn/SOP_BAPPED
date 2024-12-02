@extends('layouts.admin')
@section('title')
    bidang
@endsection
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tabel Data Sub Bidang</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Suib Bidang</h6>
                <div class="mt-3">
                    <!-- Tombol Tambah Data -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        Tambah Data
                    </button>
                    {{-- <a href="{{ route('bidang.export') }}" class="btn btn-success">Export to Excel</a> --}}
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
                            <th>Nama Sub Bidang</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bidang as $bidang)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $bidang->name }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $bidang->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('bidang.destroy', $bidang->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus bidang ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal{{ $bidang->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $bidang->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $bidang->id }}">Edit bidang</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('bidang.update', $bidang->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" name="name" value="{{ $bidang->name }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>


    </div>
    <!-- /.container-fluid -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Data bidang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('bidang.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan Nama bidang" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
