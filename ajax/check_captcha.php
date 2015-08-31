<?
	include_once("../include/dbinclude.php");
	if(strtolower($_SESSION['captcha']['code'])!=strtolower($_POST['captcha_code']))
		echo "1|";
	else
		echo "0";
?>