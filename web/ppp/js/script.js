$(document).ready(function(){
    $('#submitForm').ajaxForm({
        target:'#imagesPrev',
        beforeSubmit:function(){
            // $('#status').html('Загрузка...');

            $('#status').css('display', 'flex');
        },
        success:function(){
            $('#imgs').val('');
            $('#status').css('display', 'none');
        },
        error:function(){
            $('#status').html('Images uploading failed, please try again.');
        }
    });

    $('#submitFormCSV').ajaxForm({
        target:'#csvPrev',
        beforeSubmit:function(){
            $('#status').css('display', 'flex');
        },
        success:function(){
            $('#csv').val('');
            $('#status').css('display', 'none');
        },
        error:function(){
            $('#status').html('CSV uploading failed, please try again.');
        }
    });

    $('#stratForm').ajaxForm({
        target:'#startPrev',
        beforeSubmit:function(){
            $('#status').css('display', 'flex');
        },
        success:function(){
            //$('#csv').val('');
            $('#status').css('display', 'none');
        },
        error:function(){
            $('#status').html('CSV uploading failed, please try again.');
        }
    });

});