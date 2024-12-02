@extends('layouts.admin')

@section('title', 'Pilih Sub Bidang')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pilih Sub Bidang</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('sop.form') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="sub_bidang">Pilih Sub Bidang</label>
                    <select name="sub_bidang" id="sub_bidang" class="form-control" required>
                        <option value="">Pilih Sub-Bidang</option>
                        @foreach($sub_bidangList as $subBidang)
                            <option value="{{ $subBidang->id }}">
                                {{ $subBidang->name }} ({{ $subBidang->bidang->name }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
