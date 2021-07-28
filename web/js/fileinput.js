var file_data = [];
function doSortable() {
  $(".fl-dd").sortable({
    disabled: false,
    update: function (event, ui) {
      var ids = [];
      $(".fl-item-uploaded").each(function (index, obj) {
        ids[index] = $(obj).data("id");
      });
      $.post("/"+window.moduleId+"/catalog/sort2", { ids });
    },
  });
}
function removeSortable() {
  $(".fl-dd").sortable({
    disabled: true,
  });
}
function readURL(input_files) {
  var j = 0;
  for (i in input_files) {
    var len = file_data.length;
    file_data.push({
      file: input_files[i],
    });

    var item = $(".fl-item-default").clone();
    var img = item.find("img");
    img.attr("src", window.URL.createObjectURL(input_files[i]));
    item.removeClass("fl-item-default");
    item.addClass("fl-item");
    item.addClass("fl-item-notuploaded");
    item.data("index", j + len);
    $(".fl-dd").append(item);
    $(".fl-clear-photo").css("display", "inline-block");
    j++;
  }
}
$(".fl-js-input").on("change", function (e) {
  var input_files = [];
  for (var i = 0; i < $(this).get(0).files.length; ++i) {
    input_files[$(this).get(0).files[i].name] = $(this).get(0).files[i];
  }
  var sorted = [];
  Object.keys(input_files)
    .sort()
    .forEach(function (key) {
      sorted[key] = input_files[key];
    });
  readURL(sorted);
  removeSortable();
});
$(".fl-add-photo").on("click", function () {
  $(".fl-js-input-main").click();
});
$(".fl-clear-photo").on("click", function (e) {
  e.preventDefault();
  $(".fl-item-notuploaded").remove();
  $(".fl-js-input").val("");
  file_data = [];
  $(this).css("display", "none");
});
$(".fl-upload").on("click", function () {
  if ($(".fl-item-notuploaded").length == 0) {
    file_data = [];
    return false;
  }
  var input_name = $(".fl-js-input").attr("name");
  input_name = input_name.replace("[]", "");

  var formData = new FormData();
  for (var i = 0; i < file_data.length; i++) {
    if (file_data[i] != undefined) {
      formData.append(input_name + "[" + i + "]", file_data[i].file);
    }
  }
  $(".fl-progress").show();
  $.ajax({
    url: "/"+window.moduleId+"/test/upload?id=" + fl_model_id,
    data: formData,
    processData: false,
    contentType: false,
    dataType: "json",
    type: "POST",
    success: function (data) {
      $(".fl-progress").hide();
      $(".fl-clear-photo").css("display", "none");
      file_data = [];
      $(".fl-item-notuploaded").each(function (index, obj) {
        $(obj).removeClass("fl-item-notuploaded");
        $(obj).addClass("fl-item-uploaded");
        $(obj).data("id", data.ids[index]);
      });
      doSortable();
    },
  });
  //$('#upload-form').submit();
});
$("body").on("click", ".fl-item-notuploaded .fl-remove", function () {
  var index = $(this).parents(".fl-item-notuploaded").data("index");
  delete file_data[index];
  $(this).parents(".fl-item-notuploaded").remove();
});
$("body").on("click", ".fl-item-uploaded .fl-remove", function () {
  var id = $(this).parents(".fl-item-uploaded").data("id");
  $.get("/"+window.moduleId+"/catalog/deleteimage?id=" + id);
  var id = $(this).parents(".fl-item-uploaded").remove();
});
$("body").on("click", ".fl-item img", function () {
  $("#modal_image").attr("src", $(this).attr("src"));
  $("#myModal").modal("show");
});
doSortable();
