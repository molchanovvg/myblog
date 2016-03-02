<?php
session_start();
define('CAPTCHA_NUMCHARS', 6);
define('CAPTCHA_WIDTH', 120);
define('CAPTCHA_HEIGHT', 30);
define('PATH_FONT', 'fonts/Roboto-Regular.ttf');

$pass='';
for($i=0; $i < CAPTCHA_NUMCHARS; $i++)
{
    $pass=$pass.chr(rand(97, 122));
}
$_SESSION['pass']=sha1($pass);


$img = imagecreatetruecolor(CAPTCHA_WIDTH, CAPTCHA_HEIGHT);
$bg_color = imagecolorallocate($img, 255, 255, 255);
$text_color = imagecolorallocate($img, 0, 0, 0);
$graphic_color = imagecolorallocate($img, 64, 64, 64);

imagefilledrectangle($img, 0, 0, CAPTCHA_WIDTH, CAPTCHA_HEIGHT, $bg_color);

for ($i=0; $i<5; $i++)
{
    imageline($img, 0, rand() %CAPTCHA_HEIGHT, CAPTCHA_WIDTH, rand() %CAPTCHA_HEIGHT, $graphic_color);
}
for ($i=0; $i<50; $i++)
{
    imagesetpixel($img, rand() %CAPTCHA_WIDTH, rand() %CAPTCHA_HEIGHT, $graphic_color);
}

imagettftext($img, 18, 0, 5, CAPTCHA_HEIGHT-5, $text_color, PATH_FONT, $pass);
header("Content-type: image/png");
imagepng($img);

imagedestroy($img);
