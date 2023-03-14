<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarangKeluar;
use App\Models\Modelbarangmasuk;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Witer\Xlsx;

class Laporan extends BaseController
{
    public function index()
    {
        return view('laporan/index');
    }

    public function cetak_barang_masuk()
    {
        return view('laporan/viewbarangmasuk');
    }

    public function cetak_barang_masuk_periode()
    {
        $tombolCetak = $this->request->getPost('btnCetak');
        $tombolExport = $this->request->getPost('btnExport');
        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $modelBarangMasuk = new Modelbarangmasuk();

        $dataLaporan = $modelBarangMasuk->laporanPerPeriode($tglawal, $tglakhir);
        if (isset($tombolCetak)) {
            $data = [
                'datalaporan' => $dataLaporan,
                'tglawal'   => $tglawal,
                'tglakhir'  => $tglakhir
            ];
            return view('laporan/cetakLaporanBarangMasuk', $data);
        }

        if (isset($tombolExport)) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Data Barang Masuk');
            $sheet->mergeCells('A1:D1');
            $sheet->getStyle('A1')->getFont()->setBold(true);
            $styleColumn = [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    ],
                ],
            ];
            $styleData = [
                'alignment' => [
                    // 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];

            $sheet->setCellValue('A3', 'No');
            $sheet->setCellValue('B3', 'No. Faktur');
            $sheet->setCellValue('C3', 'Tanggal');
            $sheet->setCellValue('D3', 'Total Harga');
            $sheet->getStyle('A3:D3')->applyFromArray($styleColumn);

            $no = 1;
            $numRow = 4;

            foreach ($dataLaporan->getResultArray() as $row) {
                $sheet->setCellValue('A' . $numRow, $no);
                $sheet->setCellValue('B' . $numRow, $row['faktur']);
                $sheet->setCellValue('C' . $numRow, $row['tglfaktur']);
                $sheet->setCellValue('D' . $numRow, $row['totalharga']);

                $sheet->getStyle('A' . $numRow . ':D' . $numRow)->applyFromArray($styleData);
                $no++;
                $numRow++;
            }

            $sheet->getDefaultRowDimension()->setRowHeight(-1);
            $sheet->getPageSetup()->setOrientation((\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE));
            $sheet->setTitle('Laporan Barang Masuk');

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="BarangMasuk.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
        }
    }

    public function cetak_barang_keluar()
    {
        return view('laporan/viewbarangkeluar');
    }

    public function cetak_barang_keluar_periode()
    {
        // dd($this->request);
        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $modelBarangKeluar = new ModelBarangKeluar();

        $dataLaporan = $modelBarangKeluar->laporanPerPeriode($tglawal, $tglakhir);


        $data = [
            'datalaporan' => $dataLaporan,
            'tglawal'   => $tglawal,
            'tglakhir'  => $tglakhir
        ];
        return view('laporan/cetakLaporanBarangKeluar', $data);
    }

    public function tampilGrafikBarangMasuk()
    {
        $bulan = $this->request->getPost('bulan');
        $db = \Config\Database::connect();

        $query = $db->query("SELECT tglfaktur AS tgl, totalharga FROM barangmasuk WHERE DATE_FORMAT(tglfaktur, '%Y-%m') = '$bulan' ORDER BY tglfaktur ASC")->getResult();

        $data = [
            'grafik'    => $query
        ];

        $json = [
            'data'  => view('laporan/grafikbarangmasuk', $data)
        ];

        echo json_encode($json);
    }
}
