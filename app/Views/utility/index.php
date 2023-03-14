<?= $this->extend('main/layout'); ?>


<?= $this->section('judul'); ?>
Utility Sistem
<?= $this->endSection('judul'); ?>

<?= $this->section('subjudul'); ?>
Backup Database
<?= $this->endSection('subjudul'); ?>


<?= $this->section('isi'); ?>
<?= session()->getFlashdata('pesan'); ?>
<button class="btn btn-primary" onclick="location.href=('/utility/doBackup')">
    Click To Backup Database
</button>
<?= $this->endSection('isi'); ?>