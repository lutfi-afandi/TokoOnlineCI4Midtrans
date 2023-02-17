<?= $this->extend('main/layout'); ?>


<?= $this->section('judul'); ?>
Data Transaksi Barang Keluar
<?= $this->endSection('judul'); ?>

<?= $this->section('subjudul'); ?>
<?= form_button('', '<i class="fa fa-plus-circle"></i> Input Transaksi', [
    'class' => 'btn btn-primary',
    'onclick'   => "location.href=('" . site_url('barangkeluar/input') . "')",
]); ?>
<?= $this->endSection('subjudul'); ?>

<?= $this->section('isi'); ?>

<div class="row">
    <div class="col">
        <label for="">Filter Data</label>
    </div>
    <div class="col">
        <input type="date" name="tglawal" id="tglawal" class="form-control">
    </div>
    <div class="col">
        <input type="date" name="tglakhir" id="tglakhir" class="form-control">
    </div>
    <div class="col">
        <button type="button" class="btn btn-block btn-primary" id="tombolTampil">
            Tampilkan
        </button>
    </div>
</div>

<div class="viewtabelbarangkeluar mt-2"></div>

<script>
    function tampilBarangkeluar() {
        $.ajax({
            // type: "post",
            url: "tabelBarangkeluar",
            // data: {
            //     tglawal: tglawal,
            //     tglakhir: tglakhir,
            // },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewtabelbarangkeluar').html(response.data);
                }
            }
        });
    }
    $('#tombolTampil').click(function(e) {
        e.preventDefault();
        let tglawal = $('#tglawal').val();
        let tglakhir = $('#tglakhir').val();
        $.ajax({
            type: "post",
            url: "tabelBarangkeluar",
            data: {
                tglawal: tglawal,
                tglakhir: tglakhir,
            },
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewtabelbarangkeluar').html(response.data);
                }
            }
        });
    });

    function cetak(faktur) {
        //printer tenal
        // direct print menggunakan isc post 
        let windowCetak = window.open('/barangkeluar/cetakfaktur/' + faktur, "Cetak faktur Barang Keluar", "width=400,height=800");
        windowCetak.focus();
    }

    $(document).ready(function() {
        tampilBarangkeluar();
        // $('#databarangkeluar').DataTable();
    });

    function hapus(faktur) {
        // console.log(faktur)
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
                    url: "/barangkeluar/hapusTransaksi",
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

    function edit(faktur) {
        window.location.href = ('/barangkeluar/edit/') + faktur;
    }
</script>
<?= $this->endSection('isi'); ?>