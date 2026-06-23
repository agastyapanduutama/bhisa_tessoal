$(document).ready(function() {
    table = $('#list_jabatan').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": baseUrl + 'admin/jabatan/data',
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

$('#list_jabatan').on('click', '#edit', function() {
    let id = $(this).data('id');
    $.ajax({
        url: baseUrl + 'admin/jabatan/get/' + id,
        type: "GET",
        success: function(result) {
            let response = JSON.parse(result);
            $("#idData").val(response.id);
            $("#nama_jabatan1").val(response.nama_jabatan);
            $("#keterangan1").val(response.keterangan);
            
            // PERBAIKAN: Set nilai dropdown Apakah Admin di modal edit
            $("#is_admin1").val(response.is_admin).trigger('change');
            
            $("#modalEdit").modal('show');
        },
        error: function(error) {
            errorCode(error);
        }
    });
});

$('#list_jabatan').on('click', '#set', function() {
    let id = $(this).data('id');
    let action = $(this).data('action'); // mengambil nilai 'on' atau 'off'
    let pesan = (action === 'off') ? "Data akan dinon-aktifkan !" : "Data akan diaktifkan !";

    confirmSweet(pesan).then(result => {
        if (result) {
            $.ajax({
                url: baseUrl + 'admin/jabatan/set/' + id + '/' + action,
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

$('#list_jabatan').on('click', '#delete', function() {
    let id = $(this).data('id');
    confirmSweet("Data akan terhapus secara permanen !").then(result => {
        if (result) {
            $.ajax({
                url: baseUrl + 'admin/jabatan/delete/' + id,
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

$("#formAddjabatan").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + "admin/jabatan/insert",
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
                $('#formAddjabatan')[0].reset();
            }
        },
        error: function(event) {
            errorCode(event);
        }
    });
});

$("#formEditjabatan").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + "admin/jabatan/update",
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