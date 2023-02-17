<!-- Modal -->
<div class="modal fade" id="modalitem" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table sm-table bordered table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga Masuk</th>
                            <th>Harga Jual</th>
                            <th>Harga Jumlah</th>
                            <th>Sub. Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nomor = 1;
                        foreach ($tampildatadetail->getResultArray() as $row) { ?>
                            <tr>
                                <td><?= $nomor++; ?></td>
                                <td><?= $row['detbrgkode']; ?></td>
                                <td><?= $row['brgnama']; ?></td>
                                <td class="text-right"><?= number_format($row['dethargamasuk'], 0, ",", "."); ?></td>
                                <td class="text-right"><?= number_format($row['dethargajual'], 0, ",", "."); ?></td>
                                <td class="text-center"><?= number_format($row['detjumlah'], 0, ",", "."); ?></td>
                                <td class="text-right"><?= number_format($row['detsubtotal'], 0, ",", "."); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>