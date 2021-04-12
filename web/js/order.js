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
  if (send) {
    $.ajax({
      url: $("#product-form").attr("action"),
      type: "POST",
      data: $("#product-form").serialize(),
      dataType: "json",
      success: function (data) {
        $("#cart_sum").html(data.sum);
        $("#cart_amount").text(data.amount);
        $(".input-color").val("");
        $.jGrowl(data.popup, {
          theme: "blueTheme",
          closerTemplate: "<div>[ закрыть всё ]</div>",
          position: "bottom-right",
          life: 5000,
          closeTemplate: '<svg class="svg esc__svg esc__svg_cross1"><use xlink:href="/img/sprite-sheet.svg#cross1" /></svg>'
        });
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
