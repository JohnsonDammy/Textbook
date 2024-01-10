$(document).ready(function () {
    //appending items from localstorage
    brokenItemAppend();
    $('#total_furniture').val(totalcount)
});

function getItems() {
    var catid = $(".furniture-category option:selected").val() == '' ? $(
        ".furniture-category-update option:selected").val() : $(".furniture-category option:selected").val();
    var itemId = $("#item-update").val() ? $("#item-update").val() : '';
    $.ajax({
        url: "/getstockitems",
        type: "get",
        data: {
            catid: catid
        },
        dataType: "json",

        success: function (response) {
            let itemdata = response;
            if (itemdata.length > 0) {
                $(".furniture-items").html("")
                var itemHtml = "<option selected disabled value=''>Item Description</option>"
                $.each(itemdata, function (index, value) {
                    itemHtml +=
                        `<option value ="${value.id}" ${value.id == itemId ? selected = "selected" : ''}>${value.name}</option>`
                });
                $(".furniture-items").html(itemHtml)
            }
        },
        error: function () {
            //alert('Error while request..');
            console.log("Error while request..");
        },
    });
}

function brokenItemAppend() {
    if (broken_item_array.length > 0) {
        $('#broken-item-table').html("");
        var list = "";
        $.each(broken_item_array, function (index, value) {
            list += `<tr>
                            <td>${value.category_name}</td>
                            <td>${value.item_name}</td>
                            <td>${value.item_full_count}</td>
                            <td>${value.count}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="javascript:void(0)" class="color-primary me-4 fs-2" onclick="editBrokenItemFromList(${index})">
                                        <i class="ri-pencil-fill"></i>
                                    </a>
                                    <a href="javascript:void(0)" id="delete-broken-item"  class="fs-2">
                                        <i class="ri-delete-bin-7-fill" data-bs-toggle="modal" data-bs-target="#alret-pop-item-${index}"></i>
                                    </a>
                                </div>
                                <!--alret popup -->
                                <div class="modal fade" id="alret-pop-item-${index}" tabindex="-1" aria-labelledby="alret-popLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered popup-alert">
                                        <div class="modal-content rounded-0">
                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <p class="popup-alert_des fw-bold">Delete Damaged Item</p>
                                                    <p>Are you sure you want to delete?</p>
                                                </div>

                                            </div>
                                            <div class="modal-footer justify-content-around text-center">
                                                <button type="button" class="btn btn--dark px-5" data-bs-dismiss="modal">No</button>
                                                <button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal"  onclick="removeBrokenItemFromList(${index})" >Yes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>`;
        });
        $('#broken-item-table').html(list);
    } else {
        $('#broken-item-table').html(`
                            <tr>
                                <td colspan="5" align = "center">Damaged items not added</td>
                            </tr>`)
    }
}


$("#add-broken-item-btn-id").click(function () {
    var cat_id = $(".furniture-category option:selected").val();
    var cat_name = $('.furniture-category option:selected').html().trim()
    var item_id = $(".furniture-items option:selected").val()
    var item_name = $(".furniture-items option:selected").html().trim();
    var full_count = parseInt($(".full-count").val());
    var count = parseInt($('.number').val());
    var createvalid;

    cat_id == '' ? $("#createcaterr").css('display', 'block') : $("#createcaterr").css('display', 'none')
    item_id == '' ? $("#createitemerr").css('display', 'block') : $("#createitemerr").css('display', 'none')
    count <= 0 ? $("#createcounterr").css('display', 'block') : $("#createcounterr").css('display', 'none')
    full_count <= 0 ? $("#createfullcounterr").css('display', 'block') : $("#createfullcounterr").css('display', 'none')

    if (count > full_count) {
        createvalid = 'false'
        $("#validcreatecounterr").css('display', 'block')
    } else {
        createvalid = 'true'
        $("#validcreatecounterr").css('display', 'none')
    }

    if (cat_id != '' && item_id != '' && count >= 0 && full_count != 0 && createvalid == 'true') {
        var flag = true;
        var index = $.map(broken_item_array, function (ele, i) {
            if (cat_id == ele.category_id && item_id == ele.item_id) {
                broken_item_array[i]['count'] = parseInt(broken_item_array[i]['count']) + parseInt(
                    count);
                broken_item_array[i]['item_full_count'] = parseInt(broken_item_array[i]['item_full_count']) + parseInt(
                    full_count);
                flag = false;
            }

        });
        if (flag) {
            var arr = {
                "category_id": cat_id,
                "category_name": cat_name,
                "item_id": item_id,
                "item_name": item_name,
                "count": count,
                "item_full_count": full_count
            };
            broken_item_array.push(arr);
        }

        $(".furniture-category").val($('.furniture-category option:first').val())
        $(".furniture-items").html('<option selected disabled value="">Item Description</option>');
        $('.number').val(0)
        $(".full-count").val(0)
        count = 0;
        brokenItemAppend();
        $(".furniture-items").html("<option selected disabled value=''>Item Description</option>");
        $('#close-broken-item-btn-id').click();
    }

});

function removeBrokenItemFromList(e) {
    broken_item_array.splice(e, 1);
    brokenItemAppend();
}


//closing update model
function closeModel() {
    $(".furniture-items").html("<option selected disabled value=''>Item Description</option>");
    $('#models-update').remove();
    $(".modal-backdrop").remove()
}

//save broken items in localsotorage
function saveBrokenItems() {
    var furn_count_input = $("#total_furniture").val()
    furn_count_input > 0 ? $("#counterror").css('display', 'none') : $("#counterror").css('display', 'block')
    broken_item_array.length > 0 ? $("#itemlisterr").css('display', 'none') : $("#itemlisterr").css('display',
        'block')
    if (broken_item_array.length > 0 && furn_count_input > 0) {
        $("#itemlisterr").css('display', 'none')
        $("#counterror").css('display', 'none')
        window.localStorage.setItem("brokenItems", JSON.stringify(broken_item_array));
        window.localStorage.setItem("totalCount", furn_count_input);
        $('#broken_array').val(JSON.stringify(broken_item_array));
        // $('#collection-submit-btn').removeClass("disabled");
        $("#listsuccess").click()
    } else {
        if (broken_item_array.length <= 0) {
            window.localStorage.removeItem("brokenItems")
            broken_item_array = []
        }
        if (furn_count_input <= 0)
            window.localStorage.removeItem("totalCount")

    }
}

//update edited broken item
function updateBrokenItem(index) {
    var cat_id = $(".furniture-category-update option:selected").val();
    var cat_name = $('.furniture-category-update option:selected').html().trim();
    var item_id = $(".furniture-items-update option:selected").val();
    var item_name = $(".furniture-items-update option:selected").html().trim();
    var count = parseInt($('.number-update').val());
    var full_count = parseInt($(".full-count-update").val());
    var editvalid;

    var resetCount = count;
    var resetFullCount = full_count;
    var resetIndex = [];
    $.map(broken_item_array, function (ele, i) {
        if (cat_id == ele['category_id'] && item_id == ele['item_id'] && index != i) {
            resetCount = resetCount + ele['count'];
            resetFullCount = resetFullCount + ele['item_full_count'];
            resetIndex.push(i);
        }
    })



    cat_id == '' ? $("#editcaterr").css('display', 'block') : $("#editcaterr").css('display', 'none')
    item_id == '' ? $("#edititemerr").css('display', 'block') : $("#edititemerr").css('display', 'none')
    count <= 0 ? $("#editcounterr").css('display', 'block') : $("#editcounterr").css('display', 'none')
    full_count <= 0 ? $("#editfullcounterr").css('display', 'block') : $("#editfullcounterr").css('display', 'none')
    if (count > full_count) {
        editvalid = 'false'
        $("#valideditcounterr").css('display', 'block')
    } else {
        editvalid = 'true'
        $("#valideditcounterr").css('display', 'none')
    }


    if (cat_id != '' && item_id != '' && count > 0 && full_count > 0 && editvalid == 'true') {
        broken_item_array[index]['category_id'] = cat_id;
        broken_item_array[index]['category_name'] = cat_name;
        broken_item_array[index]['item_id'] = item_id;
        broken_item_array[index]['item_name'] = item_name;
        broken_item_array[index]['count'] = resetCount;
        broken_item_array[index]['item_full_count'] = resetFullCount;

        $('.number').val(0);
        $(".full-count").val(0)
        $(".furniture-items").html("<option selected disabled value=''>Item Description</option>");
        $(".furniture-items-update").html("<option selected disabled value=''>Item Description</option>");
        closeModel();

    } else {
        count <= 0 ? $("#editcounterr").css('display', 'block') : $("#editcounterr").css('display', 'none');
        full_count <= 0 ? $("#editfullcounterr").css('display', 'block') : $("#editfullcounterr").css('display', 'none')
    }
    if (resetIndex != '') {
        resetIndex.forEach(element => {
            removeBrokenItemFromList(element)
        });
    } else {
        brokenItemAppend();
    }
}

function checkSubmitVal() {
    var furn_count_input = $("#total_furniture").val()
    furn_count_input > 0 ? $("#counterror").css('display', 'none') : $("#counterror").css('display', 'block');
    broken_item_array.length > 0 ? $("#itemlisterr").css('display', 'none') : $("#itemlisterr").css('display',
        'block')
    if (broken_item_array.length > 0 && furn_count_input > 0) {
        $('#submitvalidsuccess').click()
    }
}

$("#success-pop-ok").click(function () {
    window.location.href = "/furniture-replacement"
})

//submitting the collection  form
$('#collection-submit-btn').click(function () {
    $('#preloader').css('display', 'block');
    if (broken_item_array.length > 0) {
        $("#itemlisterr").css('display', 'none')
        $("#counterrormsg").html('')
        total_furniture = $("#total_furniture").val();
        $.ajax({
            url: "/furniture-replacement",
            type: "POST",
            data: {
                _token: csrf_token,
                total_furniture: total_furniture,
                broken_items: broken_item_array
            },
            dataType: "json",
            success: function (res) {
                $('#preloader').css('display', 'none');

                $("#ref_no_popup").html(res.ref_number)
                window.localStorage.removeItem("brokenItems");
                window.localStorage.removeItem("totalCount")
                $("#success-popup").click();
            },
            error: function (error) {
                $('#preloader').css('display', 'none');
                if (error.status == 422) {
                    $.map(error.responseJSON.errors, function (ele, key) {
                        if (key == 'total_furniture')
                            $("#counterrormsg").html(ele)
                        $("#counterror").css('display', 'block')
                        // alert(ele);

                    });
                }
            }
        })
    } else {
        // alert("please select one item")
        $("#itemlisterr").css('display', 'block')
    }
});

//cancel button 
function cancelButtonRefresh() {
    window.localStorage.removeItem("brokenItems");
    window.localStorage.removeItem("totalCount")
    window.location.reload();
}

//clear the add broken item button
function clearAddBrokenItem() {
    $('.number').val(0);
    $('.full-count').val(0);
    $('.furniture-category').prop("selectedIndex", 0).val();
    $('.furniture-items').html('<option selected disabled value="">Item Description</option>');
}
//clear the edit broken item button
function clearEditBrokenItem() {
    $('.number-update').val(0);
    $('.full-count-update').val(0);
    $('.furniture-category-update').prop("selectedIndex", 0).val();
    $('.furniture-items-update').html('<option selected disabled value="">Item Description</option>');
}

NiceSelect.bind(document.getElementByClassName("furniture-category"));
NiceSelect.bind(document.getElementByClassName("furniture-items"));

function increaseValue() {
    var inptVal = parseInt($('.number').val());
    var inptVal = isNaN(inptVal) ? 0 : inptVal;
    inptVal = inptVal + 1;
    //update 
    var inptValu = parseInt($('.number-update').val());
    var inptValu = isNaN(inptValu) ? 0 : inptValu;
    inptValu = inptValu + 1;

    $('.number').val(inptVal)
    $('.number-update').val(inptValu)
}

function decreaseValue() {
    var inptVal = parseInt($('.number').val());
    var inptVal = isNaN(inptVal) ? 0 : inptVal;
    inptVal < 1 ? inptVal = 1 : 0;
    inptVal = inptVal - 1;

    //update
    var inptValu = parseInt($('.number-update').val());
    var inptValu = isNaN(inptValu) ? 0 : inptValu;
    inptValu < 1 ? inptValu = 1 : 0;
    inptValu = inptValu - 1;

    $('.number').val(inptVal)
    $('.number-update').val(inptValu)
}

//total count counter
function increaseValuetotal() {
    var inptVal = parseInt($('.full-count').val());
    var inptVal = isNaN(inptVal) ? 0 : inptVal;
    inptVal = inptVal + 1;
    //update 
    var inptValu = parseInt($('.full-count-update').val());
    var inptValu = isNaN(inptValu) ? 0 : inptValu;
    inptValu = inptValu + 1;

    $('.full-count').val(inptVal)
    $('.full-count-update').val(inptValu)
}

function decreaseValuetotal() {
    var inptVal = parseInt($('.full-count').val());
    var inptVal = isNaN(inptVal) ? 0 : inptVal;
    inptVal < 1 ? inptVal = 1 : 0;
    inptVal = inptVal - 1;

    //update
    var inptValu = parseInt($('.full-count-update').val());
    var inptValu = isNaN(inptValu) ? 0 : inptValu;
    inptValu < 1 ? inptValu = 1 : 0;
    inptValu = inptValu - 1;

    $('.full-count').val(inptVal)
    $('.full-count-update').val(inptValu)
}
$('#broken_array').val(broken_item_array);
