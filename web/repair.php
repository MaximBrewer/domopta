<?php


$mysqli = new mysqli("localhost", "domopta", "L5f8S7q8", "domopta");
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    die;
}

$dir = "/var/www/domopta/data/www/domopta.ru/web/upload/product/";
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if (is_dir($dir . $file) && $file != "." && $file != "..") {
                $dir1 = $dir . $file;
                echo $file . "<br>";
                $result = $mysqli->query("SELECT category_id from products where folder LIKE '$file'");
                if ($myrow = $result->fetch_array()) {
                    $category_id = $myrow['category_id'];
                    if ($dh1 = opendir($dir1)) {
                        while (($file1 = readdir($dh1)) !== false) {
                            if (is_file($dir1 . DIRECTORY_SEPARATOR . $file1) && $file1 != "." && $file1 != "..") {
                                $pattern = '~' . $file . '([0-9]*)\.~';
                                preg_match($pattern, $file1, $matches);
                                if (count($matches)) {
                                    $order = (int)$matches[1];
                                    $image = $file1;
                                    $sql = "INSERT INTO `products_images`(`folder`, `category_id`, `image`, `order`) VALUES ('$file','$category_id','$image','$order')";
                                    echo $sql . "<br>";
                                    $result = $mysqli->query($sql);
                                }
                            }
                        }
                        closedir($dh1);
                    }
                }
            }
        }
        closedir($dh);
    }
}
