<?
	include_once("../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == "get_subcate"){
		$list = Array();
		$sql = "select * from category where parent_id ='".$_POST["cate_id"]."' and is_show = 0";
		$result = mysqli_query($sqli,$sql);
		for($i = 0 ; $i < $row = mysqli_fetch_array($result) ; ++$i){
			$list[$i] = $row ;
		}
		echo json_encode($list);
	}
?>