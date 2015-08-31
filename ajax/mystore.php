<?
	include_once("../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == "apply_store"){
		$now = date("Y-m-d H:i:s");
		$folder = "../update/store_apply/";
		if(!is_dir($folder))
				mkdir($folder);
		$sql = "select * from store_apply where user_id = '".$_SESSION["user_id"]."'";
		$result = mysqli_query($sqli,$sql);
		$rs_cn = mysqli_num_rows($result);
		if($rs_cn == 0){
			$sql = "INSERT INTO store_apply(user_id, sa_state, apply_date)
			 VALUES ('".$_SESSION["user_id"]."' , 0 ,'".$now."')";
			mysqli_query($sqli,$sql);
			$sa_id = mysqli_insert_id($sqli);
		}
		else{
			$row = mysqli_fetch_array($result);
			$sql = "update store_apply set sa_state = 0 , apply_date='".$now."' where sa_id = '".$row["sa_id"]."'";
			mysqli_query($sqli,$sql);
			$sa_id = $row["sa_id"];
		}
		$sa_photo = "";	
		for($i = 0 , $n = 0 ; $i < intval($_POST["apply_store_count"]) ; ++$i){
			if($_FILES["apply_store_file"]["name"][$i]){
				$sub_name = explode(".",$_FILES["apply_store_count"]["name"][$i]);
				$new_name = $sa_id."_".$n.".".$sub_name[(count($sub_name)-1)];
				move_uploaded_file($_FILES["apply_store_count"]["tmp_name"][$i], $folder.$new_name);
				if($sa_photo == "")
					$sa_photo .= $new_name;
				else
					$sa_photo .= "|".$new_name;
			}
		}
		if($sa_photo != ""){
			$sql = "update store_apply set sa_photo ='".$sa_photo."' where sa_id = '".$sa_id."'";
			mysqli_query($sqli,$sql);
		}
		$_SESSION["errnumber"]=1;
		$_SESSION["msg"]="店家申请审核中，请稍後一段时间！！";
		header("Location: ../my.php");
	}
	else if($action == "creat_store"){
		$sql = "select store_id from store where user_id ='".$_SESSION["user_id"]."'";
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
		$store_id = $row["store_id"];
		$sql = "update store set store_name = '".mysqli_real_escape_string($sqli, trim($_POST["creat_store_name"]))."' , store_introduce = '".mysqli_real_escape_string($sqli, trim($_POST["creat_store_introduce"]))."' where store_id = '".$store_id."'";
		mysqli_query($sqli,$sql);
		$folder = "../update/store/";
		if(!is_dir($folder))
				mkdir($folder);
		if($_FILES["creat_store_logo"]["name"]){
			$sub_name = explode(".",$_FILES["creat_store_logo"]["name"]);
			$new_name = $store_id.".".$sub_name[(count($sub_name)-1)];
			move_uploaded_file($_FILES["creat_store_logo"]["tmp_name"], $folder.$new_name);
			$sql = "update store set store_logo ='".$new_name."' where store_id = '".$store_id."'";
			mysqli_query($sqli,$sql);
		}
		header("Location: ../mystore.php");
	}
	else if($action == "XXX"){
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
?>