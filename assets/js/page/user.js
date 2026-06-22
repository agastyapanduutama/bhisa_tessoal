$(document).ready(function() {
    table = $('#list_user').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": baseUrl + 'admin/user/data',
            "type": "POST",
            "complete": function() {},
            "error": function(error) {
                errorCode(error)
            },
            "data": function(data) {
                data.id_unit = $('#id_unit_filter').val()
            }
        },

        "columnDefs": [{
                "sClass": "text-center",
                "targets": [0],
                "orderable": false
            },
            {
                "targets": [1],
                "orderable": true
            },
            {
                "targets": [2],
                "orderable": true
            },
            {
                "targets": [3],
                "orderable": true
            },
        ],

        

    });

    $("#filter").click(function() {
        _reload();
        // alert("Helloworld");
    });

})

function _reload() {
    table.ajax.reload();

}

$('#list_user').on('click', '#edit', function() {
    let id = $(this).data('id');
    $.ajax({
        url: baseUrl + 'admin/user/get/' + id,
        type: "GET",
        success: function(result) {
            response = JSON.parse(result)
            $("#idData").val(response.id)
            $("#nama_user1").val(response.nama_user)
            $("#username1").val(response.username)
            $("#level1").val(response.level).change()
            $("#id_unit1").val(response.id_unit).change()
            $("#keterangan1").val(response.keterangan)
            $("#modalEdit").modal('show')

        },
        error: function(error) {
            errorCode(error)
        }
    })
})

function image(image) {
    file = baseUrl + 'assets/uploads/images/' + image;
    var image = document.getElementById('image_id');
    image.src = file;
}

$('#list_user').on('click', '#delete', function() {
    let id = $(this).data('id');
    confirmSweet("Data akan terhapus secara permanen !")
        .then(result => {
            if (result) {
                $.ajax({
                    url: baseUrl + 'admin/user/delete/' + id,
                    type: "GET",
                    success: function(result) {
                        response = JSON.parse(result)
                        if (response.status == 'ok') {
                            table.ajax.reload(null, false)
                            msgSweetSuccess(response.msg)
                                // msgSweetSuccess(response.msg)
                        } else {
                            msgSweetWarning(response.msg)
                                // msgSweetError(response.msg)
                        }
                    },
                    error: function(error) {
                        errorCode(error)
                    }
                })
            }
        })
})

$("#formAdduser").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + "admin/user/insert",
        type: "post",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function() {
            // disableButton()
        },
        complete: function() {
            enableButton()
        },
        success: function(result) {
            let response = JSON.parse(result)
            if (response.status == "fail") {
                msgSweetError(response.msg)
            } else {
                table.ajax.reload(null, false)
                msgSweetSuccess(response.msg)
                clearInput($("input"))
            }
        },
        error: function(event) {
            errorCode(event)
        }
    });
})

$("#formEdituser").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: baseUrl + "admin/user/update",
        type: "post",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function() {
            // disableButton()
        },
        complete: function() {
            enableButton()
        },
        success: function(result) {
            let response = JSON.parse(result)
            if (response.status == "fail") {
                // msgSweetError(response.msg)
                clearInput($("input"))
                $("#modalEdit").modal('hide')
            } else {
                table.ajax.reload(null, false)
                msgSweetSuccess(response.msg)
                clearInput($("input"))
                $("#modalEdit").modal('hide')

            }
        },
        error: function(event) {
            errorCode(event)
        }
    });
})


$('#list_user').on('click', '#on', function() {
    let id = $(this).data('id');
    confirmSweet("Data akan dinon-aktifkan  !")
        .then(result => {
            if (result) {
                $.ajax({
                    url: baseUrl + 'admin/user/set/' + id + "/off",
                    type: "GET",
                    success: function(result) {
                        response = JSON.parse(result)
                        if (response.status == 'ok') {
                            table.ajax.reload(null, false)
                            msgSweetSuccess(response.msg)
                                // toastSuccess(response.msg)
                        } else {
                            msgSweetWarning(response.msg)
                                // toastWarning(response.msg)
                        }
                    },
                    error: function(error) {
                        errorCode(error)
                    }
                })
            }
        })
})

$('#list_user').on('click', '#off', function() {
    let id = $(this).data('id');
    confirmSweet("Data akan diaktifkan  !")
        .then(result => {
            if (result) {
                $.ajax({
                    url: baseUrl + 'admin/user/set/' + id + "/on",
                    type: "GET",
                    success: function(result) {
                        response = JSON.parse(result)
                        if (response.status == 'ok') {
                            table.ajax.reload(null, false)
                            msgSweetSuccess(response.msg)
                                // toastSuccess(response.msg)
                        } else {
                            msgSweetWarning(response.msg)
                                // toastWarning(response.msg)
                        }
                    },
                    error: function(error) {
                        errorCode(error)
                    }
                })
            }
        })
})
