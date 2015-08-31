<?
	include_once("../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == "get_mobile"){
		$sql = "select * from user_attest where user_id = '".$_SESSION["user_id"]."'";
		$result = mysqli_query($sqli,$sql);
		$rs_cn = mysqli_num_rows($result);
		$sql = "update user set mobile = '".$_POST["mobile"]."' where user_id = '".$_SESSION["user_id"]."'";
		mysqli_query($sqli,$sql);
		$authentication = RandomString(5);
		$creat_date = date("Y-m-d H:i:s");
		$expired_date = date("Y-m-d H:i:s",strtotime("$creat_date +15 minutes"));
		if($rs_cn == 0){
			$sql = "INSERT INTO user_attest(user_id, mobile_auth, mobile_creat, mobile_expired) VALUES 
			('".$_POST["mobile"]."','".$authentication."','".$creat_date."','".$expired_date."')";
			if(!mysqli_query($sqli,$sql))
				echo "1|";
			else
				echo "0|".$authentication."|".$expired_date;
		}
		else{
			$row = mysqli_fetch_array($result);
			$sql = "update user_attest set mobile_auth='".$authentication."' , mobile_creat='".$creat_date."' , mobile_expired='".$expired_date."' where user_id = '".$_SESSION["user_id"]."'" ;
			if(!mysqli_query($sqli,$sql))
				echo "1|";
			else
				echo "0|".$authentication."|".$expired_date;
		}
	}
	else if($action == "mobile"){
		$now = date("Y-m-d H:i:s");
		$sql = "select b.* from user_attest b , user a  where a.user_id = b.user_id AND a.user_id='".$_SESSION["user_id"]."' AND b.mobile_auth = '".$_POST["mobile_attest"]."' AND (b.mobile_creat <= '".$now."' AND b.mobile_expired >= '".$now."')";
		$result = mysqli_query($sqli,$sql);
		$rs_cn = mysqli_num_rows($result);
		if($rs_cn == 0){
			$sql = "select * from user_attest where user_id = '".$_SESSION["user_id"]."'";
			$result = mysqli_query($sqli,$sql);
			$rs_cn = mysqli_num_rows($result);
			if($rs_cn == 0)
				$sql = "insert into user_attest (user_id , mobile_attest ) values ('".$_SESSION["user_id"]."' , 2)";
			else
				$sql = "update user_attest set mobile_attest = 2 where user_id = '".$_SESSION["user_id"]."'";
			mysqli_query($sqli,$sql);
			
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="错误的手机认证资讯！！";
			header("Location: ../attest.php");
		}
		else{
			$sql = "update user set user_attest = user_attest + 2 where user_id = '".$_SESSION["user_id"]."'";
			mysqli_query($sqli,$sql);
			$sql = "select * from user_attest where user_id = '".$_SESSION["user_id"]."'";
			$result = mysqli_query($sqli,$sql);
			$rs_cn = mysqli_num_rows($result);
			if($rs_cn == 0)
				$sql = "insert into user_attest (user_id , mobile_attest ) values ('".$_SESSION["user_id"]."' , 1)";
			else
				$sql = "update user_attest set mobile_attest = 1 where user_id = '".$_SESSION["user_id"]."'";
			mysqli_query($sqli,$sql);
			header("Location: ../attest.php");
		}
	}
	else if($action == "name"){
		$now = date("Y-m-d H:i:s");
		$folder = "../update/attest/";
		if(!is_dir($folder))
				mkdir($folder);
		$sub_name = explode(".",$_FILES["name_img"]["name"]);
		$new_name = "name".$_SESSION["user_id"].".".$sub_name[(count($sub_name)-1)];
		move_uploaded_file($_FILES["name_img"]["tmp_name"], $folder.$new_name);
		$sql = "select * from user_attest where user_id = '".$_SESSION["user_id"]."'";
		$result = mysqli_query($sqli,$sql);
		$rs_cn = mysqli_num_rows($result);
		if($rs_cn == 0)
			$sql = "insert into user_attest (user_id , name_attest , name_photo , apply_date ) values ('".$_SESSION["user_id"]."' , 0 , '".$new_name."' , '".$now."' )";
		else
			$sql = "update user_attest set name_attest = 0 , name_photo = '".$new_name."' , apply_date = '".$now."'  where user_id = '".$_SESSION["user_id"]."'";
		mysqli_query($sqli,$sql);
		header("Location: ../attest.php");
	}
	else if($action == "bank"){
		$now = date("Y-m-d H:i:s");
		$folder = "../update/attest/";
		if(!is_dir($folder))
				mkdir($folder);
		$sub_name = explode(".",$_FILES["bank_img"]["name"]);
		$new_name = "bank".$_SESSION["user_id"].".".$sub_name[(count($sub_name)-1)];
		move_uploaded_file($_FILES["bank_img"]["tmp_name"], $folder.$new_name);
		$sql = "select * from user_attest where user_id = '".$_SESSION["user_id"]."'";
		$result = mysqli_query($sqli,$sql);
		$rs_cn = mysqli_num_rows($result);
		if($rs_cn == 0)
			$sql = "insert into user_attest (user_id , bank_attest , bank_photo , apply_date ) values ('".$_SESSION["user_id"]."' , 0 , '".$new_name."' , '".$now."' )";
		else
			$sql = "update user_attest set bank_attest = 0 , bank_photo = '".$new_name."' , apply_date = '".$now."'  where user_id = '".$_SESSION["user_id"]."'";
		mysqli_query($sqli,$sql);
		header("Location: ../attest.php");
	}
	if($action == "XXX"){
		session_destroy();
		header("Location: ../attest.php");
	}
?>