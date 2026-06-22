var table
var baseUrl = $('meta[name="baseUrl"]').attr('content')
var menuNa = $('meta[name="menu"]').attr('content')
var roles = $('meta[name="roles"]').attr('content')
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

// getNotif()
// if (menu == "notif") {
//   getNotif1()
// }



$('body').delegate('#logout', 'click', function (event) {
  var id = $(this).data('id');
  window.location = baseUrl + 'logout/' + id
});

var getUrlParameter = function getUrlParameter(sParam) {
  var sPageURL = window.location.search.substring(1),
    sURLVariables = sPageURL.split('&'),
    sParameterName,
    i;

  for (i = 0; i < sURLVariables.length; i++) {
    sParameterName = sURLVariables[i].split('=');

    if (sParameterName[0] === sParam) {
      return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
    }
  }
};

function disableButton() {
  $(':submit').append(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
  $(':submit').attr('disabled', true)
}

function enableButton() {
  $(':submit').find('span').remove()
  $(':submit').removeAttr("disabled")
}

function isInvalid(idNa) {
  $(idNa).removeClass("is-valid")
  $(idNa).addClass("is-invalid")
}

function isValid(idNa) {
  $(idNa).removeClass("is-invalid")
  $(idNa).addClass("is-valid")
}

function noValid(idNa) {
  $(idNa).removeClass("is-invalid is-valid")
}

function errorCode(event) {
  // iziToast.error({
  //   title: "Error",
  //   message: event.status + " " + event.statusText,
  //   position: 'topRight'
  // });
  console.log(event);
}

function toastInfo(msg, title = 'Info') {
  iziToast.info({
    title: title,
    message: msg.replace("'", ''),
    position: 'topRight'
  });
}

function toastSuccess(msg, title = 'Success') {
  iziToast.success({
    title: title,
    message: msg.replace("'", ''),
    position: 'topRight'
  });
}

function toastWarning(msg, title = 'Warning') {
  iziToast.warning({
    title: title,
    message: msg.replace("'", ''),
    position: 'topRight'
  });
}

function toastError(msg, title = 'Error') {
  iziToast.error({
    title: title,
    message: msg,
    position: 'topRight'
  });
}

function msgSweetError(pesan, title = 'Error', timer = 1500) {
  return swal({
    icon: 'error',
    title: title,
    text: pesan,
    timer: timer,
    timerProgressBar: true,
  })
}

function msgSweetSuccess(pesan, title = 'Sukses', timer = 1500) {
  return swal({
    icon: 'success',
    title: title,
    text: pesan,
    timer: timer,
    timerProgressBar: true,
  })
}

function msgSweetWarning(pesan, title = 'Peringatan', timer = 1500) {
  return swal({
    icon: 'warning',
    title: title,
    text: pesan,
    timer: timer,
    timerProgressBar: true,
  })
}

function msgSweetInfo(pesan, title = 'Info', timer = 1500) {
  return swal({
    icon: 'info',
    title: title,
    text: pesan,
    timer: timer,
    timerProgressBar: true,
  })
}

function confirmSweet(pesan, title = 'Konfirmasi') {
  return swal({
    icon: 'warning',
    title: title,
    text: pesan,

    buttons: ["Tidak", "Ya"],
    dangerMode: true,
  })
}

function post_data(url, data_, table = null) {
  $.ajax({
    url: baseUrl + url,
    type: "post",
    data: data_,
    processData: false,
    contentType: false,
    cache: false,
    beforeSend: function () {
      $(':submit').append(' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
      $(':submit').attr('disabled', true)
    },
    complete: function () {
      $(':submit').find('span').remove()
      $(':submit').removeAttr("disabled")
    },
    success: function (result) {

      console.log(result)

    },
    error: function () {
      toastr.error('Error')
    }
  });
}

function input_validate(inp) {
  var u = "",
    b = "";
  // console.log(inp);
  for (let index = inp.length; index > 0; index--) {
    if (inp[index - 1].required == true && inp[index - 1].value.trim() == "") {
      b += "b";
      inp[index - 1].select();
    } else {
      b += "u";
    }
    u += "u";
  }
  if (u == b) {
    return true;
  } else {
    toastr.error("Isi semua field !");
    return false;
  }
}

function clearInput(inp) {
  for (let index = 0; index < inp.length; index++) {
    inp[index].value = "";
  }
}


$(document).ready(function () {
  $("#menu-" + menuNa).addClass('bg-primary')
})

$(document).delegate('#btnLogout', 'click', function () {
  confirmSweet("", 'Yakin ingin Keluar ?').then((result) => {
    if (result) {
      $(location).attr('href', baseUrl + 'admin/login/keluar/' + token)
    }
  })
})

function cekPilihanNa() {
  let dipilih = $("#dipilih").val()
  let pilihanNa = dipilih.split(",")
  let dipilihNa = $("input[id^='pilihGan-']");
  let jumlahInput = dipilihNa.length
  pilihanNa.forEach(id => {
    if (id != '') {
      if (!$(`#pilihGan-${id}`).is(":checked")) {
        $(`#pilihGan-${id}`).prop('checked', true);
      }
    }
  });
  let jmlCek = 0;
  Object.values(dipilihNa).forEach(cekNa => {
    if ($(cekNa).is(":checked")) {
      jmlCek++
    }
  })
  if (jmlCek == jumlahInput) {
    $("#checkAll").prop('checked', true)
  } else {
    $("#checkAll").prop('checked', false)
  }
  if (dipilih != '') {
    $("#denganData").html(`Dengan ${pilihanNa.length - 1} data terpilih`)
  } else {
    $("#denganData").html(`Dengan data terpilih`)
  }
}

$(document).delegate("#checkAll", 'click', function () {
  if ($(this).is(":checked")) {
    let pilihan = $("input[id^='pilihGan-']"),
      dipilih = $("#dipilih"),
      pilih = ''
    if (dipilih.val() != '') {
      pilih = dipilih.val()
    } else {
      pilih = ''
    }
    Object.values(pilihan).forEach(input => {
      if (!pilih.includes($(input).val())) {
        pilih += `${$(input).val()},`
        dipilih.val(pilih);
        cekPilihanNa()
      }
    })
  } else {
    let dipilihna = $("#dipilih").val()
    let dipilihNa = $("input[id^='pilihGan-']");
    Object.values(dipilihNa).forEach(cekNa => {
      $(cekNa).prop('checked', false)
      dipilihna = dipilihna.replace(new RegExp(`${$(cekNa).val()},`, "g"), "")
      $("#dipilih").val(dipilihna)
      cekPilihanNa()
    })
  }
})

$(document).delegate("input[id^='pilihGan-']", 'click', function () {
  let id = `${$(this).val()},`
  let dipilihna = $("#dipilih").val()
  if ($(this).is(":checked")) {
    $("#dipilih").val(dipilihna + id)
  } else {
    $("#dipilih").val(dipilihna.replace(new RegExp(id, "g"), ""))
  }
  cekPilihanNa()
})

function getBulanRomawi(bul = '') {
  let bulan
  if (bul != '') {
    bulan = bul
  } else {
    bulan = new Date().getMonth()
  }

  bulan = parseInt(bulan) + parseInt(1)

  switch (bulan) {
    case 1:
      bulan = "I";
      break;
    case 2:
      bulan = "II";
      break;
    case 3:
      bulan = "III";
      break;
    case 4:
      bulan = "IV";
      break;
    case 5:
      bulan = "V";
      break;
    case 6:
      bulan = "VI";
      break;
    case 7:
      bulan = "VII";
      break;
    case 8:
      bulan = "VIII";
      break;
    case 9:
      bulan = "IX";
      break;
    case 10:
      bulan = "X";
      break;
    case 11:
      bulan = "XI";
      break;
    case 12:
      bulan = "XII";
      break;
  }
  return bulan
}
// $(`select`).select2({
//     theme: 'bootstrap4'
// })

$("#btnNotif").on('click', function () {
  $(location).attr('href', `${baseUrl}notifikasi`)
})


// kalo versi mobile
window.mobileCheck = function () {
  let check = false;
  (function (a) {
    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
  })(navigator.userAgent || navigator.vendor || window.opera);
  return check;
};


var saclar = true;
$('#hide-show-menu').click(function (evt) {
  if (saclar == true) {
    $('.left-side-bar').css('width', '250px');
    $('.brand-logo').css('width', '250px');
    $('.main-container').css('padding-left', '271px')
    if ($('#previewcontainer').length > 0)
      $('#previewcontainer').removeClass('position-fixed')
    saclar = false;
  } else {
    $('.left-side-bar').css('width', '0px');
    // $('.brand-logo').css('width','0px');
    $('.main-container').css('padding-left', '30px')
    if ($('#previewcontainer').length > 0)
      $('#previewcontainer').addClass('position-fixed')

    saclar = true;
  }
})

if (window.mobileCheck() == true) {
  $('.brand-logo').css('width', '250px');
  $('.left-side-bar').css('width', '250px');
}



function validateForm() {
		var fileInputs = document.querySelectorAll('input[type="file"]');
		for (var i = 0; i < fileInputs.length; i++) {
			if (fileInputs[i].files.length > 0) {
				var fileSize = fileInputs[i].files[0].size;
				if (fileSize > 5 * 1024 * 1024) {
					alert('Ukuran file terlalu besar. Maksimal 5 MB.');
					return false;
				}
			}
		}
		return true;
	}