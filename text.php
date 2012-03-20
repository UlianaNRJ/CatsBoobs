<?php

define("FCPATH", "C:\\localhost\\catsboobs\\");

function createImage($file){
	switch ($file['type']){
		case 'image/gif':
			return imagecreatefromgif($file['new_name']);
			break;
		case 'image/jpeg':
			return imagecreatefromjpeg($file['new_name']);
			break;
		case 'image/png':
			return imagecreatefrompng($file['new_name']);
			break;
	}
}


$files = array (
	'boobs' =>
	array (
		'name' => 'maintenance.jpg',
		'type' => 'image/jpeg',
		'tmp_name' => 'C:\localhost\catsboobs\maintenance.jpg',
		'error' => 0,
		'size' => 204212,
	),
);
$type = 'boobs';
$size = 500;

$files[$type]['new_name'] = 'C:\localhost\catsboobs\maintenance.jpg';
$image[$type] = array();
list($image[$type]['width'], $image[$type]['height']) = getimagesize($files[$type]['new_name']);
$image[$type]['source'] = createImage($files[$type]);
$dim = $image[$type]['width'] > $image[$type]['height'] ? 'width' : 'height';
if($image[$type][$dim] < $size){
	$image[$type]['new_width'] = $image[$type]['width'];
	$image[$type]['new_height'] = $image[$type]['height'];
} else {
	$image[$type]['ratio'] = $size / $image[$type][$dim] * 100;
	$image[$type]['new_width'] = $image[$type]['width'] * $image[$type]['ratio'] / 100;
	$image[$type]['new_height'] = $image[$type]['height'] * $image[$type]['ratio'] / 100;
}

$sample = imagecreatetruecolor(2*$size, $size);
imagesavealpha($sample, true);
$transparent = imagecolorallocatealpha($sample, 0, 0, 0, 127);
imagefill($sample, 0, 0, $transparent);

imagecopyresampled(
	$sample,
	$image[$type]['source'],
	$type=='cats'?$size-$image[$type]['new_width']:$size,
	($size-$image[$type]['new_height'])/2,
	0,
	0,
	$image[$type]['new_width'],
	$image[$type]['new_height'],
	$image[$type]['width'],
	$image[$type]['height']
);

$watermark = createImage(array('type'=>'image/png','new_name'=>FCPATH.'skin/img/watermark.png'));
imagecopyresampled(
	$sample,
	$watermark,
	$type=='cats'?($size-$image[$type]['new_width']):($size+$image[$type]['new_width']-132),
	($size-$image[$type]['new_height'])/2,
	0,
	0,
	132,
	92,
	132,
	92
);



$text = "http://catsboobs.com/"; //base_url()
$font_size = 10;
$font_height = 15; //imagefontheight($font_size);
$font_width = 135; //imagefontwidth($font_size)*strlen($text);
$horizontal_padding = 5;
$vertical_padding = 3;

var_dump(imagefontwidth(12)*strlen($text));

$transparent = imagecolorallocatealpha($sample, 0, 0, 0, 60);

imagefilledrectangle(
	$sample,
	$type=='cats'?($size-$font_width-$horizontal_padding):(2*$size-$font_width-$horizontal_padding),
	($size+$image[$type]['new_height'])/2,
	$type=='cats'?$size:2*$size,
	($size+$image[$type]['new_height'])/2 - $font_height,
	$transparent
);

imagettftext(
	$sample,
	$font_size,
	0,
	$type=='cats'?($size-$font_width):(2*$size-$font_width),
	($size+$image[$type]['new_height'])/2 - $vertical_padding,
	imagecolorclosest($sample, 255, 255, 255),
	FCPATH."skin/font/helvetica.ttf",
	$text
);

imagepng($sample, FCPATH.'/maintenance.png' , 5);
imagedestroy($sample);