<?php
	define ('_path', 'http://220.134.32.90/66_gat/control/');
	define ('_page', '/66_gat/control/');
	if($_SESSION["admin_id"]==""){
		header("Location: login.php");
	}
?>