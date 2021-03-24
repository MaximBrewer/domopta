<?php

return [
    'adminEmail' => 'admin@example.com',
    'clientOptions' => [
        'height' => '500px',
        //'inline' => true,
        'plugins' => [
            "advlist autolink lists link anchor",
            "searchreplace",
            "media table",
            "image imagetools visualchars textcolor",
            "colorpicker hr nonbreaking code"
        ],
        'font_formats' => 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;'
            .'Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;'
            .'Calibri=calibri;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;'
            .'Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;'
            .'Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;'
            .'Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats',
        'content_style' => 'p {font-family: Calibri}',
        'toolbar1' => "undo redo | styleselect fontselect fontsizeselect forecolor backcolor | bold italic",
        'toolbar2' => "alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code",
        'image_advtab' => true,
        'images_upload_url'=> '/adminka/default/upload',
        // here we add custom filepicker only to Image dialog
        'file_picker_types'=>'image',
        'convert_urls' => false,
        // and here's our custom image picker
        'file_picker_callback'=> new \yii\web\JsExpression("function(callback, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function() {
                var file = this.files[0];

                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var blobInfo = blobCache.create(id, file, reader.result);
                    blobCache.add(blobInfo);

                    // call the callback and populate the Title field with the file name
                    callback(blobInfo.blobUri(), { title: file.name });
                };
            };
            input.click();
        }")
    ]
];
