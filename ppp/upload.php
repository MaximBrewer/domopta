<?php
if(isset($_POST['submit'])){

    $target_dir = "uploads/";
    $allow_types = array('jpg');

    $images_arr = array();
    if(!isset($_FILES['images'])) die();
    foreach($_FILES['images']['name'] as $key=>$val){
        $image_name = $_FILES['images']['name'][$key];
        $tmp_name   = $_FILES['images']['tmp_name'][$key];
        $size       = $_FILES['images']['size'][$key];
        $type       = $_FILES['images']['type'][$key];
        $error      = $_FILES['images']['error'][$key];


        $file_name = basename($_FILES['images']['name'][$key]);
        $targetFilePath = $target_dir . $file_name;


        $file_type = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        if(in_array($file_type, $allow_types)){

            if(move_uploaded_file($_FILES['images']['tmp_name'][$key],$targetFilePath)){
                $images_arr[] = $targetFilePath;
            }
        }
    }


    if(!empty($images_arr)){
        echo 'Загружено ' . count($images_arr) . ' фото';
    }
}