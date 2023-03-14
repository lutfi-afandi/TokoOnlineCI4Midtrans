<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ifsnop\Mysqldump\Mysqldump;

class Utility extends BaseController
{
    public function index()
    {
        return view('utility/index');
    }

    public function doBackup()
    {
        try {

            $tglsekarang = date('dymHis');

            $dump = new Mysqldump('mysql:host=localhost;dbname=dbgudang;port=3306', 'root', '');
            $dump->start('database/backup/dbbackup-' . $tglsekarang . '.sql');
            $pesan = "Backup berhasil...";
            session()->setFlashdata('pesan', $pesan);
            return redirect()->to('/utility/index');
        } catch (\Exception $e) {
            $pesan = "mysqldump-php error " . $e->getMessage();
            session()->setFlashdata('pesan', $pesan);
            return redirect()->to('/utility/index');
        }
    }
}
