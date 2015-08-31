<?
	//ALTER TABLE category AUTO_INCREMENT =0
	include_once("../../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;

	if($action == "add"){
		$sql = "INSERT INTO brand(brand_name,  brand_introduce) VALUES ('".$_POST["brand_name_add"]."' , '".$_POST["brand_introduce_add"]."' )";
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
	}
	else if($action == "change_state"){
		if($_POST["state"]=="0")
			$sql = "update item set ".$_POST["this_type"]." = 1 where item_id = ".$_POST["item_id"];
		else if($_POST["state"]=="1")
			$sql = "update item set ".$_POST["this_type"]." = 0 where item_id = ".$_POST["item_id"];
		if(!mysqli_query($sqli,$sql))
			echo "1|";
		else
			echo "0|".$_POST["item_id"]."|".$_POST["this_type"];
	}
?>