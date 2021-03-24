$('#getLink').on('click', function(e){
    e.preventDefault();
    var string = $('#category-name').val();
    var parent_id = $('#category-parent_id').val();
    var id = $('#category-id').val();
    if(string != ''){
        $.ajax({
            url: '/adminka/catalog/slugcat?string=' + string + '&parent_id=' + parent_id + '&id=' + id,
            success: function(data){
                $('#category-slug').val(data);
            }
        });
    }
});