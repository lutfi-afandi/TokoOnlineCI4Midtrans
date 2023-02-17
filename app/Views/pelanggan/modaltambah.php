<!-- Modal -->
<div class="modal fade" id="modaltambahpelanggan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Input Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('pelanggan/simpan', ['class' => 'formsimpan']); ?>
                <div class="form-group">
                    <div class="label">Input Nama Pelanggan</div>
                    <input type="text" class="form-control" name="namapel" id="namapel">
                    <div class="invalid-feedback errorNamaPelanggan">
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">Telp/HP</div>
                    <input type="text" class="form-control" name="telp" id="telp">
                    <div class="invalid-feedback errorTelp">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-success btn-block" type="submit" id="tombolsimpan">Simpan</button>
                </div>
                <?= form_close(); ?>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.formsimpan').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                async: false,
                beforeSend: function() {
                    $('#tombolsimpan').prop('disable', true);
                    $('#tombolsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('#tombolsimpan').prop('disable', false);
                    $('#tombolsimpan').html('Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.errNamaPelanggan) {
                            $('#namapel').addClass('is-invalid');
                            $('.errorNamaPelanggan').html(err.errNamaPelanggan);
                        }
                        if (err.errTelp) {
                            $('#telp').addClass('is-invalid');
                            $('.errorTelp').html(err.errTelp);
                        }
                    }

                    if (response.sukses) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: response.sukses,
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, Ambil!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#namapelanggan').val(response.namapelanggan);
                                $('#idpelanggan').val(response.idpelanggan);
                                $('#modaltambahpelanggan').modal('hide');

                            } else {

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