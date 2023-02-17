<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modeldatapelanggan;
use App\Models\ModelPelanggan;
use CodeIgniter\Config\Services;

class Pelanggan extends BaseController
{
    public function index()
    {
        //
    }

    public function formtambah()
    {
        $json = ['data'  => view('pelanggan/modaltambah')];
        echo json_encode($json);
    }

    public function simpan()
    {
        $namapelanggan = $this->request->getPost('namapel');
        $telp = $this->request->getPost('telp');

        $validation = Services::validation();

        $valid = $this->validate([
            'namapel' => [
                'rules' => 'required',
                'label' => 'Nama pelanggan',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong'
                ]
            ],
            'telp' => [
                'rules' => 'required|is_unique[pelanggan.peltelp]',
                'label' => 'Nomor telepon',
                'errors'    => [
                    'required'  => '{field} tidak boleh kosong',
                    'is_unique' => 'Nomor telepon sudah terdaftar'
                ]
            ],
        ]);

        if (!$valid) {
            $json = [
                'error' => [
                    'errNamaPelanggan'  => $validation->getError('namapel'),
                    'errTelp'  => $validation->getError('telp'),
                ]
            ];
        } else {
            $modelPelanggan = new ModelPelanggan();

            $modelPelanggan->insert([
                'pelnama'   => $namapelanggan,
                'peltelp'   => $telp
            ]);

            $rowData = $modelPelanggan->ambilDataTerakhir()->getRowArray();

            $json = [
                'sukses'    => 'Data pelanggan berhasil disimpan, ambil data terakhir?',
                'namapelanggan' => $rowData['pelnama'],
                'idpelanggan'   => $rowData['pelid'],
            ];
        }

        echo json_encode($json);
    }


    public function modalData()
    {
        if ($this->request->isAjax()) {
            $json = [
                'data'  => view('pelanggan/modaldata')
            ];
            echo json_encode($json);
        }
    }

    public function listData()
    {
        $request = Services::request();
        $datamodel = new Modeldatapelanggan($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tombolPilih = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"pilih('" . $list->pelid . "','" . $list->pelnama . "')\">pilih</button>";
                $tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->pelid . "','" . $list->pelnama . "')\">hapus</button>";

                $row[] = $no;
                $row[] = $list->pelnama;
                $row[] = $list->peltelp;
                $row[] = $tombolPilih . " " . $tombolHapus;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');

            $modelPelanggan = new ModelPelanggan();
            $modelPelanggan->delete($id);

            $json = [
                'sukses'    => 'Data pelanggan berhasil di hapus'
            ];
            echo json_encode($json);
        }
    }
}
