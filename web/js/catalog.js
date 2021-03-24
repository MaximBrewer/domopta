// alert('1');

// sdgrethtg

$(document).ready(function(){
    var str = location.search.substring().substr(4);
    str = str.split("&");
    //$('[data-id='+str[0]+']').toggleClass("admin-bg_active");

    $('.delete-btn').on('click', function(){
        $('#deletemultiply-form').submit();
    });

});
