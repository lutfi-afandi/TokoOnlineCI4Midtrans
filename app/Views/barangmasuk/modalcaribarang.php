<!-- Modal -->
<div class="modal fade" id="modalbarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="cari" placeholder="silahkan cari data barang">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" id="btnCari"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <div class="row viewdetaildata"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function cariDataBarang() {
        let cari = $('#cari').val();
        $.ajax({
            type: "post",
            url: "/barangmasuk/detailCariBarang",
            data: {
                cari: cari
            },
            dataType: "json",
            beforeSend: function() {
                $('.viewdetaildata').html('<i clas="fa fa-spin fa-spinner"></i>');
            },
            success: function(response) {
                if (response.data) {
                    $('.viewdetaildata').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    $(document).ready(function() {
        $('#btnCari').click(function(e) {
            e.preventDefault();
            cariDataBarang();
        });
        $('#cari').keydown(function(e) {
            if (e.keyCode == '13') {
                e.preventDefault();
                cariDataBarang();

            }
        });
    });
</script>