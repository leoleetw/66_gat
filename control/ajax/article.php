<?
	//ALTER TABLE category AUTO_INCREMENT =0
	include_once("../../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	
	if($action == "add"){
		$sql = "INSERT INTO `article`(`art_title_cn`, `art_title_en`, `art_content`) VALUES 
		('".mysqli_real_escape_string($sqli, trim($_POST['art_title_cn']))."' ,'".mysqli_real_escape_string($sqli, trim($_POST['art_title_en']))."' ,'".stripslashes($_POST['art_content'])."')";
		mysqli_query($sqli,$sql);
		header("Location: ../article_manage.php");
	}
	else if($action == 'edit'){
		$sql = "update `article` set `art_title_cn` = '".mysqli_real_escape_string($sqli, trim($_POST['art_title_cn']))."', `art_title_en` = '".mysqli_real_escape_string($sqli, trim($_POST['art_title_en']))."', `art_content` = '".stripslashes($_POST['art_content'])."'
		where art_id = '".$_POST['art_id']."'";
		mysqli_query($sqli,$sql);
		header("Location: ../article_manage.php");
	}
?>