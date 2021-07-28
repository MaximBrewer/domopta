$('#getLink').on('click', function(e){
    e.preventDefault();
    var string = $('#news-name').val();
    if(string != ''){
        $.ajax({
            url: '/'+window.moduleId+'/news/slug?string=' + string,
            success: function(data){
                $('#news-slug').val(data);
            }
        });
    }
});