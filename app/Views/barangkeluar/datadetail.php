<table class="table table-sm table-hover table-bordered" style="width: 100%;" id="datadetail">
    <thead>
        <tr>
            <th colspan="5"></th>
            <th colspan="2" class="text-right">
                <?php $totalHarga = 0;
                foreach ($tampildata->getResultArray() as $row) {
                    $totalHarga += $row['detsubtotal'];
                } ?>
                <h1>Rp. <?= number_format($totalHarga, 0, ",", "."); ?></h1>
                <input type="hidden" id="totalharga" name="totalharga" value="<?= $totalHarga; ?>">
            </th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga Jual</th>
            <th>Jml</th>
            <th>Sub. Total</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $nomor = 1;
        foreach ($tampildata->getResultArray() as $row) { ?>
            <tr>
                <td><?= $nomor++; ?> <input type="hidden" id="id" value="<?= $row['id']; ?>"></td>
                <td><?= $row['detbrgkode']; ?></td>
                <td><?= $row['brgnama']; ?></td>
                <td class="text-right"><?= number_format($row['dethargajual'], 0, ",", "."); ?></td>
                <td class="text-right"><?= number_format($row['detjumlah'], 0, ",", "."); ?></td>
                <td class="text-right"><?= number_format($row['detsubtotal'], 0, ",", "."); ?></td>
                <td class="text-right">
                    <button type="button" onclick="hapusItem('<?= $row['id']; ?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i></button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function hapusItem(id) {
        Swal.fire({
            title: 'Hapus Item?',
            text: "Yakin item ini dihapus?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "/barangkeluar/hapusItemDetail",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire('Berhasil!', response.sukses, 'success');
                            tampilDataDetail();
                            ambilTotalHarga();
                            kosong();
                        }
                    }
                });
            }
        })
    }

    $('#datadetail tbody').on('click', 'tr', function() {
        let row = $(this).closest('tr');

        let kodebarang = row.find('td:eq(1)').text();
        let jml = row.find('td:eq(4)').text();
        let id = row.find('td input').val();
        // console.log(jml)
        $('#iddetail').val(id);
        $('#kodebarang').val(kodebarang);
        $('#jml').val(jml);
        $('#tombolBatal').fadeIn();
        $('#tombolSimpanItem').fadeOut();
        $('#tombolEditItem').fadeIn();
        $('#kodebarang').prop('readonly', true);
        $('#tombolCariBarang').prop('disable', true);
        ambilDataBarang();
    });

    $('#tombolBatal').click(function(e) {
        e.preventDefault();
        kosong();
        $('#tombolSimpanItem').fadeIn();
        $('#tombolEditItem').fadeOut();
        $('#tombolBatal').fadeOut();
        $('#kodebarang').removeAttr('readonly');
        $('#kodebarang').focus();
        $('#tombolCariBarang').removeAttr('disable');
        tampilDataDetail();
    });
</script>