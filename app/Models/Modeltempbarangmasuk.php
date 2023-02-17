<?php

namespace App\Models;

use CodeIgniter\Model;

class Modeltempbarangmasuk extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'temp_barangmasuk';
    protected $primaryKey       = 'iddetail';
    protected $allowedFields    = [
        'iddetail',  'detfaktur',  'detbrgkode',  'dethargamasuk',  'dethargajual',  'detjumlah',  'detsubtotal'
    ];

    public function tampilDataTemp($faktur)
    {
        return $this->table('temp_barangmasuk')
            ->join('barang', 'brgkode=detbrgkode')
            ->where(['detfaktur' => $faktur])
            ->get();
    }
}
