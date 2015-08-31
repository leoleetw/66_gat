<?
	include_once("../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == "check_pwd"){
		$sql = "select * from user where user_id ='".$_SESSION["user_id"]."' and user_pwd ='".md5(md5($_POST["pwd"]))."'";
		$result = mysqli_query($sqli,$sql);
		$rs_cn = mysqli_num_rows($result);
		if($rs_cn == 1)
			echo '0';
		else
			echo '1';
	}
	else if($action == "safe"){
		$sql = "update user set user_pwd = '".md5(md5($_POST["new_pwd"]))."' where user_id = '".$_SESSION["user_id"]."'";
		if(!mysqli_query($sqli,$sql))
			echo '1';
		else
			echo '0';
	}
	else if($action == "self"){
		/*
		$sql = "update user set user_pwd = '".md5(md5($_POST["pwd"]))."' where user_id = '".$_SESSION["user_id"]."'";
		if(!mysqli_query($sqli,$sql))
			echo '1';
		else
			echo '0';
		*/
	}
	/*
	$sql = "select * from category where parent_id ='".$_POST["cate_id"]."'";
	$result = mysqli_query($sqli,$sql);
	for($i = 0 ; $i < $row = mysqli_fetch_array($result) ; ++$i){
		$list[$i] = $row ;
	}
	echo json_encode($list);
	*/
?>