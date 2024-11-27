@extends('layouts.admin')
@section('title')
    sop
@endsection
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tabel Data SOP</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data SOP</h6>
                <div class="mt-3">
                    <!-- Tombol Tambah Data -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        Tambah Data
                    </button>
                    <a href="{{ route('sops.export') }}" class="btn btn-success">Export to Excel</a>
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
                            <th>Nama</th>
                            <th>Nomor SK</th>
                            <th>Tahun</th>
                            <th>Hasil Monitoring</th>
                            <th>Tahun Perubahan</th>
                            <th>Keterangan</th>
                            <th>File SK</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sops as $sop)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sop->name }}</td>
                                <td>{{ $sop->nomor_sk }}</td>
                                <td>{{ $sop->tahun }}</td>
                                <td>{{ $sop->hasil_monitoring }}</td>
                                <td>{{ $sop->tahun_perubahan }}</td>
                                <td>{{ $sop->keterangan }}</td>
                                <td>
                                    @if($sop->file_sk)
                                        <a href="{{ asset('storage/' . $sop->file_sk) }}" target="_blank">Download</a>
                                    @endif
                                </td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $sop->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('sops.destroy', $sop->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus SOP ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal{{ $sop->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $sop->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $sop->id }}">Edit SOP</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('sops.update', $sop->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" name="name" value="{{ $sop->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nomor_sk" class="form-label">Nomor SK</label>
                                                    <input type="text" class="form-control" name="nomor_sk" value="{{ $sop->nomor_sk }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tahun" class="form-label">Tahun</label>
                                                    <input type="number" class="form-control" name="tahun" value="{{ $sop->tahun }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="hasil_monitoring" class="form-label">Hasil Monitoring</label>
                                                    <select class="form-select" name="hasil_monitoring">
                                                        <option value="penghapusan" {{ $sop->hasil_monitoring == 'penghapusan' ? 'selected' : '' }}>Penghapusan</option>
                                                        <option value="revisi" {{ $sop->hasil_monitoring == 'revisi' ? 'selected' : '' }}>Revisi</option>
                                                        <option value="penggabungan" {{ $sop->hasil_monitoring == 'penggabungan' ? 'selected' : '' }}>Penggabungan</option>
                                                        <option value="penambahan" {{ $sop->hasil_monitoring == 'penambahan' ? 'selected' : '' }}>Penambahan</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tahun_perubahan" class="form-label">Tahun Perubahan</label>
                                                    <input type="number" class="form-control" name="tahun_perubahan" value="{{ $sop->tahun_perubahan }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <textarea class="form-control" name="keterangan">{{ $sop->keterangan }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="file_sk" class="form-label">File SK</label>
                                                    <input type="file" class="form-control" name="file_sk">
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
                    <h5 class="modal-title" id="addModalLabel">Tambah Data SOP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('sop.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan Nama SOP" required>
                        </div>
                        <div class="mb-3">
                            <label for="nomor_sk" class="form-label">Nomor SK</label>
                            <input type="text" class="form-control" name="nomor_sk" placeholder="Masukkan Nomor SK" required>
                        </div>
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="number" class="form-control" name="tahun" placeholder="Masukkan Tahun" required>
                        </div>
                        <div class="mb-3">
                            <label for="hasil_monitoring" class="form-label">Hasil Monitoring</label>
                            <select class="form-select" name="hasil_monitoring">
                                <option value="" disabled selected>Pilih Hasil Monitoring</option>
                                <option value="penghapusan">Penghapusan</option>
                                <option value="revisi">Revisi</option>
                                <option value="penggabungan">Penggabungan</option>
                                <option value="penambahan">Penambahan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tahun_perubahan" class="form-label">Tahun Perubahan</label>
                            <input type="number" class="form-control" name="tahun_perubahan" placeholder="Masukkan Tahun Perubahan (Opsional)">
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" name="keterangan" placeholder="Masukkan Keterangan (Opsional)"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="file_sk" class="form-label">File SK</label>
                            <input type="file" class="form-control" name="file_sk">
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
