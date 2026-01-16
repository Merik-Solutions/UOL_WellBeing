/* Header
================================*/
$(document).ready(function () {
  "use strict";
  $(window).scroll(function () {
    var scroll = $(window).scrollTop();
    if (scroll >= 20) {
      $("header").addClass("move shadow");
    } else {
      $("header").removeClass("move shadow");
    }
  });
  $(".menu-btn").click(function () {
    $(this).toggleClass("cls");
  });
});

/*Smooth Scroll
================================*/
$(document).ready(function () {
  "use strict";
  function goToByScroll(id) {
    $("html , body").animate(
      {
        scrollTop: $(id).offset().top,
      },
      "slow"
    );
  }
  $(".scroll").click(function () {
    goToByScroll($(this).attr("href"));
    return false;
  });
});

/* Top
=============================*/
$(document).ready(function () {
  "use strict";
  var scrollbutton = $(".up_btn");
  $(window).scroll(function () {
    $(this).scrollTop() >= 700 ? scrollbutton.show() : scrollbutton.hide();
  });
  scrollbutton.click(function () {
    $("html , body").animate(
      {
        scrollTop: 0,
      },
      600
    );
  });
});

/* Screens
=============================*/
$(document).ready(function () {
  "use strict";
  $(".screens").owlCarousel({
    loop: true,
    nav: false,
    dots: true,
    smartSpeed: 3000,
    autoplayHoverPause: true,
    margin: 25,
    autoplay: true,
    responsive: {
      0: { items: 1 },
      480: { items: 1 },
      577: { items: 2 },
      768: { items: 3 },
      992: { items: 3 },
      1200: { items: 4 },
    },
  });
});

/*Loading
==========================*/
$(window).on("load", function () {
  "use strict";
  AOS.init({
    offset: 20,
    duration: 700,
    easing: "ease-in-out",
  });
  $(".load_cont").fadeOut(function () {
    $(this).parent().fadeOut();
    $("body").css({
      "overflow-y": "visible",
    });
  });
});
