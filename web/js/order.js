$("body").on("change", ".input-color", function () {
  if (parseInt($(this).val()) <= 0) {
    $(this).val("");
  }
});

$("body").on("click", ".form-tovar-btn__link", function (e) {
  e.preventDefault();

  var inputs = $(".input-color");
  var send = !inputs.length;
  if (!send) {
    inputs.each(function () {
      if ($(this).val() != "") {
        send = 1;
      }
    });
  }
console.log(send)
  if (send) {
    $.ajax({
      url: $("#product-form").attr("action"),
      type: "POST",
      data: $("#product-form").serialize(),
      dataType: "json",
      success: function (data) {
        $("#cart_sum").html(data.sum);
        // $('#cart_sum1').text(data.sum);
        $("#cart_amount").text(data.amount);
        // $('#cart_amount1').text(data.amount);
        $(".input-color").val("");
        $(".log-pop").html(data.popup).addClass("log-pop_flex");
      },
    });
  } else {
    alert(
      'Укажите необходимое количество товара (при наличии различных цветов для каждого), затем нажмите "В корзину", и весь выбранный Вами товар попадет в корзину.'
    );
  }
});

$(".gal").on("click", function () {
  $(".bigimg").attr("src", $(this).data("url"));
});
