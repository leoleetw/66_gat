<?
	//ALTER TABLE category AUTO_INCREMENT =0
	include_once("../../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == "add"){
		$sql = "INSERT INTO category( cate_name, parent_id, rank, is_show) VALUES ('".$_POST["add_name"]."' , '".$_POST["parent_id"]."' , '".$_POST["rank"]."' , 0)";
		if(!mysqli_query($sqli,$sql))
			echo "1|error";
		else{
			$cate_id = mysqli_insert_id($sqli);
			echo '0|'.$_POST["rank"]."|".$cate_id.'|'.$_POST["add_name"];
		}
	}
	else if($action == "gat_cate"){
		$list = Array();
		$temp = Array();
		$sql = "select * from category where cate_id = ".$_POST["cate_id"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
		$list = $row;
		$sql = "select * from category where parent_id = ".$_POST["cate_id"]." AND rank = ".$_POST["rank"];
		$result = mysqli_query($sqli,$sql);
		for($i=0;$i < $row = mysqli_fetch_array($result) ; ++$i){
			$temp[$i] = $row;
		}
		$list += Array('cate' => $temp);
		echo json_encode($list);
	}
	else if($action == "rename"){
		$sql = "update category set cate_name ='".$_POST["new_name"]."' where cate_id=".$_POST["cate_id"];
		if(!mysqli_query($sqli,$sql))
			echo "1|";
		else
			echo "0|".$_POST["cate_id"]."|".$_POST["new_name"];
	}
	else if($action == "change_state"){
		$sql = "select * from category where cate_id=".$_POST["cate_id"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
		$is_show = $row["is_show"]; 
		if($is_show=='0')
			$sql = "update category set is_show = 1 where cate_id=".$_POST["cate_id"];
		else
			$sql = "update category set is_show = 0 where cate_id=".$_POST["cate_id"];
		if(!mysqli_query($sqli,$sql))
			echo "1|";
		else
			if($is_show == '0')
				echo "0|".$_POST["cate_id"]."|1";
			else
				echo "0|".$_POST["cate_id"]."|0";
		
	}
?>