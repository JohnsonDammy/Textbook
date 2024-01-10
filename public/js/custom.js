
//password visible
var eye = document.getElementById("pass-icon");
var eyec = document.getElementById("pass-iconc");
function myFunctionn() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
    eye.classList.remove("ri-eye-fill");
    eye.classList.add("ri-eye-off-fill");
  } else {
    x.type = "password";
    eye.classList.add("ri-eye-fill");
    eye.classList.remove("ri-eye-off-fill");
  }
}

function myFunctionc() {
  var cx = document.getElementById("password-confirm");
  if (cx.type === "password") {
    cx.type = "text";
    eyec.classList.remove("ri-eye-fill");
    eyec.classList.add("ri-eye-off-fill");
  } else {
    cx.type = "password";
    eyec.classList.add("ri-eye-fill");
    eyec.classList.remove("ri-eye-off-fill");
  }
}

// for school serach in user module


//start
$("div").on("keyup", "#sname", function () {
  var existingString = $("#sname").val();
  $("#auto_suggestions").empty();
  $("#auto_suggestions").css("height", "auto");
  $("#auto_suggestions").css("overflow-y", "auto");
  $("#tab").empty();
  $("#emis").val("");
  if (existingString.length >= 1) {
    console.log(existingString);
    $("#auto_suggestions").show();
    $.ajax({
      url: "/search",
      type: "get",
      data: { search: existingString },
      dataType: "json",

      success: function (response) {
        let data = response.data;
        if (data.length > 0) {
          $("#auto_suggestions").css("display", "block");

          var trHTML = `<table id="tab" class="table table-hover">
                      <tr><th>School</th><th>EMIS Number</th></tr>

`;
          $.each(data, function (index, value) {
            //console.log(value);
            trHTML +=
              "<tr onClick=\"getSearchKeyword('" +
              value.name +
              "','" +
              value.emis +
              "')\" id=" +
              index +
              " data-value=" +
              value.emis +
              "><td>" +
              value.name +
              "</td><td>" +
              value.emis +
              "</td></tr>";
          });
          $("#auto_suggestions").append(trHTML + "</table>");
          $("#auto_suggestions").css("overflow-y", "auto");
          $("#auto_suggestions").css("height", "auto");
          $("#auto_suggestions").css("max-height", "300px");
          $("#auto_suggestions").css("border", "2px solid #44a244");
          $("#auto_suggestions").css("background", "#fff");
          $("#auto_suggestions").css("border-radius", "5px");
        } else {
          $("#auto_suggestions").css("height", "auto");
          $("#auto_suggestions").css("overflow-y", "auto");
          $("#auto_suggestions").css("border", "2px solid #44a244");
          $("#auto_suggestions").css("background", "#fff");
          $("#auto_suggestions").css("border-radius", "5px");
          $("#auto_suggestions").css("padding", "15px");
          $("#auto_suggestions").html("<p>No School found</p>");
        }
      },
      error: function () {
        //alert('Error while request..');
        console.log("Error while request..");
      },
    });
  }else{
    $("#auto_suggestions").hide();
  }
  return false;
});

//end
function getSearchKeyword(value, emis) {
  var searchKeyword = value;

  //console.log(searchKeyword);
  document.getElementById("sname").value = searchKeyword;
  document.getElementById("emis").value = emis;
  $("#auto_suggestions").empty();
  $("#tab").empty();
  document.getElementById("auto_suggestions").style.display = "none";

  console.log(emis);
}

function getorg(){
  $('.form-check-input').attr("disabled", true);
  $('.form-check-input').prop("checked", false);
 
  var dataid = $("#user-type-select option:selected").attr('data-id');
  var narray = dataid.split(' ');
  var oldper = $('#oldper').val();
  console.log(oldper);
  if(oldper === ''){
    var perarray  = dataid.split(' ');
  }else{
    perarray  = oldper.split(' ');
  }
  
  perarray.forEach((element) => {
    $(`#${element}`).prop("checked", true);
  
});
narray.forEach((element) => {

  $(`#${element}`).attr("disabled", false);
});
$('#oldper').val('');
  console.log(perarray);
}
//
//parsely-validation
$('form').parsley();

