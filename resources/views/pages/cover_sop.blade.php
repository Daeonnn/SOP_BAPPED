@extends('layouts.admin')
@section('title')
    sop
@endsection
@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
            /* Enables horizontal scrolling on small screens */
            padding: 10px;
            box-sizing: border-box;
        }

        .tg {
            border-collapse: collapse;
            width: 100%;
        }

        .tg th {
            font-weight: normal;
        }


        .tg td,
        .tg th {
            border: 1px solid black;
            padding: 2px;
            text-align: left;
            vertical-align: top;
            font-size: 14px;

        }

        thead th {
            text-align: center;
        }

        .tg th:nth-child(1) {
            text-align: left;
        }

        .tg .center {
            text-align: center;
        }

        .tg input {
            width: 100%;

            padding: 5px;
            font-size: 14px;
        }

        .header-content {
            text-align: center;
            font-size: 18px;
            line-height: 1.5;
            display: flex;
            flex-direction: column;
            /* Arrange elements vertically */
            align-items: center;
            /* Center elements horizontally */
        }

        .header-content img {
            width: 80px;
            height: auto;
            margin-bottom: 5px;
            /* Add space below the logo */
        }

        /* Add extra space above the SUBBAGIAN input */
        .header-content input {
            text-align: center;
            margin-top: 50px;
            /* Add 16px spacing above (equivalent to 2 lines) */
        }

        @media (max-width: 768px) {

            .tg td,
            .tg th {
                font-size: 12px;
                padding: 8px;
            }

            .tg input {
                font-size: 12px;
            }

            .header-content img {
                width: 60px;
            }

            .header-content {
                font-size: 12px;
            }
        }
    </style>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data bidang</h6>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <form action="{{ route('cover_sop.store') }}" method="POST">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @csrf
                        <table class="tg">
                            <colgroup>
                                <col style="width: 50%;" />
                                <col style="width: 15%;" />
                                <col style="width: 55%;" />
                            </colgroup>
                            <thead>
                                <tr>
                                    <th rowspan="6" class="center">
                                        <div class="header-content">
                                            <img src="{{ asset('img/bappeda.png') }}" alt="LOGO" />
                                            <strong>PEMERINTAH KOTA PONTIANAK</strong>
                                            Badan Perencanaan Pembangunan Daerah
                                            <div style="margin-bottom: 50px; text-transform: uppercase;">
                                                {{ $subBidang->bidang->name }}
                                            </div>
                                            <div>
                                                Subbag {{ $subBidang->name }}
                                                <input type="hidden" name="sub_bidang_id" value="{{ $subBidang->bidang->id }}">
                                            </div>
                                        </div>
                                    </th>
                                    <th>No SOP</th>
                                    <th><input type="text" name="no_sop"
                                            style="border: 0px; outline: none; padding: 0" /></th>
                                </tr>
                                <tr>
                                    <th>Tgl Pembuatan</th>
                                    <th><input type="text" name="tgl_pembuatan"
                                            style="border: 0px; outline: none; padding: 0" /></th>
                                </tr>
                                <tr>
                                    <th>Tgl Revisi</th>
                                    <th><input type="text" name="tgl_revisi"
                                            style="border: 0px; outline: none; padding: 0" /></th>
                                </tr>
                                <tr>
                                    <th>Tgl Aktif</th>
                                    <th><input type="text" name="tgl_aktif"
                                            style="border: 0px; outline: none; padding: 0" /></th>
                                </tr>
                                <tr>
                                    <th>Disahkan Oleh</th>
                                    <th style="height: 100px">
                                        <textarea
                                            style="
                                            border: 0;
                                            resize: none;
                                            overflow: hidden;
                                            width: 100%;
                                            height: 100%;
                                            font-family: inherit;
                                            font-size: inherit;
                                            margin: 0;
                                            outline: none;"
                                            name="disahkan_oleh"></textarea>
                                    </th>
                                </tr>
                                <tr>
                                    <th style="padding-bottom: 20px;">Nama SOP</th>
                                    <th><input type="text" style="border: 0px; outline: none; padding: 0"
                                            name="nama_sop" /></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding-bottom: 20px;">Dasar Hukum:</td>
                                    <td colspan="2">Kualifikasi Pelaksana</td>
                                </tr>
                                <tr>
                                    <th>
                                        <textarea
                                            style="
                                        border: 0;
                                        resize: none;
                                        width: 100%;
                                        height: auto;
                                        overflow: hidden;
                                        font-family: inherit;
                                        font-size: inherit;
                                        margin: 0;
                                        outline: none;"
                                            oninput="adjustHeightDasarHukum(this)" name="dasar_hukum"></textarea>
                                    </th>
                                    <td colspan="2">
                                        <textarea
                                            style="
                                        border: 0;
                                        resize: none;
                                        width: 100%;
                                        height: auto;
                                        overflow: hidden;
                                        font-family: inherit;
                                        font-size: inherit;
                                        margin: 0;
                                        outline: none;"
                                            oninput="adjustHeightKualifikasiPelaksana(this)" name="kualifikasi_pelaksana"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Keterkaitan:</td>
                                    <td colspan="2">Peralatan</td>
                                </tr>
                                <tr>
                                    <th>
                                        <textarea
                                            style="
                                        border: 0;
                                        resize: none;
                                        width: 100%;
                                        overflow: hidden;
                                        font-family: inherit;
                                        font-size: inherit;
                                        margin: 0;
                                        outline: none;"
                                            oninput="adjustHeightKeterkaitan(this)" name="keterkaitan"></textarea>
                                    </th>
                                    <td colspan="2">
                                        <textarea
                                            style="
                                        border: 0;
                                        resize: none;
                                        width: 100%;
                                        height: auto;
                                        overflow: hidden;
                                        font-family: inherit;
                                        font-size: inherit;
                                        margin: 0;
                                        outline: none;"
                                            oninput="adjustHeightPeralatan(this)" name="peralatan"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Peringatan:</td>
                                    <td colspan="2">Pencatatan</td>
                                </tr>
                                <tr>
                                    <th>
                                        <textarea
                                            style="
                                        border: 0;
                                        resize: none;
                                        width: 100%;
                                        height: auto;
                                        overflow: hidden;
                                        font-family: inherit;
                                        font-size: inherit;
                                        margin: 0;
                                        outline: none;"
                                            oninput="adjustHeightPeringatan(this)" name="peringatan"></textarea>
                                    </th>
                                    <td colspan="2">
                                        <textarea
                                            style="
                                        border: 0;
                                        resize: none;
                                        width: 100%;
                                        height: auto;
                                        overflow: hidden;
                                        font-family: inherit;
                                        font-size: inherit;
                                        margin: 0;
                                        outline: none;"
                                            oninput="adjustHeightPencatatan(this)" name="pencatatan"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                        <button type="submit" class="btn btn-primary mt-2">Submit</button>
                    </form>
                    <button id="previewButton" class="btn btn-success mt-2">Preview</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="previewTableContainer" style="display: none;">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data bidang</h6>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="tg">
                        <colgroup>
                            <col style="width: 50%;" />
                            <col style="width: 15%;" />
                            <col style="width: 55%;" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th rowspan="6" class="center">
                                    <div class="header-content">
                                        <img src="{{ asset('img/bappeda.png') }}" alt="LOGO" />
                                        <strong>PEMERINTAH KOTA PONTIANAK</strong>
                                        Badan Perencanaan Pembangunan Daerah
                                        <div style="margin-bottom: 50px; text-transform: uppercase;">
                                            {{ $subBidang->bidang->name }}
                                        </div>
                                        <div>
                                            Subbag {{ $subBidang->name }}
                                            <input type="hidden" name="bidang_id" value="{{ $subBidang->bidang->id }}">
                                        </div>
                                    </div>
                                </th>
                                <th>No SOP</th>
                                <th id="previewNoSop"></th>
                            </tr>
                            <tr>
                                <th>Tgl Pembuatan</th>
                                <th id="previewTglPembuatan"></th>
                            </tr>
                            <tr>
                                <th>Tgl Revisi</th>
                                <th id="previewTglRevisi"></th>
                            </tr>
                            <tr>
                                <th>Tgl Aktif</th>
                                <th id="previewTglAktif"></th>
                            </tr>
                            <tr>
                                <th>Disahkan Oleh</th>
                                <th id="previewDisahkanOleh" style="height: 100px;"></th>
                            </tr>
                            <tr>
                                <th>Nama SOP</th>
                                <th id="previewNamaSop"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding-bottom: 20px;">Dasar Hukum:</td>
                                <td colspan="2">Kualifikasi Pelaksana</td>

                            </tr>
                            <tr>
                                <th id="previewDasarHukum" style="height: 100px"></th>
                                <td colspan="2" id="previewKualifikasiPelaksana"></td>
                            </tr>
                            <tr>
                                <td>Keterkaitan:</td>
                                <td colspan="2">Peralatan</td>
                            </tr>
                            <tr>
                                <th id="previewKeterkaitan" style="height: 100px"></th>
                                <td colspan="2" id="previewPeralatan"></td>
                            </tr>
                            <tr>
                                <td>Peringatan:</td>
                                <td colspan="2">Pencatatan</td>
                            </tr>
                            <tr>
                                <th id="previewPeringatan" style="height: 100px"></th>
                                <td colspan="2" id="previewPencatatan"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('previewButton').addEventListener('click', function() {
            // Get values from form
            const noSop = document.querySelector('input[name="no_sop"]').value;
            const tglPembuatan = document.querySelector('input[name="tgl_pembuatan"]').value;
            const tglRevisi = document.querySelector('input[name="tgl_revisi"]').value;
            const tglAktif = document.querySelector('input[name="tgl_aktif"]').value;
            const disahkanOleh = document.querySelector('textarea[name="disahkan_oleh"]').value;
            const namaSop = document.querySelector('input[name="nama_sop"]').value;
            const dasarHukum = document.querySelector('textarea[name="dasar_hukum"]').value;
            const kualifikasiPelaksana = document.querySelector('textarea[name="kualifikasi_pelaksana"]').value;
            const keterkaitan = document.querySelector('textarea[name="keterkaitan"]').value;
            const peralatan = document.querySelector('textarea[name="peralatan"]').value;
            const peringatan = document.querySelector('textarea[name="peringatan"]').value;
            const pencatatan = document.querySelector('textarea[name="pencatatan"]').value;

            // Set values in preview
            document.getElementById('previewNoSop').innerText = noSop;
            document.getElementById('previewTglPembuatan').innerText = tglPembuatan;
            document.getElementById('previewTglRevisi').innerText = tglRevisi;
            document.getElementById('previewTglAktif').innerText = tglAktif;
            document.getElementById('previewDisahkanOleh').innerText = disahkanOleh;
            document.getElementById('previewNamaSop').innerText = namaSop;
            document.getElementById('previewDasarHukum').innerText = dasarHukum;
            document.getElementById('previewKualifikasiPelaksana').innerText = kualifikasiPelaksana;
            document.getElementById('previewKeterkaitan').innerText = keterkaitan;
            document.getElementById('previewPeralatan').innerText = peralatan;
            document.getElementById('previewPeringatan').innerText = peringatan;
            document.getElementById('previewPencatatan').innerText = pencatatan;

            // Show the preview table container
            document.getElementById('previewTableContainer').style.display = 'block';
        });
    </script>

    <script>
        function adjustHeightDasarHukum(element) {
            element.style.height = "auto"; // Reset height to auto to calculate scrollHeight
            element.style.height = element.scrollHeight + "px"; // Set height to the content
        }

        function adjustHeightKeterkaitan(element) {
            element.style.height = "auto"; // Reset height to auto to calculate scrollHeight
            element.style.height = element.scrollHeight + "px"; // Set height to the content
        }

        function adjustHeightPeringatan(element) {
            element.style.height = "auto"; // Reset height to auto to calculate scrollHeight
            element.style.height = element.scrollHeight + "px"; // Set height to the content
        }

        function adjustHeightKualifikasiPelaksana(element) {
            element.style.height = "auto"; // Reset height to auto to calculate scrollHeight
            element.style.height = element.scrollHeight + "px"; // Set height to the content
        }

        function adjustHeightPeralatan(element) {
            element.style.height = "auto"; // Reset height to auto to calculate scrollHeight
            element.style.height = element.scrollHeight + "px"; // Set height to the content
        }

        function adjustHeightPencatatan(element) {
            element.style.height = "auto"; // Reset height to auto to calculate scrollHeight
            element.style.height = element.scrollHeight + "px"; // Set height to the content
        }
    </script>

@endsection