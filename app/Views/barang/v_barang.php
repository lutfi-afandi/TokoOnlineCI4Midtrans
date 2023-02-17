<?= $this->extend('main/layout'); ?>


<?= $this->section('judul'); ?>
Manajemen Barang
<?= $this->endSection('judul'); ?>

<?= $this->section('subjudul'); ?>
<?= form_button('', '<i class="fa fa-plus-circle"></i> Tambah Data', [
    'class' => 'btn btn-primary',
    'onclick'   => "location.href=('" . site_url('barang/tambah') . "')",
]); ?>
<?= $this->endSection('subjudul'); ?>


<?= $this->section('isi'); ?>

<?= session()->getFlashdata('error'); ?>
<?= session()->getFlashdata('sukses'); ?>
<?= form_open('barang/index'); ?>
<div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Cari data barang" aria-label="Cari data barang" aria-describedby="button-addon2" name="cari" value="<?= $cari; ?>">
    <div class="input-group-append">
        <button class="btn btn-outline-primary" type="submit" id="tombolcari" name="tombolcari">
            <i class="fa fa-search"></i>
        </button>
    </div>
</div>
<?= form_close(); ?>
<span class="badge badge-success">Total data : <?= $totaldata; ?></span>
<table class="table table-striped table-bordered table-sm" style="width: 100%;">
    <thead>
        <tr>
            <th class="text-center" style="width: 5%;">No</th>
            <th>Kode Kategori</th>
            <th>Nama Kategori</th>
            <th>Kategori</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Stok</th>
            <th style="width: 15%;">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php $nomor = 1;
        $nomor = 1 + (($nohalaman - 1) * 10);
        foreach ($tampildata as $row) { ?>
            <tr>
                <td class="text-center"><?= $nomor++; ?></td>
                <td><?= $row['brgkode']; ?></td>
                <td><?= $row['brgnama']; ?></td>
                <td><?= $row['katnama']; ?></td>
                <td><?= $row['satnama']; ?></td>
                <td><?= number_format($row['brgharga'], 0); ?></td>
                <td><?= number_format($row['brgstok'], 0); ?></td>
                <td>
                    <button type="button" class="btn btn-info btn-sm" title="Edit data" onclick="edit('<?= $row['brgkode'] ?>')">
                        <i class="fa fa-edit"></i>
                    </button>

                    <form action="/barang/hapus/<?= $row['brgkode']; ?>" method="post" style="display: inline;" onsubmit="return hapus()">
                        <input type="hidden" value="DELETE" name="_method">
                        <button class="btn btn-danger btn-sm" title="Hapus data">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>

        <?php } ?>
    </tbody>
</table>
<div class="float-center mt-2">
    <?= $pager->links('satuan', 'paging'); ?>
</div>

<script>
    function edit(kode) {
        window.location.href = '<?= base_url("barang/edit/") ?>/' + kode;
    }

    function hapus(kode) {
        pesan = confirm("Yakin data barang ini dihapus?");
        if (pesan) {
            return true;
        } else {
            return false;
        }
    }
</script>
<?= $this->endSection('isi'); ?>