<?= $this->extend('main/layout'); ?>


<?= $this->section('judul'); ?>
Data Transaksi Barang Masuk
<?= $this->endSection('judul'); ?>

<?= $this->section('subjudul'); ?>
<?= form_button('', '<i class="fa fa-plus-circle"></i> Input Transaksi', [
    'class' => 'btn btn-primary',
    'onclick'   => "location.href=('" . site_url('barangmasuk/index') . "')",
]); ?>
<?= $this->endSection('subjudul'); ?>

<?= $this->section('isi'); ?>

<?= form_open('barangmasuk/data'); ?>
<div class="input-group mb-1">
    <input type="text" class="form-control" placeholder="Cari Berdasarkan Faktur" aria-label="Cari faktur barang" aria-describedby="button-addon2" name="cari" value="<?= $cari; ?>">
    <div class="input-group-append">
        <button class="btn btn-outline-primary" type="submit" id="tombolcari" name="tombolcari">
            <i class="fa fa-search"></i>
        </button>
    </div>
</div>
<span class="badge badge-success mb-1">Total Data : <?= $totaldata; ?></span>
<?= form_close(); ?>

<table class="table table-sm table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Faktur</th>
            <th>Tanggal</th>
            <th>Jumlah Item</th>
            <th>Total Harga (Rp)</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php

        use Config\Database;

        $nomor = 1 + (($nohalaman - 1) * 10);
        foreach ($tampildata as $row) : ?>
            <tr>
                <td><?= $nomor; ?></td>
                <td><?= $row['faktur']; ?></td>
                <td><?= date('d-m-Y', strtotime($row['tglfaktur'])); ?></td>
                <td align=center>
                    <?php
                    $db = \Config\Database::connect();
                    $jumlahItem  = $db->table('detail_barangmasuk')->where('detfaktur', $row['faktur'])->countAllResults();
                    ?>
                    <span style="cursor: pointer; font-weight: bold; color:blue;" onclick="detailItem('<?= $row['faktur'] ?>')"><?= $jumlahItem; ?></span>
                </td>
                <td><?= number_format($row['totalharga'], 0, ",", "."); ?></td>
                <td>
                    <button type="button" class="btn btn-outline-info btn-sm" title="Edit Transaksi" onclick="edit('<?= sha1($row['faktur']) ?>')">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm" title="Hapus Transaksi" onclick="hapusTransaksi('<?= $row['faktur'] ?>')">
                        <i class="fa fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>

    </tbody>
</table>
<div class="viewmodal" style="display:none;"></div>
<div class="float-center mt-2">
    <?= $pager->links('barangmasuk', 'paging'); ?>
</div>

<script>
    function detailItem(faktur) {
        $.ajax({
            type: "post",
            url: "/barangmasuk/detailItem",
            data: {
                faktur: faktur
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalitem').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    function edit(faktur) {
        window.location.href = ('/barangmasuk/edit/') + faktur;
    }

    function hapusTransaksi(faktur) {
        console.log(faktur)
        Swal.fire({
            title: 'Hapus Item',
            text: "Yakin menghapus transaksi ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "/barangmasuk/hapusTransaksi",
                    data: {
                        faktur: faktur
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.sukses,
                            }).then((result) => {
                                window.location.reload();

                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });
            }
        })
    }
</script>
<?= $this->endSection('isi'); ?>