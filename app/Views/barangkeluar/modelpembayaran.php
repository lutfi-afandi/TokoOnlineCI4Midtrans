<!-- Modal -->
<div class="modal fade" id="modalpembayaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembayaran Faktur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('barangkeluar/simpanPembayaran', ['class' => 'frmpembayaran']); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">No. Faktur</label>
                    <input type="text" name="nofaktur" id="nofaktur" class="form-control" value="<?= $nofaktur; ?>" readonly>
                    <input type="hidden" name="tglfaktur" class="form-control" value="<?= $tglfaktur; ?>">
                    <input type="hidden" name="idpelanggan" class="form-control" value="<?= $idpelanggan; ?>">
                </div>
                <div class="form-group">
                    <label for="">Total Harga</label>
                    <input type="text" name="totalbayar" id="totalbayar" class="form-control" value="<?= $totalharga; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="">Jumlah Uang</label>
                    <input type="text" name="jumlahuang" id="jumlahuang" class="form-control" autocomplete="false">
                </div>
                <div class="form-group">
                    <label for="">Sisa Uang</label>
                    <input type="text" name="sisauang" id="sisauang" class="form-control" autocomplete="false" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btnSimpan">Simpan</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script src="<?= base_url('dist/js/autoNumeric.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('#totalbayar').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            mDec: 0
        })
        $('#jumlahuang').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            mDec: 0
        })
        $('#sisauang').autoNumeric('init', {
            aSep: '.',
            aDec: ',',
            mDec: 0
        })

        $('#jumlahuang').keyup(function(e) {
            let totalbayar = $('#totalbayar').autoNumeric('get');
            let jumlahuang = $('#jumlahuang').autoNumeric('get');
            let sisauang;

            // console.log(totalbayar)
            // console.log(jumlahuang)

            if (parseInt(jumlahuang) < parseInt(totalbayar)) {
                sisauang = 0;
            } else {
                sisauang = parseInt(jumlahuang) - parseInt(totalbayar);
            }

            $('#sisauang').autoNumeric('set', sisauang);

        });

        $('.frmpembayaran').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                async: false,
                beforeSend: function() {
                    $('.btnSimpan').prop('disable', true);
                    $('.btnSimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnSimpan').prop('disable', false);
                    $('.btnSimpan').html('Simpan');
                },
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            title: 'Cetak Faktur?',
                            text: response.sukses + ", cetakfaktur?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, Cetak!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let windowCetak = window.open(response.cetakfaktur, "Cetak faktur Barang Keluar", "width=200,height=400");
                                windowCetak.focus();
                                window.location.reload();
                            } else {
                                window.location.reload();

                            }
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });

            return false;
        });
    });
</script>