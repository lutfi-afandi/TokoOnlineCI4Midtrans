<?= $this->extend('main/layout'); ?>


<?= $this->section('judul'); ?>
Cetak Laporan
<?= $this->endSection('judul'); ?>

<?= $this->section('subjudul'); ?>
Silakan Pilih Laporan yang Ingin Dicetak
<?= $this->endSection('subjudul'); ?>

<?= $this->section('isi'); ?>

<div class="col-lg-4">
    <button type="button" class="btn btn-block btn-lg btn-success pt-5 pb-5" onclick="window.location=('/laporan/cetak_barang_masuk')">
        <i class="fa fa-file"></i> LAPORAN BARANG MASUK
    </button>
</div>
<div class="col-lg-4">

</div>
<div class="col-lg-4">

</div>

<?= $this->endSection('isi'); ?>