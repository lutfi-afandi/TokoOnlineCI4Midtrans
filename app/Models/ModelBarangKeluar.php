<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarangKeluar extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'barangkeluar';
    protected $primaryKey       = 'faktur';
    protected $allowedFields    = [
        'faktur',  'tglfaktur',   'idpel',  'totalharga', 'jumlahuang', 'sisauang'
    ];

    public function noFaktur($tanggalSekarang)
    {
        return $this->table('barangkeluar')->select('max(faktur) as nofaktur')->where('tglfaktur', $tanggalSekarang)->get();
    }

    public function getData($tglawal = false, $tglakhir = false)
    {
        if ($tglawal != false && $tglakhir != false) {
            return $this->query("SELECT * FROM barangkeluar JOIN pelanggan ON pelid=idpel WHERE tglfaktur BETWEEN '" . $tglawal . "' AND '" . $tglakhir . "'");
        } else {
            return $this->table('barangkeluar')
                ->join('pelanggan', 'pelid=idpel', 'LEFT')
                ->get();
        }
    }
}
