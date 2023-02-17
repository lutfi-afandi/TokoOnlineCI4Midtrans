<?= $this->extend('main/layout'); ?>


<?= $this->section('judul'); ?>
Edit Transaksi Barang Keluar
<?= $this->endSection('judul'); ?>

<?= $this->section('subjudul'); ?>
<?= form_button('', '<i class="fa fa-backward"></i> Kembali', [
    'class' => 'btn btn-warning',
    'onclick'   => "location.href=('" . site_url('barangkeluar/data') . "')",
]); ?>
<?= $this->endSection('subjudul'); ?>

<?= $this->section('isi'); ?>

<style>
    table#datadetail tbody tr:hover {
        cursor: pointer;
        background-color: red;
        color: white;
    }
</style>

<table class="table table-sm table-striped">
    <tr>
        <input type="hidden" id="nofaktur" value="<?= $nofaktur; ?>">
        <td style="width: 20%;">No. Faktur</td>
        <td style="width: 2%;">:</td>
        <td style="width: 28%;"><?= $nofaktur; ?></td>
        <td rowspan="3" style="width: 50%; font-weight: bold; color: red; font-size: 20pt; text-align: center; vertical-align: middle;" id="lbTotalHarga">sss</td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td>:</td>
        <td><?= $tanggal; ?></td>
    </tr>
    <tr>
        <td>Nama Pelanggan</td>
        <td>:</td>
        <td><?= $namapelanggan; ?></td>
    </tr>
</table>
<div class="row mt-4">
    <div class="col-lg-2">
        <div class="form-group">
            <label for="">Kode Barang</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Kode Barang" name="kodebarang" id="kodebarang">
                <input type="hidden" id="iddetail">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button" id="tombolCariBarang">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Nama Barang</label>
            <input type="text" class="form-control" name="namabarang" id="namabarang" readonly>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">Harga Jual (Rp)</label>
            <input type="text" class="form-control" name="hargajual" id="hargajual" readonly>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="">Qty</label>
            <input type="number" class="form-control" name="jml" id="jml">
        </div>
    </div>
    <div class="col-lg-2">
        <div class="form-group">
            <label for="">#</label>
            <div class="inputgroup mb-3">
                <button class="btn btn-success" type="button" id="tombolSimpanItem">
                    <i class="fa fa-save"></i>
                </button> &nbsp;
                <button class="btn btn-primary " style="display: none;" type="button" id="tombolEditItem">
                    <i class="fa fa-edit"></i>
                </button>
                <button class="btn btn-default " style="display: none;" type="button" id="tombolBatal">
                    <i class="fa fa-sync-alt"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 tampilDataDetail"></div>
</div>
<div class="viewmodal" style="display: hidden;"></div>

<script>
    function ambilDataBarang() {
        let kodebarang = $('#kodebarang').val();
        if (kodebarang.length == 0) {
            Swal.fire('Gagal!', 'Kode barang harus diinputkan', 'error');
            kosong();
        } else {
            $.ajax({
                type: "post",
                url: "/barangkeluar/ambilDataBarang",
                data: {
                    kodebarang: kodebarang
                },
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        Swal.fire('Gagal!', 'Kode barang tidak ditemukan', 'error');
                        kosong();
                    }

                    if (response.sukses) {
                        let data = response.sukses;

                        $('#namabarang').val(data.namabarang);
                        $('#hargajual').val(data.hargajual);
                        $('#jml').focus();

                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }

    }

    function ambilTotalHarga() {
        let nofaktur = $('#nofaktur').val();
        $.ajax({
            type: "post",
            url: "/barangkeluar/ambilTotalHarga",
            data: {
                nofaktur: nofaktur
            },
            dataType: "json",
            success: function(response) {
                $('#lbTotalHarga').html(response.totalharga);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    function kosong() {
        $('#kodebarang').val('');
        $('#kodebarang').focus();
        $('#hargajual').val('');
        $('#namabarang').val('');
        $('#iddetail').val('');
        $('#jml').val('');
    }

    function tampilDataDetail() {
        let faktur = $('#nofaktur').val();
        $.ajax({
            type: "post",
            url: "/barangkeluar/tampilDataDetail",
            data: {
                nofaktur: faktur
            },
            dataType: "json",
            beforeSend: function() {
                $('.tampilDataDetail').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            success: function(response) {
                if (response.data) {
                    $('.tampilDataDetail').html(response.data);

                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }



    function simpanItem() {
        let nofaktur = $('#nofaktur').val();
        let kodebarang = $('#kodebarang').val();
        let namabarang = $('#namabarang').val();
        let hargajual = $('#hargajual').val();
        let jml = $('#jml').val();

        if (kodebarang.length == 0) {
            Swal.fire('Gagal!', 'Kode barang harus diinputkan', 'error');
            kosong();
        } else {
            $.ajax({
                type: "post",
                url: "/barangkeluar/simpanItemDetail",
                data: {
                    kodebarang: kodebarang,
                    nofaktur: nofaktur,
                    namabarang: namabarang,
                    hargajual: hargajual,
                    jml: jml
                },
                dataType: "json",
                success: function(response) {

                    if (response.error) {
                        Swal.fire('Gagal!', response.error, 'error');
                        kosong();
                    }
                    if (response.sukses) {
                        Swal.fire('Berhasil!', response.sukses, 'success');
                        tampilDataDetail();
                        ambilTotalHarga();
                        kosong();
                        $('#tombolSimpanItem').fadeIn();
                        $('#tombolEditItem').fadeOut();
                        $('#tombolBatal').fadeOut();
                        $('#kodebarang').removeAttr('readonly');
                        $('#kodebarang').focus();
                        $('#tombolCariBarang').removeAttr('disable');
                    }
                }
            });

        }
    }


    $(document).ready(function() {
        tampilDataDetail();
        ambilTotalHarga();

        $('#tombolCariBarang').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "/barangkeluar/modalCariBarang",
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modalcaribarang').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        });

        $('#tombolSimpanItem').click(function(e) {
            e.preventDefault();
            simpanItem();
        });

        $('#tombolEditItem').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "/barangkeluar/editItem",
                data: {
                    iddetail: $('#iddetail').val(),
                    jml: $('#jml').val(),
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {

                        Swal.fire({
                            'icon': 'success',
                            'title': 'Berhasil',
                            'text': response.sukses
                        });
                        tampilDataDetail();
                        ambilTotalHarga();
                        kosong();
                        $('#tombolSimpanItem').fadeIn();
                        $('#tombolEditItem').fadeOut();
                        $('#tombolBatal').fadeOut();
                        $('#kodebarang').removeAttr('readonly');
                        $('#kodebarang').focus();
                        $('#tombolCariBarang').removeAttr('disable');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        });
    });
</script>
<?= $this->endSection('isi'); ?>