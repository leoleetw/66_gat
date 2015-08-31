<?
	//ALTER TABLE category AUTO_INCREMENT =0
	include_once("../../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	
	if($action == "check_store"){
		if($_POST["result"] == 'pass')
			$sql = "INSERT INTO store( user_id, store_state) VALUES ('".$_POST["user_id"]."' ,  0)";
		else if($_POST["result"] == 'attest')
			$sql = "INSERT INTO store( user_id, store_state) VALUES ('".$_POST["user_id"]."' ,  1)";
		mysqli_query($sqli,$sql);
		if($_POST["result"] == 'pass' || $_POST["result"] == 'attest')
			$sql = "update store_apply set sa_state = 1 where user_id = '".$_POST["user_id"]."'";
		else if($_POST["result"] == 'fail')
			$sql = "update store_apply set sa_state = 2 where user_id = '".$_POST["user_id"]."'";
		mysqli_query($sqli,$sql);

		echo "0|".$_POST["user_id"] ;
	}
	else if($action == "change_name"){
		$sql = "update user set user_name = '".$_POST["name"]."' where user_id = '".$_POST["user_id"]."'";
		if(!mysqli_query($sqli,$sql))
			echo "1";
		else
			echo "0";
	}
	else if($action == "change_pwd"){
		/*
		echo $_POST["user_id"]."<br>";
		echo $_POST["user_pwd"]."<br>";
		echo md5(md5($_POST["user_pwd"]))."<br>";
		*/
		$sql = "update user set user_pwd = '".md5(md5($_POST["user_pwd"]))."' where user_id = '".$_POST["user_id"]."'";
		if(!mysqli_query($sqli,$sql))
			echo "1";
		else
			echo "0";
		
	}
?>