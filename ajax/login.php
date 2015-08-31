<?
	include_once("../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == "login"){
		if(strtolower($_SESSION['captcha']['code'])!=strtolower($_POST['captcha_code'])){
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="驗證碼錯誤！！";
			header("Location: ../login.php");
		}
		else{
			$_SESSION["user_id"]="";
			if($_SESSION["login_error_count"]=="")
				$_SESSION["login_error_count"]=0;
			else if($_SESSION["login_error_count"]==5)
				$_SESSION["login_error_count"]=0;
			$sql = "select * from user where email='".mysqli_real_escape_string($sqli, $_POST["user_email"])."' AND user_pwd='".md5(md5($_POST["user_pwd"]))."';";
			$result = mysqli_query($sqli,$sql);
			$rs_cn = mysqli_num_rows($result);
			$row = mysqli_fetch_array($result) ;
			if($rs_cn==0){
				$_SESSION["login_error_count"]+=1;
				$_SESSION["login_error_time"]=date("Y-m-d h:i:s");
				$_SESSION["errnumber"]=1;
				$_SESSION["msg"]="帐号密码资讯错误，当前错误次数 ".$_SESSION["login_error_count"]."，错误次数达到五次将暂停15分钟无法登入网站！！";
				$_SESSION["msg"]=$sql;
				header("Location: ../login.php");
			}
			else if($row["user_state"]==0){
				$_SESSION["errnumber"]=1;
				$_SESSION["msg"]="帐号尚未进行开通，请先至信箱收信！！";
				header("Location: ../login.php");
			}
			else if($row["user_state"]==9){
				$_SESSION["errnumber"]=1;
				$_SESSION["msg"]="帐号以被停权，如有疑问，请联络官方！！";
				header("Location: ../login.php");
			}
			else{
				$_SESSION["user_id"]=$row["user_id"];
				$_SESSION["user_name"]=$row["user_name"];
				$sql = "update user set login_time = login_time+1 , last_time = '".date("Y-m-d H:i:s")."' , last_ip = '".getip()."' where user_id = ".$row["user_id"];
				mysqli_query($sqli,$sql);
				header("Location: ../index.php");
			}
		}
	}
	if($action == "log_out"){
		session_destroy();
		header("Location: ../index.php");
	}
?>