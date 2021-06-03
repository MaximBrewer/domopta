//--------------------------------------------------------- proloader

yii.confirm = function (message, ok, cancel, popup) {
  if (typeof popup == "string") {
    $(".cart_popup_overley").css("display", "block");
    $("#" + popup).css("display", "flex");
    $("#" + popup + " .yes-button").click(function () {
      ok();
    });
  } else {
    if (window.confirm(message)) {
      !ok || ok();
    } else {
      !cancel || cancel();
    }
  }
};

$(function () {
  setTimeout(function () {
    $("#preloader").remove();
  }, 10);
});
function cancelOrder(id) {
  $(".cart_popup_overley").css("display", "block");
  $(".cancel-href").attr("href", "/history/cancel?id=" + id);
  $(".cart_popup.history_cancel").css("display", "flex");
  return false;
}
//----------------------------------------------------------------- costom-skroll
(function ($) {
  $(document).on("click", ".close-pop", function () {
    $(".cart_popup").css("display", "none");
    $(".cart_popup_overley").css("display", "none");
  });

  $(document).on("click", ".esc", function () {
    $(".cart_popup").css("display", "none");
    $(".cart_popup_overley").css("display", "none");
  });
  $(window).on("load", function () {
    $(document).on("click", ".close-h", function () {
      $(".cart_popup_overley").css("display", "none");
      $(".cancel-href").attr("href", "javascript:;");
      $(".cart_popup.history_cancel").css("display", "none");
    });
    $(".contacts-pop-inner").mCustomScrollbar({
      theme: "dark",
    });
    $(".nav-pop-inner").mCustomScrollbar({
      theme: "dark",
    });
    $(".drop-header__list").mCustomScrollbar({
      theme: "dark",
    });
  });
  $("[type=file]").on("change", function (e) {
    var files = [];
    for (var i in this.files) {
      if (this.files[i].name && this.files[i].type)
        files.push(this.files[i].name);
    }
    $(this).parent().find(".file-input__text1").html(files.join(", "));
  });
})(jQuery);
$(document).ready(function () {
  $(document).on("click", "#cat", function (e) {
    e.preventDefault();
    $(e.target).closest(".drop-content").length &&
      $(e.target).closest(".drop-content").toggleClass("drop-content_show");
    document
      .querySelector(".category__list")
      .classList.toggle("category__list_show");
  });

  new Swiper(".gallery-common", {
    slidesPerView: 2,
    spaceBetween: 10,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints: {
      // when window width is >= 480px
      768: {
        slidesPerView: 3,
        spaceBetween: 10,
      },
      // when window width is >= 480px
      992: {
        slidesPerView: 4,
        spaceBetween: 10,
      },
      // when window width is >= 640px
      1200: {
        slidesPerView: 5,
        spaceBetween: 10,
      },
    },
  });

  var galleryThumbs = new Swiper(".gallery-thumbs", {
    slidesPerView: 3,
    spaceBetween: 10,
    loop: true,
    direction: "vertical",
    navigation: {
      nextEl: ".thumbs-next",
      prevEl: ".thumbs-prev",
    },
  });
  var galleryTop = new Swiper(".gallery-right", {
    direction: "vertical",
    spaceBetween: 10,
    loop: true,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    pagination: {
      el: ".count-photo",
      type: "fraction",
    },
    thumbs: {
      swiper: galleryThumbs,
    },
  });
  if (window.location.hash.length && !!$(window.location.hash).offset()) {
    $("html,body").animate(
      {
        scrollTop:
          $(window.location.hash).offset().top -
          $("#header-bottom").outerHeight() -
          100,
      },
      10
    );
  }

  function showHideBtnScroll() {
    var btn = $(".arrows__link.arrows__icon.to-top");
    if ($(window).scrollTop() > 300) {
      btn.show();
    } else {
      btn.hide();
    }
  }
  showHideBtnScroll();

  $(window).on("scroll", function () {
    showHideBtnScroll();
  });

  $(".arrows__link.arrows__icon.to-top").on("click", function (e) {
    e.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, "300");
  });

  // $(".arrows__link.arrows__icon.to-top").on("click", function (e) {
  //   e.preventDefault();
  //   $("html,body").stop().animate({ scrollTop: 0 }, 500);
  // });
  // $(".arrows__link.arrows__icon.to-down").on("click", function (e) {
  //   e.preventDefault();
  //   var anchor = $(this);
  //   $("html, body")
  //     .stop()
  //     .animate(
  //       {
  //         scrollTop: $(anchor.attr("href")).offset().top,
  //       },
  //       777
  //     );
  // });
  //------------------------------------------- input-full
  var inputs = document.getElementsByTagName("input");
  for (let i = 0; i < inputs.length; i++) {
    if (inputs[i].value) {
      if (inputs[i].parentNode.querySelector(".active-input")) {
        inputs[i].parentNode.querySelector(".active-input").style.display =
          "block";
      }
    }
  }
  document.querySelector(".wrapper").addEventListener("input", function (e) {
    if (e.target.value) {
      if (e.target.name == "tc")
        if (e.target.value == "other") {
          document.getElementById("tc_name").style.display = "block";
        } else {
          document.getElementById("tc_name").style.display = "none";
        }
      if (e.target.parentNode.querySelector(".active-input")) {
        e.target.parentNode.querySelector(".active-input").style.display =
          "block";
      }
    }
  });
  //--------------------------------------------------------- header-top
  var headerBottomTop, headerBottomHeight;
  headerBottomTop = $("#header-bottom").offset().top;
  setInterval(function () {
    headerBottomHeight = $("#header-bottom").height();
  }, 200);
  $(window).scroll(function () {
    if ($(window).scrollTop() >= headerBottomTop) {
      $("#header").addClass("header_fixed");
      $("#header").css("padding-bottom", headerBottomHeight);
    } else {
      $("#header").removeClass("header_fixed");
      $("#header").css("padding-bottom", 0);
    }
  });
  //-------------------------------------------------------------- finger
  $(".finger").click(function (e) {
    $(".finger").addClass("finger_none");
  });
  setTimeout(function () {
    $(".finger").addClass("finger_none");
  }, 2500);
  //-------------------------------------------------------------- slider
  var sliderW = $(".products__list_w").lightSlider({
    item: 5,
    adaptiveHeight: false,
    pager: false,
    slideMargin: 0,
    loop: true,
    prevHtml:
      '<div class="products__arrow products__arrow_l"><span class="products__link products__icon"><svg class="svg products__svg products__svg_arrow2-left"><use xlink:href="/img/sprite-sheet.svg#arrow2-left"/></svg></span></div>',
    nextHtml:
      '<div class="products__arrow products__arrow_r"><span class="products__link products__icon"><svg class="svg products__svg products__svg_arrow2-right"><use xlink:href="/img/sprite-sheet.svg#arrow2-right"/></svg></span></div>',
    responsive: [
      {
        breakpoint: 1199,
        settings: {
          item: 4,
        },
      },
      {
        breakpoint: 991,
        settings: {
          item: 3,
        },
      },
      {
        breakpoint: 767,
        settings: {
          item: 2,
        },
      },
      {
        breakpoint: 479,
        settings: {
          item: 2,
        },
      },
    ],
  });
  var sliderR = $(".products__list_r").lightSlider({
    item: 5,
    adaptiveHeight: false,
    pager: false,
    slideMargin: 0,
    loop: true,
    prevHtml:
      '<div class="products__arrow products__arrow_l"><span class="products__link products__icon"><svg class="svg products__svg products__svg_arrow2-left"><use xlink:href="/img/sprite-sheet.svg#arrow2-left"/></svg></span></div>',
    nextHtml:
      '<div class="products__arrow products__arrow_r"><span class="products__link products__icon"><svg class="svg products__svg products__svg_arrow2-right"><use xlink:href="/img/sprite-sheet.svg#arrow2-right"/></svg></span></div>',
    responsive: [
      {
        breakpoint: 1199,
        settings: {
          item: 4,
        },
      },
      {
        breakpoint: 991,
        settings: {
          item: 3,
        },
      },
      {
        breakpoint: 767,
        settings: {
          item: 2,
        },
      },
      {
        breakpoint: 479,
        settings: {
          item: 2,
        },
      },
    ],
  });
  $(window).resize(function () {
    if (sliderW.length) {
      sliderW.destroy();
      if (!sliderW.lightSlider) {
        sliderW = $(".products__list_w").lightSlider({
          item: 5,
          adaptiveHeight: false,
          pager: false,
          slideMargin: 0,
          loop: false,
          prevHtml:
            '<div class="products__arrow products__arrow_l"><span class="products__link products__icon"><svg class="svg products__svg products__svg_arrow2-left"><use xlink:href="/img/sprite-sheet.svg#arrow2-left"/></svg></span></div>',
          nextHtml:
            '<div class="products__arrow products__arrow_r"><span class="products__link products__icon"><svg class="svg products__svg products__svg_arrow2-right"><use xlink:href="/img/sprite-sheet.svg#arrow2-right"/></svg></span></div>',
          responsive: [
            {
              breakpoint: 1199,
              settings: {
                item: 4,
              },
            },
            {
              breakpoint: 991,
              settings: {
                item: 3,
              },
            },
            {
              breakpoint: 767,
              settings: {
                item: 2,
              },
            },
            {
              breakpoint: 479,
              settings: {
                item: 2,
              },
            },
          ],
        });
      }
    }
    if (sliderR.length) {
      sliderR.destroy();
      if (!sliderR.lightSlider) {
        sliderR = $(".products__list_r").lightSlider({
          item: 5,
          adaptiveHeight: false,
          pager: false,
          slideMargin: 0,
          loop: false,
          prevHtml:
            '<div class="products__arrow products__arrow_l"><span class="products__link products__icon"><svg class="svg products__svg products__svg_arrow2-left"><use xlink:href="/img/sprite-sheet.svg#arrow2-left"/></svg></span></div>',
          nextHtml:
            '<div class="products__arrow products__arrow_r"><span class="products__link products__icon"><svg class="svg products__svg products__svg_arrow2-right"><use xlink:href="/img/sprite-sheet.svg#arrow2-right"/></svg></span></div>',
          responsive: [
            {
              breakpoint: 1199,
              settings: {
                item: 4,
              },
            },
            {
              breakpoint: 991,
              settings: {
                item: 3,
              },
            },
            {
              breakpoint: 767,
              settings: {
                item: 2,
              },
            },
            {
              breakpoint: 479,
              settings: {
                item: 2,
              },
            },
          ],
        });
      }
    }
  });
  //-------------------------------------------------------------- map
  if ($("#map").length) {
    ymaps.ready(init);
  }
  function init() {
    var placemark = new ymaps.Placemark(
      [44.93335454, 34.11270504],
      {},
      {
        iconColor: "#ff0000",
      }
    );
    var map = new ymaps.Map("map", {
      center: [44.93335454, 34.11270504],
      zoom: 16,
      controls: ["zoomControl"],
      behaviors: ["drag", "scrollZoom"],
    });
    map.geoObjects.add(placemark);
  }
  //-------------------------------------------------------------- check-box
  $("body").on("click", "#checkbox-reg", function (e) {
    var checkmark = document.querySelector(".checkmark__svg_pop");
    checkmark.classList.toggle("checkmark__svg_op");
    $(".reg-checkbox").removeClass("has-error");
  });
  $("body").on("change", "#register__input-check", function (e) {
    var checkmark = document.querySelector(".checkmark__svg");
    checkmark.classList.toggle("checkmark__svg_op");
    $(".reg-checkbox").removeClass("has-error");
  });
  $("body").on("click", "#feedback__input-check", function (e) {
    var checkmark = document.querySelector(".checkmark__svg");
    checkmark.classList.toggle("checkmark__svg_op");
    $(".reg-checkbox").removeClass("has-error");
  });
  $(".feedback__btn").on("click", function () {
    if (!$("#feedback__input-check").is(":checked")) {
      $(".reg-checkbox").addClass("has-error");
    }
  });
  //-------------------------------------------------------------- btns
  var regPop = document.querySelector(".reg-pop");
  var logPop = document.querySelector(".log-pop");
  var lookPop = document.querySelector(".look-pop");
  var navPop = document.querySelector(".nav-pop");
  var contactsPop = document.querySelector(".contacts-pop");
  var searchPop = document.querySelector(".search-pop");
  $("body").on("click", ".js-login-tab", function (e) {
    regPop.classList.remove("reg-pop_flex");
    e.preventDefault();
    $("body").addClass("hidden");
    $(logPop).load("/login/index");
    logPop.classList.add("log-pop_flex");
  });
  $("body").on("click", ".js-reg-tab", function (e) {
    logPop.classList.remove("log-pop_flex");
    e.preventDefault();
    $("body").addClass("hidden");
    e.preventDefault();
    $(regPop).load("/reg/step1");
    regPop.classList.add("reg-pop_flex");
  });
  $(document).on("click", ".log-pop__recovery-link", function (e) {
    $(logPop).load("/site/forgot");
  });
  $(document).on("click", ".log-pop__recovery-link2", function (e) {
    regPop.classList.remove("reg-pop_flex");
    e.preventDefault();
    $("body").addClass("hidden");
    $(logPop).load("/site/forgot");
    logPop.classList.add("log-pop_flex");
  });
  $("body").on("click", "#enter, #enter-btn", function (e) {
    e.preventDefault();
    typeof apiMobileMenu != "undefined" &&
      apiMobileMenu &&
      apiMobileMenu.close();
    $("body").addClass("hidden");
    $(logPop).load("/login/index");
    logPop.classList.toggle("log-pop_flex");
  });
  $("body").on("click", "#reg, #reg2", function (e) {
    e.preventDefault();
    typeof apiMobileMenu != "undefined" &&
      apiMobileMenu &&
      apiMobileMenu.close();
    $(regPop).load("/reg/step1");
    regPop.classList.toggle("reg-pop_flex");
  });
  $("#nav-btn").click(function (e) {
    e.preventDefault();
    $("body").addClass("hidden");
    navPop.classList.toggle("nav-pop_flex");
  });
  $("#contacts-btn").click(function (e) {
    e.preventDefault();
    $("body").addClass("hidden");
    contactsPop.classList.toggle("contacts-pop_flex");
  });
  $("#search-btn").click(function (e) {
    e.preventDefault();
    $("body").addClass("hidden");
    searchPop.classList.toggle("search-pop_flex");
  });
  $("body").on("click", ".esc", function (e) {
    e.preventDefault();
    $("body").removeClass("hidden");
    if ($(".reg-pop").hasClass("reg-pop_flex")) {
      regPop.classList.toggle("reg-pop_flex");
    }
    if ($(".log-pop").hasClass("log-pop_flex")) {
      logPop.classList.toggle("log-pop_flex");
    }
    if ($(".look-pop").hasClass("look-pop_flex")) {
      lookPop.classList.toggle("look-pop_flex");
    }
    if ($(".nav-pop").hasClass("nav-pop_flex")) {
      navPop.classList.toggle("nav-pop_flex");
    }
    if ($(".contacts-pop").hasClass("contacts-pop_flex")) {
      contactsPop.classList.toggle("contacts-pop_flex");
    }
    if ($(".search-pop").hasClass("search-pop_flex")) {
      searchPop.classList.toggle("search-pop_flex");
    }
  });
  if (window.innerWidth < 1200) {
    $(".common__heading:not(.mobile-open)").click(function (e) {
      e.preventDefault();
      e.target
        .closest(".common")
        .querySelector(".common__list")
        .classList.toggle("common__list_show");
    });
  }
  $(".category__link").click(function (e) {
    e.preventDefault();
    $(e.target).closest(".category__item").toggleClass("subcategory_show");
  });
  $("#sort").click(function (e) {
    e.preventDefault();
    $(e.target).closest(".drop-content").length &&
      $(e.target).closest(".drop-content").toggleClass("drop-content_show");
  });
  $("#cab").click(function (e) {
    e.preventDefault();
    $(e.target).closest(".drop-content").length &&
      $(e.target).closest(".drop-content").toggleClass("drop-content_show");
    document
      .querySelector(".user-btns__list")
      .classList.toggle("user-btns__list_show");
  });
  $(".common__svg_place").click(function () {
    window.open(
      "https://yandex.ru/maps/org/legkiy_veter/1070146733/?ll=34.112570%2C44.933257&z=16.83",
      "_blank"
    );
    return false;
  });
  document.body.addEventListener(
    "click",
    function (e) {
      if ($(e.target).hasClass("reg-pop_flex")) {
        regPop.classList.toggle("reg-pop_flex");
        $("body").removeClass("hidden");
      }
      if ($(e.target).hasClass("log-pop_flex")) {
        logPop.classList.toggle("log-pop_flex");
        $("body").removeClass("hidden");
      }
      if ($(e.target).hasClass("look-pop_flex")) {
        lookPop.classList.toggle("look-pop_flex");
        $("body").removeClass("hidden");
      }
      if ($(e.target).hasClass("nav-pop_flex")) {
        navPop.classList.toggle("nav-pop_flex");
        $("body").removeClass("hidden");
      }
      if ($(e.target).hasClass("contacts-pop_flex")) {
        contactsPop.classList.toggle("contacts-pop_flex");
        $("body").removeClass("hidden");
      }
      if ($(e.target).hasClass("search-pop_flex")) {
        searchPop.classList.toggle("search-pop_flex");
        $("body").removeClass("hidden");
      }
    },
    false
  );
  $("body").on("click", ".product .product__icon-eye", function (e) {
    var url = $(this).attr("href");
    e.preventDefault();
    $.get(url, {}, function (response) {
      $(".look-pop").html(response);
      lookPop.classList.toggle("look-pop_flex");
      $(".look-pop-inner").mCustomScrollbar({
        theme: "dark",
      });
      var galleryThumbsPopup = new Swiper(".gallery-thumbs-popup", {
        slidesPerView: 3,
        spaceBetween: 10,
        direction: "vertical",
        navigation: {
          nextEl: ".thumbs-next",
          prevEl: ".thumbs-prev",
        },
      });
      var galleryTopPopup = new Swiper(".gallery-right-popup", {
        direction: "vertical",
        spaceBetween: 10,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        pagination: {
          el: ".count-photo",
          type: "fraction",
        },
        thumbs: {
          swiper: galleryThumbsPopup,
        },
      });
    });
  });
  $("body").on("submit", "#login-form", function (e) {
    e.preventDefault();
    var form = $(this);
    var formData = $(this).serialize();
    $.ajax({
      url: form.attr("action"),
      type: form.attr("method"),
      data: formData,
      dataType: "json",
      success: function (data) {
        if (!data.success) {
          for (key in data) {
            $("#" + key).addClass("has-error");
          }
          if (data["loginform-login"]) {
            $("#loginform-login-error").html(data["loginform-login"]);
          }
          if (data["loginform-password"]) {
            $("#loginform-password-error").html(data["loginform-password"]);
          }
        } else {
          if (data.id == 1) {
            window.location.href = "/adminka";
          } else {
            window.location.reload();
          }
        }
      },
      error: function () {},
    });
  });
  $("body").on("click", ".js-category__more", function (e) {
    e.preventDefault();
    var href = $(this).attr("href");
    $.get(
      href,
      {},
      function (response) {
        $(".products-middle").append(response.content);
        $(".js-category__more").replaceWith(response.more);
        $(".product__pagination").html(response.pager);
      },
      "json"
    );
    return false;
  });
  $("body").on(
    "click",
    ".product__icon-heart, .tag-tovar-btn__link",
    function (e) {
      e.preventDefault();
      if ($("#enter").length == 0) {
        $.getJSON(
          "/favorites/add",
          { product_id: $(this).data("id") },
          function (response) {
            $.jGrowl(response.html, {
              theme: "blueTheme",
              closerTemplate: "<div>[ закрыть всё ]</div>",
              position: "bottom-right",
              life: 5000,
              closeTemplate:
                '<svg class="svg esc__svg esc__svg_cross1"><use xlink:href="/img/sprite-sheet.svg#cross1" /></svg>',
            });
            $(".liked-header-counter").text(response.count);
          }
        );
      }
    }
  );
  $("body").on("click", ".product__icon-cross", function (e) {
    e.stopPropagation();
    e.preventDefault();
    $.get("/favorites/remove", { product_id: $(this).data("id") }, function () {
      $(e.target).closest(".products__item").remove();
      // window.location.reload();
    });
  });
  if (window.location.hash == "#login") {
    $("#enter").click();
  }
  $("body").on("click", "#show_password", function () {
    $(this).toggleClass("open_eye");
    if ($(this).hasClass("open_eye")) {
      $("#loginform-password").attr("type", "text");
    } else {
      $("#loginform-password").attr("type", "password");
    }
  });
  $("body").on("click", "#show_password2", function () {
    $(this).toggleClass("open_eye");
    if ($(this).hasClass("open_eye")) {
      $("#user-password").attr("type", "text");
    } else {
      $("#user-password").attr("type", "password");
    }
  });
  $("body").on("click", "#show_password3", function () {
    $(this).toggleClass("open_eye");
    if ($(this).hasClass("open_eye")) {
      $("#user-password_repeat").attr("type", "text");
    } else {
      $("#user-password_repeat").attr("type", "password");
    }
  });
  $("body").on("click", ".reg-pop-fav .esc", function () {
    $(this).parent(".reg-pop-fav").remove();
  });
  $("body").on("click", ".input-color-minus", function () {
    if (+$(this).siblings(".input-color").val() > 1) {
      $(this)
        .siblings(".input-color")
        .val(+$(this).siblings(".input-color").val() - 1);
    } else if (+$(this).siblings(".input-color").val() == 1) {
      $(this).siblings(".input-color").val("");
    }
  });
  $("body").on("click", ".input-color-plus", function () {
    $(this)
      .siblings(".input-color")
      .val(+$(this).siblings(".input-color").val() + 1);
  });
  $(window).on("scroll", function () {
    if ($(".table-cart").length)
      if (
        $(".table-cart").offset().top < $(window).scrollTop() &&
        $(".table-cart").offset().top + $(".table-cart").height() >
          $(window).scrollTop()
      ) {
        $(".table-cart thead tr:first-child").css(
          "transform",
          "translateY(" +
            ($(window).scrollTop() +
              $(".header_fixed .header-bottom").height() -
              $(".table-cart").offset().top) +
            "px)"
        );
        $(".table-cart thead tr:first-child").css(
          "-webkit-transform",
          "translateY(" +
            ($(window).scrollTop() +
              $(".header_fixed .header-bottom").height() -
              $(".table-cart").offset().top) +
            "px)"
        );
        $(".table-cart thead tr:first-child").css(
          "-moz-transform",
          "translateY(" +
            ($(window).scrollTop() +
              $(".header_fixed .header-bottom").height() -
              $(".table-cart").offset().top) +
            "px)"
        );
      } else if ($(".table-cart").offset().top > $(window).scrollTop()) {
        $(".table-cart thead tr:first-child").css(
          "transform",
          "translateY(0px)"
        );
        $(".table-cart thead tr:first-child").css(
          "-webkit-transform",
          "translateY(0px)"
        );
        $(".table-cart thead tr:first-child").css(
          "-moz-transform",
          "translateY(0px)"
        );
      }
  });
});
