<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">


<script src="<?= base_url(); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- Modal -->
<div class="modal fade" id="modalcaribarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <div class="input-group mb-3">
                    <input type="text" class="form-control" id="cari" placeholder="silahkan cari data barang">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" id="btnCari"><i class="fa fa-search"></i></button>
                    </div>
                </div> -->
                <table id="databarang" class="table table-bordered table-hover dataTable dtr-inline collapsed" aria-describedby="example2_info">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($barang as $row) { ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row['brgkode']; ?></td>
                                <td><?= $row['brgnama']; ?></td>
                                <td><?= number_format($row['brgharga'], 0, ",", "."); ?></td>
                                <td><?= number_format($row['brgstok'], 0, ",", "."); ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" onclick="pilih('<?= $row['brgkode'] ?>')">pilih</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function pilih(kode) {
        $('#kodebarang').val(kode);
        $('#modalcaribarang').on('hidden.bs.modal', function(event) {
            ambilDataBarang();
        })
        $('#modalcaribarang').modal('hide');
    }
    $(document).ready(function() {
        $('#databarang').DataTable();
    });
</script>