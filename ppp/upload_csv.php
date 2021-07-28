<?php
if(isset($_POST['submit'])){

    $target_dir = "uploads_csv/";
    $allow_types = array('csv');

    $images_arr = array();
    if(!isset($_FILES['csv'])) die();
        $image_name = $_FILES['csv']['name'];
        $tmp_name   = $_FILES['csv']['tmp_name'];
        $size       = $_FILES['csv']['size'];
        $type       = $_FILES['csv']['type'];
        $error      = $_FILES['csv']['error'];


        $file_name = basename($_FILES['csv']['name']);
        $targetFilePath = $target_dir . '1.csv';


        $file_type = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        if(in_array($file_type, $allow_types)){

            if(move_uploaded_file($_FILES['csv']['tmp_name'],$targetFilePath)){
                $images_arr[] = $targetFilePath;
            }
        }



    if(!empty($images_arr)){
        echo 'Загружен ' . count($images_arr) . ' CSV';
    }
}