<?php
    header('Content-type: image/jpeg');//закоментировать чтоб увидеть ошибку
    $img = imagecreatetruecolor(100, 100);
    $red   = $_GET['red']   ?? 0;
    $green = $_GET['green'] ?? 0;
    $blue  = $_GET['blue']  ?? 0;


    $bg = imagecolorallocate($img, $red, $green, $blue);

    imagefill($img, 0, 0, $bg);
    imageellipse($img, 50, 50, 90, 90, 0xffff00);
    imagefilledellipse($img, 40, 40, 15, 15, 0xffff00);
    imagerectangle($img, 10, 5, 60, 25, 0xff0000);
    imageline($img, 10, 20, 40, 25, 0xfff000);

    imagejpeg($img);
    imagedestroy($img);
?>