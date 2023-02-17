<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelKategori;
use App\Models\ModelSatuan;

class Barang extends BaseController
{
    public function __construct()
    {
        $this->barang = new ModelBarang();
    }
    public function index()
    {
        $tombolcari = $this->request->getPost('tombolcari');
        if (isset($tombolcari)) {
            $cari = $this->request->getPost('cari');
            session()->set('cari_barang', $cari);
            redirect()->to('/barang/index');
        } else {
            $cari = session()->get('cari_barang');
        }

        $totalData = $cari ? $this->barang->cariData($cari)->countAllResults() : $this->barang->tampildata()->countAllResults();

        $dataBarang = $cari ? $this->barang->cariData($cari)->paginate(10, 'barang') : $this->barang->tampildata()->paginate(10, 'barang');
        $nohalaman = $this->request->getVar('page_barang') ? $this->request->getVar('page_barang') : 1;
        $data = [
            'tampildata'    => $dataBarang,
            'pager' => $this->barang->pager,
            'nohalaman' => $nohalaman,
            'cari'  => $cari,
            'totaldata'    => $totalData
        ];
        // dd($data);
        return view('barang/v_barang', $data);
    }

    public function tambah()
    {
        $modelkategori = new ModelKategori();
        $modelsatuan = new ModelSatuan();
        $data = [
            'datakategori'      => $modelkategori->findAll(),
            'datasatuan'        => $modelsatuan->findAll()
        ];
        return view('barang/formtambah', $data);
    }

    public function simpandata()
    {
        $kodebarang = $this->request->getVar('kodebarang');
        $namabarang = $this->request->getVar('namabarang');
        $kategori = $this->request->getVar('kategori');
        $satuan = $this->request->getVar('satuan');
        $harga = $this->request->getVar('harga');
        $stok = $this->request->getVar('stok');
        // dd($this->request->getVar());
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'kodebarang'    => [
                'rules' => 'required|is_unique[barang.brgkode]',
                'label' => 'Kode Barang',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong',
                    'is_unique'  => '{field} sudah ada..'
                ]
            ],
            'namabarang'    => [
                'rules' => 'required',
                'label' => 'Nama Barang',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong',
                ]
            ],
            'kategori'    => [
                'rules' => 'required',
                'label' => 'Kategori',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong',
                ]
            ],
            'satuan'    => [
                'rules' => 'required',
                'label' => 'Satuan',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong',
                ]
            ],
            'harga'    => [
                'rules' => 'required|numeric',
                'label' => 'Harga',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong',
                    'numeric'  => '{field} hanya boleh angka',
                ]
            ],
            'stok'    => [
                'rules' => 'required|numeric',
                'label' => 'Stok',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong',
                    'numeric'  => '{field} hanya boleh angka',
                ]
            ],
            'gambar'    => [
                'rules' => 'mime_in[gambar,image/png,image/jpg,image/jpeg]|ext_in[gambar,png,jpg,jpeg]',
                'label' => 'Gambar'
            ],
        ]);

        if (!$valid) {
            $sess_Pesan = [
                'error' => '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> Alert!</h5>' . $validation->listErrors() . '
                </div>'
            ];

            session()->setFlashdata($sess_Pesan);
            return redirect()->to('/barang/tambah');
        } else {
            $gambar = $_FILES['gambar']['name'];
            if ($gambar != null) {
                $namaFileGambar  = $kodebarang;
                $fileGambar = $this->request->getFile('gambar');
                $fileGambar->move('assets/upload', $namaFileGambar . '.' . $fileGambar->getExtension());

                $pathGambar = 'assets/upload/' . $fileGambar->getName();
            } else {
                $pathGambar = '';
            }
            $this->barang->insert([
                'brgkode'   => $kodebarang,
                'brgnama'   => $namabarang,
                'brgkatid'   => $kategori,
                'brgsatid'     => $satuan,
                'brgharga'      => $harga,
                'brgstok'   => $stok,
                'brggambar' => $pathGambar,
            ]);

            $pesan_sukses = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-chack"></i> Berhasil!</h5> Data Barang berhasil di simpan!
                </div>'
            ];
            session()->setFlashdata($pesan_sukses);
            return redirect()->to('/barang/index');
        }
    }

    public function edit($kode)
    {
        $modelkategori = new ModelKategori();
        $modelsatuan = new ModelSatuan();
        $cekData = $this->barang->find($kode);
        if ($cekData) {
            $data = [
                'kodebarang'    => $cekData['brgkode'],
                'namabarang'    => $cekData['brgnama'],
                'kategori'    => $cekData['brgkatid'],
                'satuan'    => $cekData['brgsatid'],
                'harga'    => $cekData['brgharga'],
                'stok'    => $cekData['brgstok'],
                'datakategori'  => $modelkategori->findAll(),
                'datasatuan'        => $modelsatuan->findAll(),
                'gambar'    => $cekData['brggambar']
            ];
            // dd($data);
            return view('barang/formedit', $data);
        } else {
            $sess_Pesan = [
                'error' => '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> Error!</h5> Data Barang tidak ditemukan
                </div>'
            ];

            session()->setFlashdata($sess_Pesan);
            return redirect()->to('/barang/index');
        }
    }

    public function updatedata()
    {
        $kodebarang = $this->request->getVar('kodebarang');
        $namabarang = $this->request->getVar('namabarang');
        $kategori = $this->request->getVar('kategori');
        $satuan = $this->request->getVar('satuan');
        $harga = $this->request->getVar('harga');
        $stok = $this->request->getVar('stok');
        // dd($this->request->getVar());
        $validation = \Config\Services::validation();
        $valid = $this->validate([

            'namabarang'    => [
                'rules' => 'required',
                'label' => 'Nama Barang',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong',
                ]
            ],
            'kategori'    => [
                'rules' => 'required',
                'label' => 'Kategori',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong',
                ]
            ],
            'satuan'    => [
                'rules' => 'required',
                'label' => 'Satuan',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong',
                ]
            ],
            'harga'    => [
                'rules' => 'required|numeric',
                'label' => 'Harga',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong',
                    'numeric'  => '{field} hanya boleh angka',
                ]
            ],
            'stok'    => [
                'rules' => 'required|numeric',
                'label' => 'Stok',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong',
                    'numeric'  => '{field} hanya boleh angka',
                ]
            ],
            'gambar'    => [
                'rules' => 'mime_in[gambar,image/png,image/jpg,image/jpeg]|ext_in[gambar,png,jpg,jpeg]',
                'label' => 'Gambar'
            ],
        ]);

        if (!$valid) {
            $sess_Pesan = [
                'error' => '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> Alert!</h5>' . $validation->listErrors() . '
                </div>'
            ];

            session()->setFlashdata($sess_Pesan);
            return redirect()->to('/barang/edit/' . $kodebarang);
        } else {
            $cekData = $this->barang->find($kodebarang);
            $pathGambarLama = $cekData['brggambar'];
            $gambar = $_FILES['gambar']['name'];
            if ($gambar != null) {

                ($pathGambarLama == '' || $pathGambarLama == NULL) ? '' : unlink($pathGambarLama);

                $namaFileGambar  = $kodebarang;
                $fileGambar = $this->request->getFile('gambar');
                $fileGambar->move('assets/upload', $namaFileGambar . '.' . $fileGambar->getExtension());

                $pathGambar = 'assets/upload/' . $fileGambar->getName();
            } else {
                $pathGambar = $pathGambarLama;
            }
            $this->barang->update($kodebarang, [
                'brgnama'   => $namabarang,
                'brgkatid'   => $kategori,
                'brgsatid'     => $satuan,
                'brgharga'      => $harga,
                'brgstok'   => $stok,
                'brggambar' => $pathGambar,
            ]);

            $pesan_sukses = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Berhasil!</h5> Data Barang <strong>' . $kodebarang . '</strong> berhasil di Ubah!
                </div>'
            ];
            session()->setFlashdata($pesan_sukses);
            return redirect()->to('/barang/index');
        }
    }

    public function hapus($kode)
    {
        $cekData = $this->barang->find($kode);
        if ($cekData) {
            $pathGambarLama = $cekData['brggambar'];
            ($pathGambarLama == '' || $pathGambarLama == NULL) ? '' : unlink($pathGambarLama);

            $this->barang->delete($kode);
            $pesan_sukses = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Berhasil!</h5> Data Barang <strong>' . $kode . '</strong> berhasil di Hapus!
                </div>'
            ];
            session()->setFlashdata($pesan_sukses);
            return redirect()->to('/barang/index');
        } else {
            $pesan_error = [
                'error' => '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> Alert!</h5> Kode Barang tidak DItemukan</div>'
            ];

            session()->setFlashdata($pesan_error);
            return redirect()->to('/barang/index/');
        }

        $pesan = [
            'sukses' => '<div class="alert alert-success">Data Barang Berhasil Dihapus....</div>'
        ];

        session()->setFlashdata($pesan);
        return redirect()->to('/barang/index');
    }
}
