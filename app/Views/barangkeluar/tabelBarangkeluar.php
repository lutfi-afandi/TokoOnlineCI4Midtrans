<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- JS -->
<script src="<?= base_url(); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<table id="databarangkeluar" class="table table-bordered table-hover dataTable dtr-inline collapsed" aria-describedby="example2_info">
    <thead>
        <tr>
            <th>No</th>
            <th>Faktur</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Total Harga (Rp)</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($barangkeluar->getResultArray() as $row) { ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['faktur']; ?></td>
                <td><?= $row['tglfaktur']; ?></td>
                <td><?= $row['pelnama']; ?></td>
                <td><?= number_format($row['totalharga'], 0, ",", "."); ?></td>
                <td>
                    <!-- <input type="hidden" name="faktur" value=""> -->
                    <button type="button" class="btn btn-sm btn-info" onclick="cetak('<?= $row['faktur'] ?>')">
                        <i class="fa fa-print"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="hapus('<?= $row['faktur'] ?>')">
                        <i class="fa fa-trash"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-primary" onclick="edit('<?= $row['faktur'] ?>')">
                        <i class="fa fa-edit"></i>
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        // tampilBarangkeluar();
        $('#databarangkeluar').DataTable();
    });
</script>