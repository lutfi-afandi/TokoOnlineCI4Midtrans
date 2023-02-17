<table class="table table-sm table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($tampildata->getResultArray() as $row) { ?>
            <tr>
                <td><?= $nomor++; ?></td>
                <td><?= $row['brgkode']; ?></td>
                <td><?= $row['brgnama']; ?></td>
                <td><?= number_format($row['brgharga'], 0, ",", "."); ?></td>
                <td><?= number_format($row['brgstok'], 0, ",", ".") ?></td>
                <td>
                    <button class="btn btn-sm btn-info" onclick="pilih('<?= $row['brgkode']; ?>')" type="button">pilih </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function pilih(kode) {
        $('#kdbarang').val(kode);
        $('#modalbarang').on('hidden.bs.modal', function(event) {
            // do something...
            ambilDataBarang();
        })
        $('#modalbarang').modal('hide');
    }
</script>