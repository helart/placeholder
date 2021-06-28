<?php
// https://ergom.ru/gimg/png/100x150
// https://ergom.ru/gimg/png/150x150
if(!isset($_GET['size'])) exit('error');

$type = '';

switch ($_GET['type']) {
	case 'jpg':
		$type = 'jpg';
		break;
	case 'jpeg':
		$type = 'jpg';
		break;
	case 'gif':
		$type = 'gif';
		break;
	default:
		$type = 'png';
		break;
}



$size = explode('x', $_GET['size']);
$width = (int)$size[0];
if($width <= 0) exit('error');
$height = isset($size[1])? (int)$size[1] : $width;
if($height <= 0) $height = $width;
header("Content-type: image/" . $type);
$text = $width . 'x' . $height;

$font = './arial.ttf';

$scale = $width / $height;

$image = imageCreate($width, $height);
imageFilledRectangle($image, 0, 0, $width - 1, $height - 1, imageColorAllocate($image, 192, 192, 192));

$tcount = strlen($text);

$font_size = round(max($width, $height) / $tcount);
$colorLine	= imageColorAllocate($image, 225, 225, 225);
imageline($image, 0, 0, $width, $height, $colorLine);
imageline($image, 0, $height, $width, 0, $colorLine);

if($font_size > 3){
	$l = ($width >= $height)? 0 : 90;

	$colorText		= imageColorAllocate($image, 160, 151, 151);

	$box = @imagettfbbox($font_size, $l, $font, $text) ;
	if($l == 0){
		$x = $width/2 - round(($box[2]-$box[0]) / 2);
		$y = $height/2 - round(($box[5]-$box[3]) / 2);
	} else {
		$x = $width/2 + round(($box[0]-$box[6]) / 2);
		$y = $height/2 + round(($box[1]-$box[3]) / 2);
	}
	imagettftext($image, $font_size, $l, $x, $y, $colorText, $font, $text);
}

if($type == 'jpg') imagejpeg($image);
elseif($type == 'gif') imagegif($image);
else imagepng($image);

