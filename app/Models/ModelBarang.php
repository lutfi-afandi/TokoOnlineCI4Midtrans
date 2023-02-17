<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarang extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'barang';
    protected $primaryKey       = 'brgkode';
    protected $allowedFields    = [
        'brgkode', 'brgnama', 'brgkatid', 'brgsatid', 'brggambar', 'brgharga', 'brgstok'
    ];

    public function tampildata()
    {
        return $this->table('barang')->join('kategori', 'brgkatid=katid')
            ->join('satuan', 'brgsatid=satid');
    }

    public function cariData($cari)
    {
        return $this->table('barang')->join('kategori', 'brgkatid=katid')
            ->join('satuan', 'brgsatid=satid')
            ->orlike('brgkode', $cari)
            ->orlike('brgnama', $cari)
            ->orlike('katnama', $cari);
    }
}
