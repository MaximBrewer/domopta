$('#edit_tree').on('change', function (e) {
    if ($(this).is(':checked')) {
        $('.cat_lv_1 > li,.cat_lv_2 > li').css('cursor', 'move');
        $('.cat_lv_1').sortable({
            stop: function(e, ui){
                var data = {};
                $.each($('.cat_lv_1 > li'), function(i, obj){
                    data[i] = $(obj).data('id');
                });
                $.ajax({
                    url: '/adminka/catalog/tree',
                    data: data,
                    method: "POST",
                });
            }
        });
        $('.cat_lv_2').sortable({
            stop: function(e, ui){
                var data = {};
                $.each($('.cat_lv_2 > li'), function(i, obj){
                    data[i] = $(obj).data('id');
                });
                $.ajax({
                    url: '/adminka/catalog/tree',
                    data: data,
                    method: "POST",
                });
            }
        });
    } else {
        $('.cat_lv_1').sortable("destroy");
        $('.cat_lv_2').sortable("destroy");
        $('.cat_lv_1 > li,.cat_lv_2 > li').css('cursor', 'default');
    }
});