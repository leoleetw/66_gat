<?
	include_once("../../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == "login"){
		$sql = "select * from admin where admin_acc='".mysqli_real_escape_string($sqli, $_POST["acc"])."' AND admin_pwd='".encrypt($_POST["pwd"])."';";
		$result = mysqli_query($sqli,$sql);
		$rs_cn = mysqli_num_rows($result);
		$row = mysqli_fetch_array($result) ;
		if($rs_cn==0){
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="帐号密码资讯错误！！";
			$_SESSION["msg"]=$sql;
			header("Location: ../login.php");
		}
		else{
			$_SESSION["admin_id"]=$row["admin_id"];
			$sql = "update admin set login_time = login_time+1 , last_time = '".date("Y-m-d H:i:s")."' , last_ip = '".getip()."' where admin_id = ".$row["admin_id"];
			mysqli_query($sqli,$sql);
			header("Location: ../index.php");
		}
	}
	if($action == "log_out"){
		session_destroy();
		header("Location: ../index.php");
	}
?>