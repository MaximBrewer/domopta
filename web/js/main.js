//--------------------------------------------------------- proloader

window.addEventListener("load", function () {
  var load_screen = document.getElementById("preloader");
  setTimeout(function () {
    document.body.removeChild(preloader);
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
  $(window).on("load", function () {
    $(".close-h").click(function () {
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

///////////////////////////////////////
$(document).ready(function () {
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
    // $(document).scrollTop(1000);
    // if (false) {
    //     $('body').animate({ scrollTop: 1000 }, 1100); //1100 - скорость
    // } else {
    //     $('html').animate({ scrollTop: 1000 }, 1100);
    // }
  }

  $(".arrows__link.arrows__icon.to-top").on("click", function (e) {
    e.preventDefault();
    $("html,body").stop().animate({ scrollTop: 0 }, 500);
  });

  $(".arrows__link.arrows__icon.to-down").on("click", function (e) {
    e.preventDefault();
    var anchor = $(this);
    $("html, body")
      .stop()
      .animate(
        {
          scrollTop: $(anchor.attr("href")).offset().top,
        },
        777
      );
  });

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
        breakpoint: 1200,
        settings: {
          item: 4,
        },
      },
      {
        breakpoint: 970,
        settings: {
          item: 3,
        },
      },
      {
        breakpoint: 750,
        settings: {
          item: 2,
        },
      },
      {
        breakpoint: 480,
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
        breakpoint: 1200,
        settings: {
          item: 4,
        },
      },
      {
        breakpoint: 970,
        settings: {
          item: 3,
        },
      },
      {
        breakpoint: 750,
        settings: {
          item: 2,
        },
      },
      {
        breakpoint: 480,
        settings: {
          item: 2,
        },
      },
    ],
  });
  var sliderP = $(".photos-tovar__list_p:not(.tovar__one)").lightSlider({
    gallery: true,
    item: 1,
    loop: true,
    slideMargin: 0,
    vertical: true,
    vThumbWidth: 100,
    thumbParentMargin: 20,
    thumbItem: 3,
    controls: true,
    onSliderLoad: function (el) {
      /*  $(".lSPager.lSGallery").wrap("<div class='lSPager-Wrap'></div>");*/
    },
    prevHtml:
      '<div class="photos-tovar__arrow photos-tovar__arrow_l"><span class="photos-tovar__link photos-tovar__icon"><svg class="svg photos-tovar__svg photos-tovar__svg_arrow2-left"><use xlink:href="/img/sprite-sheet.svg#arrow2-left"/></svg></span></div>',
    nextHtml:
      '<div class="photos-tovar__arrow photos-tovar__arrow_r"><span class="photos-tovar__link photos-tovar__icon"><svg class="svg photos-tovar__svg photos-tovar__svg_arrow2-right"><use xlink:href="/img/sprite-sheet.svg#arrow2-right"/></svg></span></div>',
    responsive: [
      {
        breakpoint: 994,
        settings: {
          gallery: true,
          item: 1,
          loop: true,
          slideMargin: 0,
          vertical: true,
          vThumbWidth: 80,
          thumbItem: 3,
          controls: true,
          verticalHeight: 420,
        },
      },
      {
        breakpoint: 480,
        settings: {
          vThumbWidth: 60,
          verticalHeight: 350,
        },
      },
    ],
    onAfterSlide: function (el) {
      $(".current-photo").text($(el).find(".active").data("i"));
    },
  });

  $(".tovar__arrow__wrapperP .photos-tovar__arrow_l").on("click", function () {
    sliderP.goToPrevSlide();
  });

  $(".tovar__arrow__wrapperP .photos-tovar__arrow_r").on("click", function () {
    sliderP.goToNextSlide();
  });
  var picP = document.querySelector(".pic_p");
  var picPP = document.querySelector(".pic_pp");

  //    setTimeout(function(){
  //        if (picP) {
  //            $('.pic_p').magnifier({
  //                magnify: 3,
  //                region: {
  //                h: 38.7,
  //                w: 38.7
  //                },
  //                display: $('.display_p')
  //            });
  //        }
  //    },500)

  $(window).resize(function () {
    if (sliderW.length) {
      sliderW.destroy();
      if (!sliderW.lightSlider) {
        sliderW = $(".products__list_w").lightSlider({
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
              breakpoint: 1200,
              settings: {
                item: 4,
              },
            },
            {
              breakpoint: 970,
              settings: {
                item: 3,
              },
            },
            {
              breakpoint: 750,
              settings: {
                item: 2,
              },
            },
            {
              breakpoint: 480,
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
          loop: true,
          prevHtml:
            '<div class="products__arrow products__arrow_l"><span class="products__link products__icon"><svg class="svg products__svg products__svg_arrow2-left"><use xlink:href="/img/sprite-sheet.svg#arrow2-left"/></svg></span></div>',
          nextHtml:
            '<div class="products__arrow products__arrow_r"><span class="products__link products__icon"><svg class="svg products__svg products__svg_arrow2-right"><use xlink:href="/img/sprite-sheet.svg#arrow2-right"/></svg></span></div>',
          responsive: [
            {
              breakpoint: 1200,
              settings: {
                item: 4,
              },
            },
            {
              breakpoint: 970,
              settings: {
                item: 3,
              },
            },
            {
              breakpoint: 750,
              settings: {
                item: 2,
              },
            },
            {
              breakpoint: 480,
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
    var map = new ymaps.Map("map", {
      center: [44.93335454, 34.11270504],
      zoom: 16,
      controls: ["zoomControl"],
      behaviors: ["drag", "scrollZoom"],
    });
    var placemark = new ymaps.Placemark(
      [44.93335454, 34.11270504],
      {},
      {
        iconColor: "#ff0000",
      }
    );

    map.geoObjects.add(placemark);
  }

  //-------------------------------------------------------------- check-box
  $("body").on("click", "#checkbox-reg", function (e) {
    //console.log(document.querySelector('.checkmark__svg'));
    var checkmark = document.querySelector(".checkmark__svg_pop");
    checkmark.classList.toggle("checkmark__svg_op");
    $(".reg-checkbox").removeClass("has-error");
  });
  $("body").on("change", "#register__input-check", function (e) {
    //console.log(document.querySelector('.checkmark__svg'));
    var checkmark = document.querySelector(".checkmark__svg");
    checkmark.classList.toggle("checkmark__svg_op");
    $(".reg-checkbox").removeClass("has-error");
  });
  $("body").on("click", "#feedback__input-check", function (e) {
    //console.log(document.querySelector('.checkmark__svg'));
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
    $("body").addClass("hidden");
    $(logPop).load("/login/index");
    logPop.classList.toggle("log-pop_flex");
  });
  $("body").on("click", "#reg, #reg2", function (e) {
    e.preventDefault();
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
    $(".common__heading").click(function (e) {
      e.preventDefault();
      e.target
        .closest(".common")
        .querySelector(".common__list")
        .classList.toggle("common__list_show");
    });
  }

  $(".category__link").click(function (e) {
    e.preventDefault();
    e.target.closest(".category__item").classList.toggle("subcategory_show");
  });
  $("#sort").click(function (e) {
    e.preventDefault();
    e.target.closest(".drop-content").length && e.target.closest(".drop-content").classList.toggle("drop-content_show");
  });
  $("#cat").click(function (e) {
    e.preventDefault();
    e.target.closest(".drop-content").length && e.target.closest(".drop-content").classList.toggle("drop-content_show");
    document
      .querySelector(".category__list")
      .classList.toggle("category__list_show");
  });
  $("#cab").click(function (e) {
    e.preventDefault();
    e.target.closest(".drop-content").length && e.target.closest(".drop-content").classList.toggle("drop-content_show");
    document
      .querySelector(".user-btns__list")
      .classList.toggle("user-btns__list_show");
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
  var sliderPP;
  $("body").on("click", ".product .product__icon-eye", function (e) {
    var url = $(this).attr("href");
    e.preventDefault();
    $.get(url, {}, function (response) {
      $(".look-pop").html(response);
      lookPop.classList.toggle("look-pop_flex");
      $(".look-pop-inner").mCustomScrollbar({
        theme: "dark",
      });
      if (sliderPP) {
        if (sliderPP.length) {
          sliderPP.destroy();
          if (!sliderPP.lightSlider) {
            setTimeout(function () {
              sliderPP = $(".photos-tovar__list_pp").lightSlider({
                gallery: true,
                item: 1,
                loop: true,
                slideMargin: 0,
                vertical: true,
                vThumbWidth: 80,
                thumbItem: 3,
                controls: true,
                thumbParentMargin: 20,

                prevHtml:
                  '<div class="photos-tovar__arrow photos-tovar__arrow_l"><span class="photos-tovar__link photos-tovar__icon"><svg class="svg photos-tovar__svg photos-tovar__svg_arrow2-left"><use xlink:href="/img/sprite-sheet.svg#arrow2-left"/></svg></span></div>',
                nextHtml:
                  '<div class="photos-tovar__arrow photos-tovar__arrow_r"><span class="photos-tovar__link photos-tovar__icon"><svg class="svg photos-tovar__svg photos-tovar__svg_arrow2-right"><use xlink:href="/img/sprite-sheet.svg#arrow2-right"/></svg></span></div>',
                onAfterSlide: function (el) {
                  $(".current-photo").text($(el).find(".active").data("i"));
                },
                onSliderLoad: function (el) {
                  /* $(".lSPager.lSGallery").wrap("<div class='lSPager-Wrap'></div>");*/
                },
              });
              $(".tovar__arrow__wrapperPP .photos-tovar__arrow_l").on(
                "click",
                function () {
                  sliderPP.goToPrevSlide();
                }
              );

              $(".tovar__arrow__wrapperPP .photos-tovar__arrow_r").on(
                "click",
                function () {
                  sliderPP.goToNextSlide();
                }
              );

              //                        if (picPP) {
              //                            $('.pic_pp').magnifier({
              //                                magnify: 3,
              //                                region: {
              //                                h: 38.7,
              //                                w: 38.7
              //                                },
              //                                display: $('.display_pp')
              //                            });
              //                        }
            }, 500);
          }
        }
      } else {
        setTimeout(function () {
          sliderPP = $(".photos-tovar__list_pp").lightSlider({
            gallery: true,
            item: 1,
            loop: true,
            slideMargin: 0,
            vertical: true,
            vThumbWidth: 75,
            thumbItem: 3,
            controls: true,
            thumbParentMargin: 20,
            prevHtml:
              '<div class="photos-tovar__arrow photos-tovar__arrow_l"><span class="photos-tovar__link photos-tovar__icon"><svg class="svg photos-tovar__svg photos-tovar__svg_arrow2-left"><use xlink:href="/img/sprite-sheet.svg#arrow2-left"/></svg></span></div>',
            nextHtml:
              '<div class="photos-tovar__arrow photos-tovar__arrow_r"><span class="photos-tovar__link photos-tovar__icon"><svg class="svg photos-tovar__svg photos-tovar__svg_arrow2-right"><use xlink:href="/img/sprite-sheet.svg#arrow2-right"/></svg></span></div>',
            onAfterSlide: function (el) {
              $(".current-photo").text($(el).find(".active").data("i"));
            },
            onSliderLoad: function (el) {
              /* $(".lSPager.lSGallery").wrap("<div class='lSPager-Wrap'></div>");*/
            },
          });
          $(".tovar__arrow__wrapperPP .photos-tovar__arrow_l").on(
            "click",
            function () {
              sliderPP.goToPrevSlide();
            }
          );

          $(".tovar__arrow__wrapperPP .photos-tovar__arrow_r").on(
            "click",
            function () {
              sliderPP.goToNextSlide();
            }
          );
          //                if (picPP) {
          //                    $('.pic_pp').magnifier({
          //                        magnify: 3,
          //                        region: {
          //                        h: 38.7,
          //                        w: 38.7
          //                        },
          //                        display: $('.display_pp')
          //                    });
          //                }
        }, 500);
      }
    });
  });

  $("body").on("submit", "#login-form", function (e) {
    e.preventDefault();
    var form = $(this);
    var formData = $(this).serialize();
    // if (form.find('.has-error').length) {
    //     return false;
    // }

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
      error: function () {
        //alert("Something went wrong");
      },
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

  $("body").on("click", ".product__icon-heart, .tag-tovar-btn__link", function (
    e
  ) {
    e.preventDefault();
    if ($("#enter").length == 0) {
      $.getJSON("/favorites/add", { product_id: $(this).data("id") }, function (
        response
      ) {
        console.log(response);
        $("body").append(response.html);
        $(".liked-header-counter").text(response.count);
      });
    }
  });

  $("body").on("click", ".product__icon-cross", function (e) {
    e.preventDefault();
    $.get("/favorites/remove", { product_id: $(this).data("id") }, function () {
      window.location.reload();
    });
  });

  if (window.location.hash == "#login") {
    $("#enter").click();
  }
  // $( "body" ).find( "liymaps" ).css( "width", "100%" );
  // console.log($( "body" ).find( "liymaps" ));

  // $("#profile-type input").on("change", function () {
  //   if ($(this).val() == 2) {
  //     $("#reg_inn").hide();
  //     $("#reg_org").hide();
  //     $("#reg_location").hide();
  //   } else if ($(this).val() == 1) {
  //     $("#reg_inn").show();
  //     $("#reg_org").hide();
  //     $("#reg_location").hide();
  //   } else {
  //     $("#reg_inn").show();
  //     $("#reg_org").show();
  //     $("#reg_location").show();
  //   }
  // });

  // // $("#reg_inn").hide();
  // // $("#reg_org").hide();
  // // $("#reg_location").hide();

  // if ($("#profile-type input:checked").val() == 2) {
  //   $("#reg_inn").hide();
  //   $("#reg_org").hide();
  //   $("#reg_location").hide();
  // }

  // if ($("#profile-type input:checked").val() == 1) {
  //   $("#reg_inn").show();
  //   $("#reg_org").hide();
  //   $("#reg_location").hide();
  // }

  // if ($("#profile-type input:checked").val() == 3) {
  //   $("#reg_inn").show();
  //   $("#reg_org").show();
  //   $("#reg_location").show();
  // }

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
