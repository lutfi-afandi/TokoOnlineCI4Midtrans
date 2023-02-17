<?= $this->extend('main/layout'); ?>


<?= $this->section('judul'); ?>
Input Transaksi Pelanggan Keluar
<?= $this->endSection('judul'); ?>

<?= $this->section('subjudul'); ?>
<?= form_button('', '<i class="fa fa-backward"></i> kembali', [
    'class' => 'btn btn-warning',
    'onclick'   => "location.href=('" . site_url('barangkeluar/data') . "')",
]); ?>
<?= $this->endSection('subjudul'); ?>

<?= $this->section('isi'); ?>
<div class="form-row">
    <div class="form-group col-md-4">
        <label for="">No. Faktur</label>
        <input type="text" class="form-control" placeholder="No. Faktur" name="nofaktur" id="nofaktur" value="<?= $nofaktur; ?>" readonly>
    </div>
    <div class="form-group col-md-4">
        <label for="">Tanggal Faktur</label>
        <input type="date" class="form-control" value="<?= date('Y-m-d'); ?>" name="tglfaktur" id="tglfaktur">
    </div>
    <div class="form-group col-md-4">
        <label for="">Cari Pelanggan</label>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Nama Pelanggan" name="namapelanggan" id="namapelanggan" readonly>
            <input type="hidden" name="idpelanggan" id="idpelanggan">
            <div class="input-group-append">
                <button class="btn btn-outline-primary" type="button" id="tombolCariPelanggan">
                    <i class="fa fa-search"></i>
                </button>
                <button class="btn btn-outline-success" type="button" id="tombolTambahPelanggan">
                    <i class="fa fa-plus-circle"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-2">
        <div class="form-group">
            <label for="">Kode Barang</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Kode Barang" name="kodebarang" id="kodebarang">
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
                <button class="btn btn-info" type="button" id="tombolSelesaiTransaksi">
                    Selesai Transaksi
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 tampilDataTemp"></div>
</div>
<div class="viewmodal" style="display: hidden;"></div>

<script>
    function kosong() {
        $('#kodebarang').val('');
        $('#kodebarang').focus();
        $('#hargajual').val('');
        $('#namabarang').val('');
        $('#jml').val('');
    }

    function buatNoFak() {
        let tanggal = $('#tglfaktur').val();

        $.ajax({
            type: "post",
            url: "/barangkeluar/buatNoFaktur",
            data: {
                tanggal: tanggal
            },
            dataType: "json",
            success: function(response) {
                $('#nofaktur').val(response.nofaktur);
                tampilDataTemp();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });

    }


    function tampilDataTemp() {
        let faktur = $('#nofaktur').val();
        $.ajax({
            type: "post",
            url: "/barangkeluar/tampilDataTemp",
            data: {
                nofaktur: faktur
            },
            dataType: "json",
            beforeSend: function() {
                $('.tampilDataTemp').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            success: function(response) {
                if (response.data) {
                    $('.tampilDataTemp').html(response.data);

                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

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
                url: "/barangkeluar/simpanItem",
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
                        tampilDataTemp();
                        kosong();
                    }
                }
            });

        }
    }


    $(document).ready(function() {
        tampilDataTemp();

        $('#tglfaktur').change(function(e) {
            buatNoFak();
        });

        $('#tombolTambahPelanggan').click(function(e) {
            e.preventDefault();
            $.ajax({

                url: "/pelanggan/formtambah",
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modaltambahpelanggan').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        });

        $('#tombolCariPelanggan').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "/pelanggan/modalData",
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modaldatapelanggan').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        });

        $('#kodebarang').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                ambilDataBarang();
            }
        });

        $('#tombolSimpanItem').click(function(e) {
            e.preventDefault();
            simpanItem();
        });


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

        $('#tombolSelesaiTransaksi').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "/barangkeluar/modalPembayaran",
                data: {
                    nofaktur: $('#nofaktur').val(),
                    tglfaktur: $('#tglfaktur').val(),
                    idpelanggan: $('#idpelanggan').val(),
                    totalharga: $('#totalharga').val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        Swal.fire('Error', response.error, 'error')
                    }
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modalpembayaran').modal('show');
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