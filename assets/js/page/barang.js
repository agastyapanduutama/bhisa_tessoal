
$(document).ready(function() {
    table = $('#list_barang').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": baseUrl + 'admin/barang/data',
            "type": "POST",
            "error": function(error) {
                errorCode(error);
            },
        },
        "columnDefs": [
            { "sClass": "text-center", "targets": [0], "orderable": false },
            { "targets": [1, 2, 3], "orderable": true }
        ],
    });

    // Event Klik Tombol Filter
    $("#filter").click(function() {
        _reload();
    });
});

function _reload() {
    if (table) {
        table.ajax.reload(null, false); // null, false menjaga halaman pagination tetap di tempat semula
    }
}
$('#list_barang').on('click', '#edit', function() {
    let id = $(this).data('id');
    $.ajax({
        url: baseUrl + 'admin/barang/get/' + id,
        type: "GET",
        success: function(result) {
            let response = JSON.parse(result);
            $("#idData").val(response.id);
            $("#nama_barang1").val(response.nama_barang);
            $("#harga_barang1").val(response.harga_barang);
            
            $("#id_satuan1").val(response.id_satuan).trigger('change');
            
            $("#keterangan1").val(response.keterangan);
            $("#modalEdit").modal('show');
        },
        error: function(error) {
            errorCode(error);
        }
    });
});

$('#list_barang').on('click', '.btn-toggle-status, #set', function() {
    let id = $(this).data('id');
    let action = $(this).data('action'); // Pastikan di PHP ada attribute: data-action="on" atau data-action="off"
    
    let pesan = (action === 'off') ? "Data akan dinon-aktifkan !" : "Data akan diaktifkan !";
    let endpointUrl = baseUrl + 'admin/barang/set/' + id + '/' + action;

    confirmSweet(pesan).then(result => {
        if (result) {
            $.ajax({
                url: endpointUrl,
                type: "GET",
                success: function(result) {
                    let response = JSON.parse(result);
                    if (response.status == 'ok') {
                        _reload();
                        msgSweetSuccess(response.msg);
                    } else {
                        msgSweetWarning(response.msg);
                    }
                },
                error: function(error) {
                    errorCode(error);
                }
            });
        }
    });
});

$('#list_barang').on('click', '#delete', function() {
    let id = $(this).data('id');
    confirmSweet("Data akan terhapus secara permanen !").then(result => {
        if (result) {
            $.ajax({
                url: baseUrl + 'admin/barang/delete/' + id,
                type: "GET",
                success: function(result) {
                    let response = JSON.parse(result);
                    if (response.status == 'ok') {
                        _reload();
                        msgSweetSuccess(response.msg);
                    } else {
                        msgSweetWarning(response.msg);
                    }
                },
                error: function(error) {
                    errorCode(error);
                }
            });
        }
    });
});

$("#formAddbarang").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + "admin/barang/insert",
        type: "post",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        success: function(result) {
            let response = JSON.parse(result);
            if (response.status == "fail") {
                msgSweetError(response.msg);
            } else {
                _reload();
                msgSweetSuccess(response.msg);
                clearInput($("input"));
                $("#modalTambah").modal('hide'); // Menutup modal tambah jika ada
            }
        },
        error: function(event) {
            errorCode(event);
        }
    });
});

$("#formEditbarang").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + "admin/barang/update",
        type: "post",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        success: function(result) {
            let response = JSON.parse(result);
            if (response.status == "fail") {
                clearInput($("input"));
                $("#modalEdit").modal('hide');
            } else {
                _reload();
                msgSweetSuccess(response.msg);
                clearInput($("input"));
                $("#modalEdit").modal('hide');
            }
        },
        error: function(event) {
            errorCode(event);
        }
    });
});

function image(image) {
    let file = baseUrl + 'assets/uploads/images/' + image;
    var imageElement = document.getElementById('image_id');
    if(imageElement) {
        imageElement.src = file;
    }
}