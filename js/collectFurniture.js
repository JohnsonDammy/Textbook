$(document).ready(function () {
    var localPrintSlipDownload = window.localStorage.getItem('printSlipDownload');
    if (localPrintSlipDownload == ref_number) {
        $('#btn_addphoto').attr('style', 'block');
        $('.confirm-count-input').removeAttr('readonly');
    }
});

//validatong form fields 
function formValidate() {
    var localPrintSlipDownload = window.localStorage.getItem('printSlipDownload');
    var imageErrorSpan = $('#imageErrorSpan');
    var inptImage = $('#upload_file').val();
    var flag = true;
    var values = $(".confirm-count-input")
        .map(function (index) {
            $(`tbody tr:eq(${index}) td:eq(4) #countErrSpan`).html('');
            var collCount = JSON.parse($(`tbody tr:eq(${index}) td:eq(3)`).html().trim());
            console.log(typeof (collCount));
            if (($(this).val() == '' || $(this).val() > collCount) && localPrintSlipDownload == ref_number &&
                inptImage != '') {
                if ($(this).val() > collCount) {
                    $(`tbody tr:eq(${index}) td:eq(4) #countErrSpan`).html("Confirm count is invalid")
                } else {
                    $(`tbody tr:eq(${index}) td:eq(4) #countErrSpan`).html("Confirm Count is required")
                }
                flag = false;
                return index;
            }
        }).get();
    imageErrorSpan.css("display", "none")
    $('#printSlipErrSpan').css("display", "none");
    $('#acceptErrSpan').css("display", "none")

    if (coll_status != 2) {
        $('#acceptErrSpan').css("display", "block")
        return false;
    }
    if (localPrintSlipDownload != ref_number) {
        $('#printSlipErrSpan').css("display", "block");
        return false;
    }
    if (inptImage == '' || !flag) {
        if (inptImage == '') {
            imageErrorSpan.css("display", "block")
        }
    } else {
        $('#formSubmitPopUp').click();
    }
}


var $form = $('#collectform');

function validateCollect() {
    // alert("Hii")
    // $form.parsley().validate()
    if ($form.parsley().validate()) {
        if (coll_status == 2) {
            window.localStorage.removeItem(ref_number);
            window.localStorage.removeItem("printSlipDownload");
            $('#submitcollectform').click()

        } else {
            console.log('Accept request')
        }

    } else {
        alert('invalid');
    }

}

var ref_number = $("#ref_number").val();

function payslip() {
    $.ajax({
        url: "/furniture-replacement/collect/printslip",
        type: "get",
        data: {
            ref_number: ref_number
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function (response) {
            var blob = new Blob([response]);
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = `${ref_number} - Pickup Slip.pdf`;
            $('.confirm-count-input').removeAttr('readonly');
            $('#btn_addphoto').css('display', 'block');
            link.click();
            window.localStorage.setItem('printSlipDownload', ref_number);
            $('#printSlipErrSpan').css('display', 'none');
        }
    });
}



//image preview

function preview_image() {
    $('#image_preview').html('');
    var total_file = document.getElementById("upload_file").files.length;
    for (var i = 0; i < total_file; i++) {
        $('#image_preview').append("<img width='250px' height='250px' class='mx-2 my-2' src='" + URL
            .createObjectURL(event.target
                .files[i]) + "'>");
    }
}

//remove images

function removeImg() {
    $('#image_preview').html('');
    $('#upload_file').val(null)

}

$('#saveDataBtn').on('click', function () {
    var values = $(".confirm-count-input")
        .map(function () {
            var name = $(this).data("id");
            var arr = {};
            arr[name] = $(this).val();
            return arr;
        }).get();
    // console.log(JSON.stringify(values));
    localStorage.setItem(ref_number, JSON.stringify(values));
    $('#saveSuccess').click();
})