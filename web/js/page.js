$('#getLink').on('click', function(e){
    e.preventDefault();
    var string = $('#page-name').val();
    if(string != ''){
        $.ajax({
            url: '/adminka/pages/slug?string=' + string,
            success: function(data){
                $('#page-slug').val(data);
            }
        });
    }
});