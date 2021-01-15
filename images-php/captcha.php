<?php
session_start();
header('Content-type: image/png');
$img = imagecreatetruecolor(200, 50);

imagefill($img, 0, 0, 0xdddddd);
for ($i=0; $i < 1000 ; $i++) { 
    imagesetpixel($img, rand(0,200), rand(0,50), 0xaaaaaa);
}
for ($i=0; $i < 7 ; $i++) { 
    imageline($img, rand(0,200), rand(0,50), rand(0,200), rand(0,50), 0x888888);
}
for ($i=0; $i < 7 ; $i++) { 
    imageline($img, rand(0,200), rand(0,50), rand(0,200), rand(0,50), 0x888888);
}
$letters = 'qwertyuiopasdfghjklzxcvbnmQWERYUOIPLJHFDGHHTDEEEWEWW1234567890';
$word = '';
for ($i=0; $i < 3 ; $i++) { 
    $letter = $letters[rand(0,strlen($letters)-1)];
    // imagestring($img, 7, 5+$i*20, 20, $letter, 0x000000);
    // imageline($img, rand(0,200), rand(0,50), rand(0,200), rand(0,50), 0x888888);
    imagettftext($img, 20, rand(-3,3), 10+$i*25, 20, 0x000000, __DIR__.'/fonts/calibri.ttf', $letter);
    $word.=$letter;
}
$_SESSION['captcha'] = $word;

imagepng($img);
imagedestroy($img);