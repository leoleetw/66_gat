<?
	//ALTER TABLE category AUTO_INCREMENT =0
	include_once("../../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	
	if($action == "check"){
		$sql = "select name_attest , bank_attest from user_attest where user_id = '".$_POST["user_id"]."'";
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result) ;
		$name_attest = $row["name_attest"];
		$bank_attest = $row["bank_attest"];
		$now = date("Y-m-d H:i:s");
		if($_POST["result"]=='pass'){
			$sql = "update user_attest set ".$_POST["subject"]."_attest = 1 , check_date = '".$now."' where user_id = '".$_POST["user_id"]."'";
			if($_POST["subject"] == 'name'){
				if((intval($name_attest)&1)==false)
					$sql1 = "update user set user_attest = user_attest +1 where user_id ='".$_POST["user_id"]."'";
			}
			else if($_POST["subject"] == 'bank')
				if((intval($name_attest)&4)==false)
					$sql1 = "update user set user_attest = user_attest +4 where user_id ='".$_POST["user_id"]."'";
		}
		else if($_POST["result"]=='fail'){
			$sql = "update user_attest set ".$_POST["subject"]."_attest = 2 , check_date = '".$now."' where user_id = '".$_POST["user_id"]."'";
			if($_POST["subject"] == 'name'){
				if((intval($name_attest)&1)==true)
					$sql1 = "update user set user_attest = user_attest -1 where user_id ='".$_POST["user_id"]."'";
			}
			else if($_POST["subject"] == 'bank')
				if((intval($name_attest)&4)==true)
					$sql1 = "update user set user_attest = user_attest -4 where user_id ='".$_POST["user_id"]."'";
		}
		mysqli_query($sqli,$sql);
		mysqli_query($sqli,$sql1);
		//echo $sql;
		echo "0|".$_POST["subject"]."|".$_POST["user_id"]."|".$_POST["result"] ; 
		/*
		if(!mysqli_query($sqli,$sql)){
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="品牌新增失败!";
			header("Location: ../brand_manage.php");
		}
		else{
			$sub_name = explode(".",$_FILES["logo_add"]["name"]);
			$brand_id = mysqli_insert_id($sqli);
			$folder_o = "../../update/brand/";
			$folder_s = "../../update/brand_s/";
			if(!is_dir($folder_o))
				mkdir($folder_o);
			if(!is_dir($folder_s))
				mkdir($folder_s);
			$new_name = $brand_id.".".$sub_name[(count($sub_name)-1)];
			move_uploaded_file($_FILES["logo_add"]["tmp_name"], $folder_o.$new_name);
			resize_img($folder_o ,$folder_s , $new_name ,150 ,150 );
			$sql = "update brand set brand_logo = '".$new_name."' where brand_id = ".$brand_id;
			if(!mysqli_query($sqli,$sql)){
				$_SESSION["errnumber"]=1;
				$_SESSION["msg"]="品牌新增失败!";
				header("Location: ../brand_manage.php");
			}
			else{
				header("Location: ../brand_manage.php");
			}
		}
		*/
	}
?>