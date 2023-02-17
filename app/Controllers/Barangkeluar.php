<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelBarangKeluar;
use App\Models\Modeldatabarang;
use App\Models\ModelDetailBarangKeluar;
use App\Models\ModelPelanggan;
use App\Models\ModelTempBarangKeluar;
use Config\Services;

class Barangkeluar extends BaseController
{

    private function buatFaktur()
    {
        $tanggalSekarang = date('Y-m-d');
        $modelBarangKeluar = new ModelBarangKeluar();

        $hasil = $modelBarangKeluar->noFaktur($tanggalSekarang)->getRowArray();
        $data = $hasil['nofaktur'];

        $lastNoUrut = substr($data, -4);
        // noUrut++
        $nextNoUrut = intval($lastNoUrut) + 1;
        // format nomor berikutnya
        $noFaktur = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);
        return $noFaktur;
    }

    public function buatNoFaktur()
    {
        $tanggalSekarang = $this->request->getPost('tanggal');
        $modelBarangKeluar = new ModelBarangKeluar();

        $hasil = $modelBarangKeluar->noFaktur($tanggalSekarang)->getRowArray();
        $data = $hasil['nofaktur'];

        $lastNoUrut = substr($data, -4);
        // noUrut++
        $nextNoUrut = intval($lastNoUrut) + 1;
        // format nomor berikutnya
        $noFaktur = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);
        $json = [
            'nofaktur' => $noFaktur
        ];

        echo json_encode($json);
    }
    public function index()
    {
        //
    }

    public function data()
    {
        $modelBarangKeluar = new ModelBarangKeluar();
        $data = [
            'barangkeluar'  => $modelBarangKeluar->getData(),
        ];
        return view('barangkeluar/viewdata', $data);
    }

    public function tabelBarangkeluar()
    {
        if ($this->request->isAJAX()) {
            $tglawal =  $this->request->getPost('tglawal');
            $tglakhir = $this->request->getPost('tglakhir');

            $modelBarangKeluar = new ModelBarangKeluar();

            if ($tglawal == '' && $tglakhir == '') {
                $dataBarangkeluar = $modelBarangKeluar->getData();
            } else {
                $dataBarangkeluar = $modelBarangKeluar->getData($tglawal, $tglakhir);
            }
            $data = [
                'barangkeluar'  => $dataBarangkeluar,
            ];

            $json = [
                'data'  => view('barangkeluar/tabelBarangkeluar', $data)
            ];

            echo json_encode($json);
        }
    }

    public function input()
    {

        // dd(date('d-m-Y'));
        $data = [
            'nofaktur'  => $this->buatFaktur()
        ];
        return view('barangkeluar/forminput', $data);
    }

    public function tampilDataTemp()
    {
        if ($this->request->isAJAX()) {
            $noFaktur = $this->request->getPost('nofaktur');

            $modalTempBarangKeluar = new ModelTempBarangKeluar();
            $dataTemp = $modalTempBarangKeluar->tampilDataTemp($noFaktur);
            $data = [
                'tampildata'    => $dataTemp
            ];

            $json = [
                'data'  => view('barangkeluar/datatemp', $data)
            ];

            echo json_encode($json);
        }
    }

    public function ambilDataBarang()
    {
        if ($this->request->isAJAX()) {
            $kodebarang = $this->request->getPost('kodebarang');
            $modelBarang = new ModelBarang();
            $ambilData = $modelBarang->find($kodebarang);

            if ($ambilData == NULL) {
                $json = [
                    'error' => 'Data barang tidak ditemukan...',
                ];
            } else {
                $data = [
                    'namabarang'    => $ambilData['brgnama'],
                    'hargajual' => $ambilData['brgharga']
                ];
                $json = [
                    'sukses'  => $data
                ];
            }



            echo json_encode($json);
        }
    }

    public function simpanItem()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $kodebarang = $this->request->getPost('kodebarang');
            $namabarang = $this->request->getPost('namabarang');
            $hargajual = $this->request->getPost('hargajual');
            $jml = $this->request->getPost('jml');

            $modelTempBarangKeluar = new ModelTempBarangKeluar();

            $modelBarang = new ModelBarang();
            $ambilDataBarang = $modelBarang->find($kodebarang);
            $stokBarang = $ambilDataBarang['brgstok'];

            if ($jml > intval($stokBarang)) {
                $json = ['error'    => 'Stok tidak mencukupi...'];
            } else {
                $modelTempBarangKeluar->insert([
                    'detfaktur'     => $nofaktur,
                    'detbrgkode'    => $kodebarang,
                    'dethargajual'  => $hargajual,
                    'detjumlah'     => $jml,
                    'detsubtotal'   => intval($jml) * intval($hargajual)
                ]);

                $json = [
                    'sukses'    => 'item berhasil ditambahkan'
                ];
            }

            echo json_encode($json);
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');

            $modelTempBarangKeluar = new ModelTempBarangKeluar();
            $modelTempBarangKeluar->delete($id);

            $json = [
                'sukses'    => 'Item berhasil dihapus!'
            ];

            echo json_encode($json);
        }
    }

    public function modalCariBarang()
    {
        if ($this->request->isAJAX()) {
            $modelBarang = new ModelBarang();
            $data = [
                'barang'    => $modelBarang->findAll()
            ];
            $json = [
                'data'  => view('barangkeluar/modalcaribarang', $data)
            ];

            echo json_encode($json);
        }
    }

    public function modalPembayaran()
    {

        $nofaktur = $this->request->getPost('nofaktur');
        $tglfaktur = $this->request->getPost('tglfaktur');
        $idpelanggan = $this->request->getPost('idpelanggan');
        $totalharga = $this->request->getPost('totalharga');

        $modelTemp = new ModelTempBarangKeluar();

        $cekData = $modelTemp->tampilDataTemp($nofaktur);
        if ($cekData->getNumRows() > 0) {
            $data = [
                'nofaktur'  => $nofaktur,
                'totalharga'    => $totalharga,
                'tglfaktur' => $tglfaktur,
                'idpelanggan'   => $idpelanggan
            ];

            $json = ['data' => view('barangkeluar/modelpembayaran', $data)];
        } else {
            $json = ['error' => 'Maaf item belum ada'];
        }

        echo json_encode($json);
    }

    public function simpanPembayaran()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $tglfaktur = $this->request->getPost('tglfaktur');
            $idpelanggan = $this->request->getPost('idpelanggan');
            $totalbayar = str_replace(".", "", $this->request->getPost('totalbayar'));
            $jumlahuang = str_replace(".", "", $this->request->getPost('jumlahuang'));
            $sisauang = str_replace(".", "", $this->request->getPost('sisauang'));
        }

        $modelBarangKeluar = new ModelBarangKeluar();
        // simpan ke tb barang keluar
        $modelBarangKeluar->insert([
            'faktur'    => $nofaktur,
            'tglfaktur' => $tglfaktur,
            'idpel' => $idpelanggan,
            'totalharga'    => $totalbayar,
            'jumlahuang'    => $jumlahuang,
            'sisauang'  => $sisauang,
        ]);

        $modelTemp = new ModelTempBarangKeluar();
        $dataTemp = $modelTemp->getWhere(['detfaktur'   => $nofaktur]);

        $fieldDetail = [];
        foreach ($dataTemp->getResultArray() as $row) {
            $fieldDetail[] = [
                'detfaktur' => $row['detfaktur'],
                'detbrgkode' => $row['detbrgkode'],
                'dethargajual' => $row['dethargajual'],
                'detjumlah' => $row['detjumlah'],
                'detsubtotal' => $row['detsubtotal'],
            ];
        }

        $modelDetail = new ModelDetailBarangKeluar();
        $modelDetail->insertBatch($fieldDetail);

        // hapus data temo
        $modelTemp->hapusData($nofaktur);

        $json = [
            'sukses'    => 'Transaksi berhasil disimpan',
            'cetakfaktur'  => site_url('barangkeluar/cetakfaktur/' . $nofaktur)
        ];

        echo json_encode($json);
    }

    public function cetakfaktur($faktur)
    {
        $modelBarangKeluar = new ModelBarangKeluar();
        $modelDetail = new ModelDetailBarangKeluar();
        $modelPelanggan = new ModelPelanggan();

        $cekData = $modelBarangKeluar->find($faktur);
        $dataPelanggan = $modelPelanggan->find($cekData['idpel']);

        $namaPelanggan = ($dataPelanggan != null) ? $dataPelanggan['pelnama'] : '-';

        if ($cekData != null) {
            $data = [
                'faktur'    => $faktur,
                'tanggal'   => $cekData['tglfaktur'],
                'namapelanggan' => $namaPelanggan,
                'detailbarang'  => $modelDetail->tampilDataTemp($faktur),
                'jumlahuang'  => $cekData['jumlahuang'],
                'sisauang'  => $cekData['sisauang'],
            ];

            return view('barangkeluar/cetakfaktur', $data);
        } else {
            return redirect()->to(site_url('barangkeluar/input'));
        }
    }

    public function hapusTransaksi()
    {
        $faktur = $this->request->getPost('faktur');
        $db = \Config\Database::connect();
        $modelBarangKeluar = new ModelBarangKeluar();

        $db->table('detail_barangkeluar')->delete(['detfaktur' => $faktur]);
        $modelBarangKeluar->delete($faktur);

        $json = ['sukses'   => 'Data transaksi di hapus'];
        echo json_encode($json);
    }

    public function edit($faktur)
    {
        $modelBarangKeluar = new ModelBarangKeluar();
        $modelPelanggan = new ModelPelanggan();
        $rowData = $modelBarangKeluar->find($faktur);
        $rowPelanggan = $modelPelanggan->find($rowData['idpel']);

        $data = [
            'nofaktur'  => $faktur,
            'tanggal'   => $rowData['tglfaktur'],
            'namapelanggan' => (!empty($rowPelanggan['pelnama'])) ? $rowPelanggan['pelnama'] : '',
        ];

        return view('barangkeluar/formedit', $data);
    }

    public function ambilTotalHarga()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $modelDetail = new ModelDetailBarangKeluar();

            $totalHarga = $modelDetail->ambilTotalHarga($nofaktur);
            $json = [
                'totalharga'    => "Rp. " . number_format($totalHarga, 0, ",", ".")
            ];
            echo json_encode($json);
        }
    }

    public function tampilDataDetail()
    {
        if ($this->request->isAJAX()) {
            $noFaktur = $this->request->getPost('nofaktur');

            $modelDetailBarangKeluar = new ModelDetailBarangKeluar();
            $dataTemp = $modelDetailBarangKeluar->tampilDataTemp($noFaktur);
            $data = [
                'tampildata'    => $dataTemp
            ];

            $json = [
                'data'  => view('barangkeluar/datadetail', $data)
            ];

            echo json_encode($json);
        }
    }

    public function hapusItemDetail()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');

            $modelDetailBarangKeluar = new ModelDetailBarangKeluar();
            $modelBarangKeluar = new ModelBarangKeluar();
            $rowData = $modelDetailBarangKeluar->find($id);
            $noFaktur = $rowData['detfaktur'];
            $modelDetailBarangKeluar->delete($id);

            $totalHarga = $modelDetailBarangKeluar->ambilTotalHarga($noFaktur);
            // $lakukan upfatr di total barang keluar
            $modelBarangKeluar->update($noFaktur, [
                'totalharga'    => $totalHarga
            ]);


            $json = [
                'sukses'    => 'Item berhasil dihapus!'
            ];

            echo json_encode($json);
        }
    }

    public function editItem()
    {
        if ($this->request->isAJAX()) {
            $iddetail = $this->request->getPost('iddetail');
            $jml = $this->request->getPost('jml');

            $modelDetail = new ModelDetailBarangKeluar();
            $modelBarangKeluar = new ModelBarangKeluar();

            $rowData = $modelDetail->find($iddetail);
            $noFaktur = $rowData['detfaktur'];
            $hargajual = $rowData['dethargajual'];

            // update pada detail
            $modelDetail->update($iddetail, [
                'detjumlah' => $jml,
                'detsubtotal'   => intval($hargajual) * $jml
            ]);

            // ambil total harga
            $totalHarga = $modelDetail->ambilTotalHarga($noFaktur);
            // updatebarang keluar
            $modelBarangKeluar->update($noFaktur, [
                'totalharga'    => $totalHarga
            ]);

            $json = [
                'sukses'    => 'item berhasil di update'
            ];

            echo json_encode($json);
        }
    }

    public function simpanItemDetail()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $kodebarang = $this->request->getPost('kodebarang');
            $namabarang = $this->request->getPost('namabarang');
            $hargajual = $this->request->getPost('hargajual');
            $jml = $this->request->getPost('jml');

            $modelDetailBarangKeluar = new ModelDetailBarangKeluar();

            $modelBarang = new ModelBarang();
            $ambilDataBarang = $modelBarang->find($kodebarang);
            $stokBarang = $ambilDataBarang['brgstok'];

            if ($jml > intval($stokBarang)) {
                $json = ['error'    => 'Stok tidak mencukupi...'];
            } else {
                $modelDetailBarangKeluar->insert([
                    'detfaktur'     => $nofaktur,
                    'detbrgkode'    => $kodebarang,
                    'dethargajual'  => $hargajual,
                    'detjumlah'     => $jml,
                    'detsubtotal'   => intval($jml) * intval($hargajual)
                ]);

                $modelBarangKeluar = new ModelBarangKeluar();
                // ambil total harga
                $totalHarga = $modelDetailBarangKeluar->ambilTotalHarga($nofaktur);
                // updatebarang keluar
                $modelBarangKeluar->update($nofaktur, [
                    'totalharga'    => $totalHarga
                ]);

                $json = [
                    'sukses'    => 'item berhasil ditambahkan'
                ];
            }

            echo json_encode($json);
        }
    }
}
