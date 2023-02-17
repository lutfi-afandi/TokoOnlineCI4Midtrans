<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelKategori;

class Kategori extends BaseController
{

    public function __construct()
    {
        $this->kategori = new ModelKategori();
    }

    public function index()
    {
        $tombolcari = $this->request->getPost('tombolcari');
        if (isset($tombolcari)) {
            $cari = $this->request->getPost('cari');
            session()->set('cari_kategori', $cari);
            redirect()->to('/kategori/index');
        } else {
            $cari = session()->get('cari_kategori');
        }

        $dataKategori = $cari ? $this->kategori->cariData($cari)->paginate(5, 'kategori') : $this->kategori->paginate(5, 'kategori');
        $nohalaman = $this->request->getVar('page_kategori') ? $this->request->getVar('page_kategori') : 1;
        $data = [
            'tampildata'    => $dataKategori,
            'pager' => $this->kategori->pager,
            'nohalaman' => $nohalaman,
            'cari'  => $cari
        ];
        return view('kategori/v_kategori', $data);
    }

    public function formtambah()
    {
        return view('kategori/formtambah');
    }

    public function simpandata()
    {
        $namakategori = $this->request->getVar('namakategori');
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'namakategori'  => [
                'rules'     => 'required',
                'label'     => 'Nama Kategori',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong'
                ],
            ]
        ]);

        if (!$valid) {
            $pesan = [
                'errorNamaKategori' => '<div class="text-danger">' . $validation->getError() . '</div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/kategori/formtambah');
        } else {
            $this->kategori->insert(['katnama' => $namakategori]);
            $pesan = [
                'sukses' => '<div class="alert alert-success">Data Kategori Berhasil Ditambahkan....</div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->to('/kategori/index');
        }
    }

    public function formedit($id)
    {
        $rowData = $this->kategori->find($id);

        if ($rowData) {

            $data = [
                'id' => $id,
                'nama'  => $rowData['katnama'],
            ];
            return view('kategori/formedit', $data);
        } else {
            exit('Data tidak ditemukan');
        }
    }

    public function updatedata()
    {
        $namakategori = $this->request->getVar('namakategori');
        $idkategori = $this->request->getVar('idkategori');
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'namakategori'  => [
                'rules'     => 'required',
                'label'     => 'Nama Kategori',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong'
                ],
            ]
        ]);

        if (!$valid) {
            $pesan = [
                'errorNamaKategori' => '<div class="text-danger">' . $validation->getError() . '</div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/kategori/formedit/' . $idkategori);
        } else {
            $this->kategori->update($idkategori, ['katnama' => $namakategori]);
            $pesan = [
                'sukses' => '<div class="alert alert-success">Data Kategori Berhasil Diubah....</div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->to('/kategori/index');
        }
    }

    public function hapus($id)
    {
        $this->kategori->delete($id);

        $pesan = [
            'sukses' => '<div class="alert alert-success">Data Kategori Berhasil Dihapus....</div>'
        ];

        session()->setFlashdata($pesan);
        return redirect()->to('/kategori/index');
    }
}
