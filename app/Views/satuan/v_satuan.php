<?= $this->extend('main/layout'); ?>


<?= $this->section('judul'); ?>
Manajemen Satuan
<?= $this->endSection('judul'); ?>

<?= $this->section('subjudul'); ?>
<?= form_button('', '<i class="fa fa-plus-circle"></i> Tambah Data', [
    'class' => 'btn btn-primary',
    'onclick'   => "location.href=('" . site_url('satuan/formtambah') . "')",
]); ?>
<?= $this->endSection('subjudul'); ?>


<?= $this->section('isi'); ?>
<?= session()->getFlashdata('sukses'); ?>
<?= form_open('satuan/index'); ?>
<div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Cari data satuan" aria-label="Cari data satuan" aria-describedby="button-addon2" name="cari" value="<?= $cari; ?>">
    <div class="input-group-append">
        <button class="btn btn-outline-primary" type="submit" id="tombolcari" name="tombolcari">
            <i class="fa fa-search"></i>
        </button>
    </div>
</div>
<?= form_close(); ?>
<table class="table table-striped table-bordered table-sm" style="width: 100%;">
    <thead>
        <tr>
            <th class="text-center" style="width: 5%;">No</th>
            <th>Nama Satuan</th>
            <th style="width: 15%;">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php $nomor = 1;
        $nomor = 1 + (($nohalaman - 1) * 5);
        foreach ($tampildata as $row) { ?>
            <tr>
                <td class="text-center"><?= $nomor++; ?></td>
                <td><?= $row['satnama']; ?></td>
                <td>
                    <button class="btn btn-info" title="Edit data" onclick="edit(<?= $row['satid'] ?>)">
                        <i class="fa fa-edit"></i>
                    </button>

                    <form action="/satuan/hapus/<?= $row['satid']; ?>" method="post" style="display: inline;" onsubmit="hapus()">
                        <input type="hidden" value="DELETE" name="_method">
                        <button class="btn btn-danger" title="Hapus data">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>

        <?php } ?>
    </tbody>

</table>
<div class="float-center mt-2 ">
    <?= $pager->links('satuan', 'paging'); ?>
</div>


<script>
    function edit(id) {
        window.location.href = '<?= base_url('satuan/formedit') ?>/' + id;
    }

    function hapus() {
        pesan = confirm('Yakin hapus data satuan');
        if (pesan) {
            return true;
        } else {
            return false;
        }
    }
</script>
<?= $this->endSection('isi'); ?>