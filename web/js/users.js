var user_id;

$('.block_link').on('click', function(e){
    e.preventDefault();
    $('#blockform-id').val($(this).data('id'));
    $('#block-form').attr('action', $(this).attr('href'));
});

$('.info_link').on('click', function(e){
    e.preventDefault();
    $('#info-modal').find('.modal-body').text($(this).data('text'));
});

$('.delete-btn').on('click', function(){
    $('input[name=sendemail]').val($(this).data('send'));
    $('#deletemultiply-form').submit();
});

$('.delete-user').on('click', function(e){
        e.preventDefault();
        $('#delete-user-id').val($(this).data('id'));
        $('#delete-user').attr('action', $(this).attr('href'));
        $('#delete-one-modal').modal('show');
});

$('.delete-one-btn').on('click', function(){
    $('#delete-user-send').val($(this).data('send'));
    $('#delete-user').submit();
});