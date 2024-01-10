$(function () {
    var table = $('#furnitureCountTable'),
        difference, repCount, repdifference;
    var replenish_item_array = [];
    var approve_replenish_array = [];
    var ref_number = $("#ref_number").val();

    // get replenish count (replenish count = confirm count - repair count)
    $('.getdiff').on('change', function () {
        replenish_item_array = [];
        repCount = 0;
        table.find('tbody > tr').each(function () {
            if (($(this).find('.repair_count').val()) == '') {
                $(this).find('.repairerror').text("Repair count is required");
            } else if (($(this).find('.repair_count').val() * 1) > $(this).find(
                '.confirm_count').text() * 1) {
                $(this).find('.repairerror').text("Repair count is invalid");
            } else {
                $(this).find('.repairerror').text("");
            }

            difference = ($(this).find('.confirm_count').text() * 1) - ($(this).find(
                '.repair_count').val() * 1);
            if ($(this).find('.repair_count').val() == '') {
                $(this).find('.difference_count').val(0);
            } else {
                if ($(this).find('.confirm_count').text() * 1 == 0) {
                    if (difference < 0) {
                        $(this).find('.difference_count').val(0);
                    } else {
                        $(this).find('.difference_count').val(difference);
                        var arr = {
                            "id": $(this).find('.item_id').val(),
                            "category_name": $(this).find('.catname').text(),
                            "item_name": $(this).find('.itemname').text(),
                            "repair_count": $(this).find('.repair_count').val() * 1,
                            "replenish_count": difference
                        };
                        replenish_item_array.push(arr);
                    }
                } else if (difference == $(this).find('.confirm_count').text() * 1) {
                    if (difference < 0) {
                        $(this).find('.difference_count').val(0);
                    } else {
                        $(this).find('.difference_count').val(difference);
                        var arr = {
                            "id": $(this).find('.item_id').val(),
                            "category_name": $(this).find('.catname').text(),
                            "item_name": $(this).find('.itemname').text(),
                            "repair_count": $(this).find('.repair_count').val() * 1,
                            "replenish_count": difference
                        };
                        replenish_item_array.push(arr);
                    }
                } else if (difference < 0) {
                    $(this).find('.difference_count').val(0);
                } else {
                    $(this).find('.difference_count').val(difference);
                    var arr = {
                        "id": $(this).find('.item_id').val(),
                        "category_name": $(this).find('.catname').text(),
                        "item_name": $(this).find('.itemname').text(),
                        "repair_count": $(this).find('.repair_count').val() * 1,
                        "replenish_count": difference
                    };
                    replenish_item_array.push(arr);
                }
            }

            repCount += ($(this).find('.difference_count').val() * 1);
        });
        if (repCount > 0 && replenish_item_array.length == table.find('tbody > tr').length) {
            $('#validate_error').html("")
            $('#disposal_div').css('display', 'block')
        } else {
            $('#validate_error').html("")
            $('#disposal_div').css('display', 'none')
        }

    }).change();

    // get reject replenish count (reject replenish count = replenish count - approve replenish count)
    $('.getrepdiff').on('change', function () {
        approve_replenish_array = [];
        table.find('tbody > tr').each(function () {
            if ($(this).find('.difference_count').val() == 0) {
                $(this).find('.accept_count').val(0);
            } else {
                if (($(this).find('.accept_count').val()) == '') {
                    $(this).find('.approvereplenisherror').text("Approved replenishment count is required");
                } else if (($(this).find('.accept_count').val() * 1) > $(this).find(
                    '.difference_count').val() * 1) {
                    $(this).find('.approvereplenisherror').text("Approved replenishment count is invalid");
                } else {
                    $(this).find('.approvereplenisherror').text("");
                }
            }
            repdifference = ($(this).find('.difference_count').val() * 1) - ($(this).find(
                '.accept_count').val() * 1);
            if ($(this).find('.accept_count').val() == '') {
                $(this).find('.reject_count').val(0);
            } else {
                if ($(this).find('.difference_count').val() * 1 == 0) {
                    if (repdifference < 0) {
                        $(this).find('.reject_count').val(0);
                    } else {
                        $(this).find('.reject_count').val(repdifference);
                        var rep_arr = {
                            "id": $(this).find('.item_id').val(),
                            "accept_count": $(this).find('.accept_count').val() * 1,
                            "reject_count": repdifference
                        };
                        approve_replenish_array.push(rep_arr);
                    }
                } else if (repdifference == $(this).find('.difference_count').val() * 1) {
                    if (repdifference < 0) {
                        $(this).find('.reject_count').val(0);
                    } else {
                        $(this).find('.reject_count').val(repdifference);
                        var rep_arr = {
                            "id": $(this).find('.item_id').val(),
                            "accept_count": $(this).find('.accept_count').val() * 1,
                            "reject_count": repdifference
                        };
                        approve_replenish_array.push(rep_arr);
                    }
                } else if (repdifference < 0) {
                    $(this).find('.reject_count').val(0);
                } else {
                    $(this).find('.reject_count').val(repdifference);
                    var rep_arr = {
                        "id": $(this).find('.item_id').val(),
                        "accept_count": $(this).find('.accept_count').val() * 1,
                        "reject_count": repdifference
                    };
                    approve_replenish_array.push(rep_arr);
                }
            }
            $('#accept_replenish_count').val(JSON.stringify(approve_replenish_array))
        });
        if (approve_replenish_array.length == table.find('tbody > tr').length) {
            $('#validate_error').text("");
        }
    }).change();

    // print disposal note pdf
    $('#disposal_button').on('click', function () {
        $('#preloader').css('display', 'block');
        $.ajax({
            url: "/furniture-replacement/collect/printannexureb",
            type: "get",
            data: {
                ref_number: ref_number,
                items: replenish_item_array
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function (response) {
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = `${ref_number} - Disposal Certificate.pdf`;
                link.click();
                localStorage.setItem('Annexure-B', ref_number);
                $('#savebtn').click();
                $('#disposalerror').css('display', 'none')
                $('#Replenishmentform').css('display', 'block')
                $('#preloader').css('display', 'none');

            },
            error: function (err) {
                $('#preloader').css('display', 'none');
            }
        });
    })

    // print and email replenish request note
    $('#replenishbtn').on('click', function () {
        $('#preloader').css('display', 'block');
        $.ajax({
            url: "/furniture-replacement/collect/printemailannexurec",
            type: "get",
            data: {
                ref_number: ref_number,
                items: replenish_item_array
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function (response) {
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = `${ref_number} - Replenishment Request Form.pdf`;
                link.click();
                $('#preloader').css('display', 'none');
                window.localStorage.removeItem(ref_number)
                localStorage.setItem('Annexure-C', ref_number);
                location.reload()
            },
            error: function (err) {
                $('#preloader').css('display', 'none');
            }
        });

    })

    // save counts in local storage
    $('#saveDataBtn').on('click', function () {
        // save repair count
        if (local_ref_number != 'exists') {
            var values = $(".repair_count")
                .map(function () {
                    var name = $(this).data("id");
                    var arr = {};
                    arr[name] = $(this).val();
                    return arr;
                }).get();
            localStorage.setItem(ref_number, JSON.stringify(values));
        }
        // save accept replenish count after replenish request raised
        if (decision != null && local_ref_number == 'exists') {
            var values = $(".accept_count")
                .map(function () {
                    var name = $(this).data("id");
                    var arr = {};
                    arr[name] = $(this).val();
                    return arr;
                }).get();
            localStorage.setItem(ref_number, JSON.stringify(values));
        }
        $('#saveSuccess').click();
    });

    // submit button validations and conditions
    $('#submitDataBtn').on('click', function () {
        if (local_ref_number == 'exists') {
            if (decision == 'done') {
                if ($("#flexCheckDefault").is(":checked")) {
                    $('#completeerror').text("")
                    $('#formSubmitPopUp').click()
                } else {
                    $('#completeerror').text("Please tick the checkbox")
                }
            } else if (decision == 'pending') {
                approve_replenish_array.length == table.find('tbody > tr').length ? $(
                    '#validate_error').text("") : $('#validate_error').text(
                        "Approved replenishment count for all furniture items is required");
                $('#upload_file').val() == '' ? $('#imgerror').text("Replenishment proof is required") : $('#imgerror').text("");
                if (approve_replenish_array.length == table.find('tbody > tr').length && $('#upload_file').val() != '') {
                    $('#imgerror').text("Upload replenishment proof to continue");
                }
            } else {
                console.log('Error occured!')
            }
        } else {
            if ($("#flexCheckDefault").is(":checked") && replenish_item_array.length == table.find(
                'tbody > tr').length && repCount == 0) {
                $('#completeerror').text("")
                $('#validate_error').text("")
                $('#formSubmitPopUp').click()
            } else {
                $("#flexCheckDefault").is(":checked") ? $('#completeerror').text("") : $(
                    '#completeerror').text("Please tick the checkbox");
                replenish_item_array.length == table.find('tbody > tr').length ? $(
                    '#validate_error').text("") : $('#validate_error').text(
                        "Repairable count for all furniture items is required");
                if (window.localStorage.getItem('Annexure-B') == ref_number) {
                    $('#disposalerror').text("")
                    if (window.localStorage.getItem('Annexure-C') == ref_number) {
                        $('#replenisherror').text("")
                    } else {
                        $('#replenisherror').text("Email and Print Replenishment Request")
                    }
                } else {
                    $('#disposalerror').text("Print Disposal Certificate");
                }
            }
        }


    });

    // final submit repair process
    $('#submitrepair').on('click', function () {
        $('#closemodal').click()
        $('#preloader').css('display', 'block');
        $.ajax({
            url: "/furniture-replacement/collect/submitrepair",
            type: "post",
            data: {
                _token: __token, //accessing token from blade file
                status: decision,
                ref_number: ref_number,
                items: replenish_item_array
            },
            success: function (response) {
                window.localStorage.removeItem('Annexure-B')
                window.localStorage.removeItem('Annexure-C')
                window.localStorage.removeItem(ref_number)
                $('#preloader').css('display', 'none');
                $("#success-popup").click();
            },
            error: function (error) {
                $('#preloader').css('display', 'none');
                if (error.status == 422) {
                    $.map(error.responseJSON.errors, function (ele, key) {
                        $('#validate_error').text(ele);
                    });
                }
                console.log(error);
            }
        });

    });

    $('#success-pop-ok').on('click', function () {
        window.location.href = "/furniture-replacement"
    });

    window.onload = function () {
        $('.repairerror').text("");
        $('.approvereplenisherror').text("");
        if (local_ref_number == 'exists') {
            $('.repair_count').prop('readonly', true);
            $('#Replenishmentform').css('display', 'block')
        }
        if (decision == 'done') {
            $('.accept_count').prop('readonly', true);
        }
    }
});

function removeImg() {
    $('#image_preview').html('');
    $('#upload_file').val(null)

}

function uploadImg() {
    var image = $('#upload_file').val()
    var temparray = $('#accept_replenish_count').val()
    var tempcount = (JSON.parse(temparray)).length
    if (image != '' && tempcount == $('#furnitureCountTable').find('tbody > tr').length) {
        $('#imgerror').text("");
        $('#validate_error').text("")
        window.localStorage.removeItem(ref_number)
        $('#imageUpload').submit();

    } else {
        tempcount != $('#furnitureCountTable').find('tbody > tr').length ? $('#validate_error').text("Approved replenishment count for all furniture items is required") : $('#validate_error').text("");
        image == '' ? $('#imgerror').text("Replenishment proof is required") : $('#imgerror').text("");
    }
}