<?php

namespace App\Models;

use CodeIgniter\Model;

class Modeldetailbarangmasuk extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'detail_barangmasuk';
    protected $primaryKey       = 'iddetail';
    protected $allowedFields    = [
        'iddetail',  'detfaktur',  'detbrgkode',  'dethargamasuk',  'dethargajual',  'detjumlah',  'detsubtotal'
    ];

    public function dataDetail($faktur)
    {
        return $this->table('detail_barangmasuk')
            ->join('barang', 'brgkode=detbrgkode')
            ->where('detfaktur', $faktur)->get();
    }

    public function ambilTotalHarga($faktur)
    {
        $query = $this->table('detail_barangmasuk')->getWhere([
            'detfaktur' => $faktur
        ]);

        $totalHarga = 0;
        foreach ($query->getResultArray() as $r) {
            $totalHarga += $r['detsubtotal'];
        }

        return $totalHarga;
    }

    public function ambilDetailBerdasarkanID($id)
    {
        return $this->table('detail_barangmasuk')
            ->join('barang', 'brgkode=detbrgkode')
            ->where('iddetail', $id)->get();
    }
}
