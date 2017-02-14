<?php

if (!isset($_SESSION)) {
  session_start();
}
function captcha(){
	header('Content-type: image/png');
	$im = imagecreate(110,40) or die('Não inicializou novo GD image Stream');
	$bg_color = imagecolorallocate($im, 0, 255, 255);
	$txt_color = imagecolorallocate($im, 0, 0, 0);
	$pos = '23456789bcdfghjkmnpqrstvwxyz';
	$i = 0;
	$code = "";
	$texto_visual = "";
	while ($i < 5) {
		$char = substr($pos,mt_rand(0, strlen($pos)-1),1);
		$code .= $char;
		$texto_visual .= $char . " ";
		$i++;
	}
	imagestring ($im ,5 , 10 ,10 , $texto_visual ,$txt_color);
	imagepng($im);
	$_SESSION["captcha"] = $code;
	imagedestroy($im);
}
captcha();

?>
