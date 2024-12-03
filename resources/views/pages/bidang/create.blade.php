@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Tambah SOP untuk Bidang {{ $bidang->name }}</h1>

    <form action="" method="POST">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Tambah SOP</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama SOP</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="no_sop" class="form-label">Nomor SOP</label>
                    <input type="text" class="form-control" id="no_sop" name="no_sop" required>
                </div>
                <div class="mb-3">
                    <label for="tgl_pembuatan" class="form-label">Tanggal Pembuatan</label>
                    <input type="date" class="form-control" id="tgl_pembuatan" name="tgl_pembuatan" required>
                </div>
                <!-- Field lain sesuai dengan kebutuhan -->

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('bidang.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
