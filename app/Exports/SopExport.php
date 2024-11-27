<?php

namespace App\Exports;

use App\Models\Sop;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class SopExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    public function collection()
    {
        return Sop::all(); // Ambil semua data dari tabel Sop
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Sop',
            'Nomor SK',
            'Tahun',
            'Penghapusan', // Pisahkan menjadi kolom sendiri
            'Revisi',      // Pisahkan menjadi kolom sendiri
            'Penggabungan',// Pisahkan menjadi kolom sendiri
            'Penambahan',  // Pisahkan menjadi kolom sendiri
            'Tahun Perubahan',
            'Keterangan',
            'Upload SK Baru/Perubahan',
        ];
    }

    public function map($row): array
    {
        // Pisahkan nilai hasil_monitoring ke dalam kolom yang sesuai
        $penghapusan = '';
        $revisi = '';
        $penggabungan = '';
        $penambahan = '';

        // Tentukan kolom sesuai dengan nilai hasil_monitoring
        if (strpos(strtolower($row->hasil_monitoring), 'penghapusan') !== false) {
            $penghapusan = $row->hasil_monitoring;
        }
        if (strpos(strtolower($row->hasil_monitoring), 'revisi') !== false) {
            $revisi = $row->hasil_monitoring;
        }
        if (strpos(strtolower($row->hasil_monitoring), 'penggabungan') !== false) {
            $penggabungan = $row->hasil_monitoring;
        }
        if (strpos(strtolower($row->hasil_monitoring), 'penambahan') !== false) {
            $penambahan = $row->hasil_monitoring;
        }

        return [
            $row->id,
            $row->name,
            $row->nomor_sk,
            $row->tahun,
            $penghapusan,     // Masukkan ke kolom Penghapusan
            $revisi,          // Masukkan ke kolom Revisi
            $penggabungan,    // Masukkan ke kolom Penggabungan
            $penambahan,      // Masukkan ke kolom Penambahan
            $row->tahun_perubahan,
            $row->keterangan,
            $row->file_sk ? asset('storage/' . $row->file_sk) : '', // Link download file SK
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Menggabungkan header "Hasil Monitoring & Evaluasi" ke beberapa kolom
                $event->sheet->mergeCells('E1:H1'); // Menggabungkan E1 hingga H1
                $event->sheet->setCellValue('E1', 'Hasil Monitoring & Evaluasi');

                // Menambahkan header untuk kategori di bawahnya
                $event->sheet->setCellValue('E2', 'Penghapusan');
                $event->sheet->setCellValue('F2', 'Revisi');
                $event->sheet->setCellValue('G2', 'Penggabungan');
                $event->sheet->setCellValue('H2', 'Penambahan');

                // Menambahkan data mulai dari baris ke-3
                $rowIndex = 3;
                foreach ($this->collection() as $row) {
                    $event->sheet->setCellValue('A' . $rowIndex, $row->id);
                    $event->sheet->setCellValue('B' . $rowIndex, $row->name);
                    $event->sheet->setCellValue('C' . $rowIndex, $row->nomor_sk);
                    $event->sheet->setCellValue('D' . $rowIndex, $row->tahun);
                    $event->sheet->setCellValue('E' . $rowIndex, $row->hasil_monitoring);  // Penghapusan
                    $event->sheet->setCellValue('F' . $rowIndex, '');  // Revisi
                    $event->sheet->setCellValue('G' . $rowIndex, '');  // Penggabungan
                    $event->sheet->setCellValue('H' . $rowIndex, '');  // Penambahan
                    $event->sheet->setCellValue('I' . $rowIndex, $row->tahun_perubahan);
                    $event->sheet->setCellValue('J' . $rowIndex, $row->keterangan);
                    $event->sheet->setCellValue('K' . $rowIndex, $row->file_sk ? asset('storage/' . $row->file_sk) : '');
                    $rowIndex++;
                }
            }
        ];
    }


}
