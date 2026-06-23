$(document).ready(function() {
    table = $('#list_satuan').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": baseUrl + 'admin/satuan/data',
            "type": "POST",
            "error": function(error) {
                errorCode(error)
            }
        },
        "columnDefs": [
            { "sClass": "text-center", "targets": [0], "orderable": false },
            { "targets": [1, 2, 3], "orderable": true }
        ],
    });
});

$('#list_satuan').on('click', '#edit', function() {
    let id = $(this).data('id');
    $.ajax({
        url: baseUrl + 'admin/satuan/get/' + id,
        type: "GET",
        success: function(result) {
            let response = JSON.parse(result);
            $("#idData").val(response.id);
            $("#nama_satuan1").val(response.nama_satuan);
            $("#keterangan1").val(response.keterangan);
            $("#modalEdit").modal('show');
        },
        error: function(error) {
            errorCode(error);
        }
    });
});

$('#list_satuan').on('click', '#set', function() {
    let id = $(this).data('id');
    let action = $(this).data('action'); // mengambil nilai 'on' atau 'off'
    let pesan = (action === 'off') ? "Data akan dinon-aktifkan !" : "Data akan diaktifkan !";

    confirmSweet(pesan).then(result => {
        if (result) {
            $.ajax({
                url: baseUrl + 'admin/satuan/set/' + id + '/' + action,
                type: "GET",
                success: function(result) {
                    let response = JSON.parse(result);
                    if (response.status == 'ok') {
                        table.ajax.reload(null, false);
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

$('#list_satuan').on('click', '#delete', function() {
    let id = $(this).data('id');
    confirmSweet("Data akan terhapus secara permanen !").then(result => {
        if (result) {
            $.ajax({
                url: baseUrl + 'admin/satuan/delete/' + id,
                type: "GET",
                success: function(result) {
                    let response = JSON.parse(result);
                    if (response.status == 'ok') {
                        table.ajax.reload(null, false);
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

$("#formAddsatuan").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + "admin/satuan/insert",
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
                table.ajax.reload(null, false);
                msgSweetSuccess(response.msg);
                $("#modalTambah").modal('hide');
                $('#formAddsatuan')[0].reset();
            }
        },
        error: function(event) {
            errorCode(event);
        }
    });
});

$("#formEditsatuan").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + "admin/satuan/update",
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
                table.ajax.reload(null, false);
                msgSweetSuccess(response.msg);
                $("#modalEdit").modal('hide');
            }
        },
        error: function(event) {
            errorCode(event);
        }
    });
});