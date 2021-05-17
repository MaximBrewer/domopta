var amount;
var memo;

$(".cart-main__amount").on("focus", function () {
  amount = $(this).val();
});
$(".cart-main__amount").on("blur, change", function () {
  if ($(this).val() == parseInt($(this).val()) && $(this).val() != amount) {
    $.ajax({
      url: "/cart/change",
      type: "POST",
      data: {
        detail_id: $(this).data("id"),
        amount: $(this).val(),
      },
      dataType: "json",
      success: function (data) {
        $("#cart_sum").html(data.sum);
        $("#cart_sum1").html(data.sum);
        $(".cart-main-num").html(data.sum);
        $(".cart-main-quantity").html(data.amount);
        $("#cart_amount").html(data.amount);
        $("#cart_amount1").html(data.amount);
        $("#cart_amount2").html(data.amount);
        $(".detail-sum[data-id=" + data.row_id + "]").html(data.row);
        $(".detail-amount[data-id=" + data.row_id + "]").html(data.row_amount);
      },
    });
  } else {
    $(this).val(amount);
  }
});

$("body").on("focus", ".memo", function () {
  memo = $(this).val();
});

$("body").on("blur", ".memo", function () {
  if ($(this).val() != memo) {
    $.ajax({
      url: "/cart/memo",
      type: "POST",
      data: {
        id: $(this).data("id"),
        memo: $(this).val(),
      },
      dataType: "json",
    });
  }
});

$(".order_link").on("click", function (e) {
  if (minimalSumm > 1 * $(".cart-main-num").text()) {
    e.preventDefault();
    $(".cart_popup_overley").css("display", "block");
    $(".cart_popup.cart_minimum").css("display", "flex");
    return false;
  }
  if ($(".cart_selled").length > 0) {
    e.preventDefault();
    $(".cart_popup_overley").css("display", "block");
    $(".cart_popup.cart_sold").css("display", "flex");
    return false;
  }
  if (!$(".cart-main__item-desc").length) {
    e.preventDefault();
    $(".cart_popup_overley").css("display", "block");
    $(".cart_popup.cart_empty").css("display", "flex");
    return false;
  }
});
$(function () {

  if ($(".cart_selled").length > 0) {
    $(".cart_popup_overley").css("display", "block");
    $(".cart_popup.cart_sold").css("display", "flex");
  }
});
