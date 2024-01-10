// page loader
window.addEventListener("load", function () {
  var preloadpage = document.getElementById("preloader");
  preloadpage.style.display = "none";
});
// sidebar
$(function () {
  var $ul = $(".sidebar-navigation > ul");

  $ul.find("li a").click(function (e) {
    var $li = $(this).parent();

    if ($li.find("ul").length > 0) {
      e.preventDefault();
      if ($li.hasClass("selected")) {
        $li.removeClass("selected").find("li").removeClass("selected");
        $li.find("ul").slideUp(400);
        $li.find("a em").addClass("ri-arrow-down-s-fill");
        $li.find("a em").removeClass("ri-arrow-up-s-fill");
      } else {
        if ($li.parents("li.selected").length == 0) {
          $ul.find("li").removeClass("selected");
          $ul.find("ul").slideUp(400);
          $ul.find("li a em").addClass("ri-arrow-down-s-fill");
          $li.find("li a em").removeClass("ri-arrow-up-s-fill");
        } else {
          $li.parent().find("li").removeClass("selected");
          $li.parent().find("> li ul").slideUp(400);
          $li
            .parent()
            .find("> li a em")
            .removeClass("ri-arrow-down-s-fill")
            .addClass("ri-arrow-up-s-fill");
        }

        $li.addClass("selected");
        $li.find(">ul").slideDown(400);
        $li
          .find(">a>em")
          .addClass("ri-arrow-up-s-fill")
          .removeClass("ri-arrow-down-s-fill");
      }
    }
  });
});

// $(function () {
//   $("#select").wombatSelect();
//   $("#select").change(function () {
//     alert("The text has been changed.");
//   });
// });

// for common date input
$(document).ready(function () {
  $(".date-input")
    .datepicker({
      // minDate: "+30d",
      // maxDate: new Date(),
      format: "yyyy/mm/dd",
      autoclose: true,
      todayHighlight: true,
      toggleActive: true,
      endDate: "today"
    })
    .on("changeDate", function (e) {
      var date = new Date(e.date);
      if (date) {
        var month = date.getMonth();
        month = month + 1;
        var day = date.getDate();
        var newformattedDate = date.getFullYear() + "-" + month + "-" + day;
      }
    });
});

// password
var eye = document.getElementById("pass-icon");
eye.addEventListener("click", function () {
  var pass = document.getElementById("login-password");
  if (pass.type == "password") {
    pass.type = "text";
    eye.classList.remove("ri-eye-fill");
    eye.classList.add("ri-eye-off-fill");
  } else {
    pass.type = "password";
    eye.classList.add("ri-eye-fill");
    eye.classList.remove("ri-eye-off-fill");
  }
});
