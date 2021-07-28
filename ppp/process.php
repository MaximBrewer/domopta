<?php
$row = 1;
$glob = glob('ready/*');
foreach ($glob as $file){
    unlink($file);
}
if (file_exists("uploads_csv/1.csv") && ($handle = fopen("uploads_csv/1.csv", "r")) !== FALSE) {
    @unlink('1.zip');
    $zip = new ZipArchive();
    $zip->open('1.zip', ZipArchive::CREATE);
    $absent = '';
    while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
        $has = 0;

        $num = count($data);
        $row++;
        if($row == 2) continue;
        $name = $data[2];

        $glob = glob('uploads/*');
        foreach($glob as $file) {
            $name1 = explode('/', $file);
            $name2 = explode('.', $name1[1]);
            $name3 = explode('(', $name2[0]);
            if( trim($name3[0]) == $name){
                $has = 1;
                $im = imagecreatefromjpeg($file);
                $black = imagecolorallocate($im, 0, 0, 0);


                $w = imagesx($im);
//                echo $w; die();

                $font_size = $w * 16 / 500;

                $box = imagettfbbox($font_size, 0, 'arial.ttf', "#" . $data[2]);

                $start_x = $w * 20 /500;
                $start_y = $w * 20 /500 - $box[5];

                Imagettftext($im, $font_size, 0, $start_x, $start_y, $black, 'arial.ttf', "#" . $data[2]);



                $box = imagettfbbox($font_size, 0, 'arial.ttf', $data[9] . ' (руб)');

                $start_x = $w * 20 /500;
                $start_y = $start_y + $w * 20 /500 - $box[5];

                Imagettftext($im, $font_size, 0, $start_x, $start_y, $black, 'arial.ttf', $data[9] . ' (руб)');



                $box = imagettfbbox($font_size, 0, 'arial.ttf', $data[5]);

                $start_x = $w - $box[4] - $w * 20 /500;

                Imagettftext($im, $font_size, 0, $start_x, $start_y, $black, 'arial.ttf', $data[5]);


//                header("Content-Type: image/jpeg");
                Imagejpeg($im, 'ready/' . $name1[1]);
                ImageDestroy($im);
                $zip->addFile('ready/' . $name1[1]);
            }
        }
        if(!$has){
            $absent .= 'артикул: ' . $data[2] . '<br />';
        }

    }
    fclose($handle);
    $zip->close();

    $glob = glob('uploads/*');
    foreach ($glob as $file){
        unlink($file);
    }

    $glob = glob('uploads_csv/*');
    foreach ($glob as $file){
        unlink($file);
    }

    echo '<a href="1.zip">Скачать архив</a>';
    if($absent != ''){
        echo 'Фото не найдено: <br />';
        echo $absent;
    }
}