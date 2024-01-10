$(function() {
    var table = $('#furnitureCountTable'),
        difference, repCount;
    var deliver_item_array = [];
    var ref_number = $("#ref_number").val();

    

    $('#readyflexCheckDefault').on('click', function() {
        if (delivery == 'pending') {
            $('#readyflexCheckDefault').prop("checked", true)
        }
        if ($("#readyflexCheckDefault").is(":checked")) {
            $('#download-delivery-note').css('display', 'block')
        } else {
            $('#download-delivery-note').css('display', 'none')
        }

    });

    $('#download-delivery-note').on('click', function() {
        $('#preloader').css('display', 'block');
        console.log('ready');
        $.ajax({
            url: "/furniture-replacement/collect/printannexured",
            type: "get",
            data: {
                ref_number: ref_number,
                items: deliver_item_array
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response) {
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = `${ref_number} - Delivery Note.pdf`;
                link.click();
                $('#preloader').css('display', 'none');
                window.localStorage.removeItem(ref_number)
                location.reload()
            },
            error: function(err) {
                $('#preloader').css('display', 'none');
            }
        });
    });

    $('#saveDataBtn').on('click', function() {
        if (delivery != 'pending') {
            var values = $(".deliver_count")
                .map(function() {
                    var name = $(this).data("id");
                    var arr = {};
                    arr[name] = $(this).val();
                    return arr;
                }).get();
            // console.log(JSON.stringify(values));
            localStorage.setItem(ref_number, JSON.stringify(values));
        }
        $('#saveSuccess').click();
    });

    $('#submitDataBtn').on('click', function() {
        if ($("#readyflexCheckDefault").is(":checked") && $("#deliverflexCheck").is(":checked") && $("#upload_file").val() != '' && deliver_item_array.length == table.find('tbody > tr').length) {
            $('#readyerror').text("");
            $('#checkerror').text("");
            $('#fileerror').text("");
            $('#validate_error').text("")
            $('#formSubmitPopUp').click()
        } else {
            console.log('error');
            $("#readyflexCheckDefault").is(":checked") ? $('#readyerror').text("") : $('#readyerror').text("Please Tick the checkbox");
            $("#deliverflexCheck").is(":checked") ? $('#checkerror').text("") : $('#checkerror').text("Please Tick the checkbox");
            $("#upload_file").val() != '' ? $('#fileerror').text("") : $('#fileerror').text("Signed delivery note is required");
            deliver_item_array.length == table.find('tbody > tr').length ? $('#validate_error').text("") : $('#validate_error').text("Deliverable count for all furniture items is required");
        }
    });

    $('#submitrepair').on('click', function() {
        $('#delivery_form').submit()
    });

    window.onload = function() {
        $('.delivererror').text("");
        table.find('tbody > tr').each(function() {
            var deliver_count = 0
            deliver_count = ($(this).find('.repair_count').text() * 1 + $(this).find('.accept_count').text() * 1)
            $(this).find('.deliver_count').val(deliver_count)
            var arr = {
                "id": $(this).find('.item_id').val(),
                "deliver_count": $(this).find('.deliver_count').val() * 1,
            };
            deliver_item_array.push(arr);
        });
        // console.log(deliver_item_array);
        $('.deliver_count').prop('readonly', true);
        $('#readydelivery').css('display', 'block')
        if (delivery == 'pending') {
            $('#readydelivery').css('display', 'block');
            $('#readyflexCheckDefault').prop("checked", true)
            $('#download-delivery-note').css('display', 'block')
            $('.deliver_count').prop('readonly', true);
        }
    }
});

function removeImg() {
    $('#image_preview').html('');
    $('#upload_file').val(null)

}