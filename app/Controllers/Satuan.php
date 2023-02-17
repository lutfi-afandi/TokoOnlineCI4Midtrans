<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelSatuan;

class Satuan extends BaseController
{
    public function __construct()
    {
        $this->satuan = new ModelSatuan();
    }
    public function index()
    {
        $tombolcari = $this->request->getPost('tombolcari');
        if (isset($tombolcari)) {
            $cari = $this->request->getPost('cari');
            session()->set('cari_satuan', $cari);
            redirect()->to('/satuan/index');
        } else {
            $cari = session()->get('cari_satuan');
        }

        $dataSatuan = $cari ? $this->satuan->cariData($cari)->paginate(5, 'satuan') : $this->satuan->paginate(5, 'satuan');
        $nohalaman = $this->request->getVar('page_satuan') ? $this->request->getVar('page_satuan') : 1;
        $data = [
            'tampildata'    => $dataSatuan,
            'pager' => $this->satuan->pager,
            'nohalaman' => $nohalaman,
            'cari'  => $cari
        ];
        return view('satuan/v_satuan', $data);
    }

    public function formtambah()
    {
        return view('satuan/formtambah');
    }

    public function simpandata()
    {
        $namasatuan = $this->request->getVar('namasatuan');
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'namasatuan'  => [
                'rules'     => 'required',
                'label'     => 'Nama Satuan',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong'
                ],
            ]
        ]);

        if (!$valid) {
            $pesan = [
                'errorNamaSatuan' => '<div class="text-danger">' . $validation->getError() . '</div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/satuan/formtambah');
        } else {
            $this->satuan->insert(['satnama' => $namasatuan]);
            $pesan = [
                'sukses' => '<div class="alert alert-success">Data Satuan Berhasil Ditambahkan....</div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->to('/satuan/index');
        }
    }

    public function formedit($id)
    {
        $rowData = $this->satuan->find($id);

        if ($rowData) {

            $data = [
                'id' => $id,
                'nama'  => $rowData['satnama'],
            ];
            return view('satuan/formedit', $data);
        } else {
            exit('Data tidak ditemukan');
        }
    }

    public function updatedata()
    {
        $namasatuan = $this->request->getVar('namasatuan');
        $idsatuan = $this->request->getVar('idsatuan');
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'namasatuan'  => [
                'rules'     => 'required',
                'label'     => 'Nama Satuan',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong'
                ],
            ]
        ]);

        if (!$valid) {
            $pesan = [
                'errorNamaSatuan' => '<div class="text-danger">' . $validation->getError() . '</div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/satuan/formedit/' . $idsatuan);
        } else {
            $this->satuan->update($idsatuan, ['satnama' => $namasatuan]);
            $pesan = [
                'sukses' => '<div class="alert alert-success">Data Satuan Berhasil Diubah....</div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->to('/satuan/index');
        }
    }

    public function hapus($id)
    {
        $this->satuan->delete($id);

        $pesan = [
            'sukses' => '<div class="alert alert-success">Data Satuan Berhasil Dihapus....</div>'
        ];

        session()->setFlashdata($pesan);
        return redirect()->to('/satuan/index');
    }
}
