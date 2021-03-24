$('.import-link1').on('click', function(e){
    e.preventDefault();
    $('#file-input-field').click();
});

$('#file-input-field').on('change', function(e){
    var filename = this.files[0].name;
    if(filename != ''){
        $('.file-input__text1').text(filename);
    }
});