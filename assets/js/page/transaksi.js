$(document).ready(function() {

    // Initialize select2 for statically generated rows
    if ($.fn.select2) {
        $('.select2_transaksi').select2({
            theme: 'bootstrap4'
        });
    }

    // Setup DataTable
    var table = $('#list_transaksi').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": baseUrl + 'admin/transaksi/data',
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [0, -1, -2],
                "orderable": false,
            },
        ],
    });

    // Handle Delete
    $(document).on('click', '#delete', function() {
        var id = $(this).data('id');
        swal({
            title: "Apakah anda yakin?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: baseUrl + 'admin/transaksi/delete/' + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status == 'ok') {
                            swal("Berhasil!", data.msg, "success");
                            table.ajax.reload();
                        } else {
                            swal("Gagal!", data.msg, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        swal("Error", "Gagal menghapus data", "error");
                    }
                });
            }
        });
    });

    // Form Add Transaksi
    $('#formAddTransaksi').on('submit', function(e) {
        e.preventDefault();
        
        // Cek minimal 1 barang
        var barangCount = $('select[name="id_barang[]"]').length;
        if (barangCount == 0) {
            swal("Peringatan", "Pilih minimal 1 barang", "warning");
            return false;
        }

        var btn = $('#btnSave');
        btn.html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...').attr('disabled', true);

        $.ajax({
            url: baseUrl + 'admin/transaksi/insert',
            type: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            success: function(data) {
                if (data.status == 'ok') {
                    swal("Berhasil!", data.msg, "success").then(() => {
                        window.location.href = baseUrl + 'admin/transaksi';
                    });
                } else {
                    swal("Gagal!", data.msg, "error");
                    btn.html('Simpan').attr('disabled', false);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal("Error", "Terjadi kesalahan sistem", "error");
                btn.html('Simpan').attr('disabled', false);
            }
        });
    });

    // Form Edit Transaksi
    $('#formEditTransaksi').on('submit', function(e) {
        e.preventDefault();
        
        // Cek minimal 1 barang
        var barangCount = $('select[name="id_barang[]"]').length;
        if (barangCount == 0) {
            swal("Peringatan", "Pilih minimal 1 barang", "warning");
            return false;
        }

        var btn = $('#btnSave');
        btn.html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...').attr('disabled', true);

        $.ajax({
            url: baseUrl + 'admin/transaksi/update',
            type: "POST",
            data: $(this).serialize(),
            dataType: "JSON",
            success: function(data) {
                if (data.status == 'ok') {
                    swal("Berhasil!", data.msg, "success").then(() => {
                        window.location.href = baseUrl + 'admin/transaksi';
                    });
                } else {
                    swal("Gagal!", data.msg, "error");
                    btn.html('Simpan Perubahan').attr('disabled', false);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal("Error", "Terjadi kesalahan sistem", "error");
                btn.html('Simpan Perubahan').attr('disabled', false);
            }
        });
    });

    // Add Row Barang
    $('#btnAddBarang').on('click', function() {
        var tr = `
            <tr>
                <td>
                    <select name="id_barang[]" class="form-control select2_new" required>
                        ${typeof opsiBarang !== 'undefined' ? opsiBarang : '<option value="">-- Pilih Barang --</option>'}
                    </select>
                </td>
                <td>
                    <input type="number" name="jumlah_barang[]" class="form-control" min="1" required>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger btnRemoveBarang"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `;
        $('#tbodyBarang').append(tr);
        // init select2
        if ($.fn.select2) {
            $('.select2_new').select2({
                theme: 'bootstrap4'
            }).removeClass('select2_new');
        }
    });

    // Remove Row Barang
    $(document).on('click', '.btnRemoveBarang', function() {
        $(this).closest('tr').remove();
    });

});
