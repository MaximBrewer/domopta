$('body').on('submit', '#reg-form', function (e) {
    e.preventDefault();
    var form = $(this);
    var formData = $(this).serialize();
    // if (form.find('.has-error').length) {
    //     return false;
    // }

    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: formData,
        dataType: 'json',
        success: function (data) {
            if(!data.success){
                for(key in data){
                    $('#' + key).addClass('has-error');
                    if(data['mobregform-phone']){
                        $('#mobregform-phone-error').html(data['mobregform-phone']);
                        $('.reg-pop__txt').hide();
                    } else {
                        $('.reg-pop__txt').show();
                    }
                    if(data['mobregform-agree']){
                        $('.reg-checkbox').addClass('has-error');
                    }
                }
            } else {
                $('#mobregform-phone2').val(data.phone);
                $('.reg-pop__txt').show();
                $('.reg-pop__step1').hide();
                $('.reg-pop__step2').show();
            }
        },
        error: function () {
           // alert("Something went wrong");
        }
    });

});

$('body').on('submit', '#reg-form-2', function (e) {
    e.preventDefault();
    var form = $(this);
    var formData = $(this).serialize();
    if (form.find('.has-error').length) {
        return false;
    }

    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: formData,
        dataType: 'json',
        success: function (data) {
            if(!data.success){
                for(key in data){
                    $('#' + key).addClass('haserror');
                    if(data['mobregform-phone']){
                        $('#mobregform-phone-error').html(data['mobregform-phone']);
                    }
                    if(data['mobregform-code']){
                        $('#mobregform-code-error').html(data['mobregform-code']);
                    }
                }
            } else {
                window.location.reload();
            }
        },
        error: function () {
           // alert("Something went wrong");
        }
    });

});


$('body').on('submit', '#forgot-form', function (e) {
    e.preventDefault();
    var form = $(this);
    var formData = $(this).serialize();

    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: formData,
        dataType: 'json',
        success: function (data) {
            if(!data.success){
                for(key in data){
                    $('#' + key).addClass('has-error');
                    if(data['forgotform-phone']){
                        $('#forgotform-phone-error').html(data['forgotform-phone']);
                    }
                    if(data['forgotform-recaptcha']){
                        $('#forgotform-recaptcha-error').html(data['forgotform-recaptcha']);
                    }
                }
            } else {
                $('.log-pop').html(data.popup);
            }
        },
        error: function () {
           // alert("Something went wrong");
        }
    });

});