<?
	include_once("../include/dbinclude.php");
	include_once("../include/captcha/simple-php-captcha.php");
	$_SESSION['captcha'] = simple_php_captcha();
	exit($_SESSION['captcha']['image_src']);
?>