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
		$sql = "update user set user_nick = '".mysqli_real_escape_string($sqli, $_POST["user_nick"])."',user_sex = '".$_POST["user_sex"]."',user_birthday = '".$_POST["birth_y"]."-".$_POST["birth_m"]."-".$_POST["birth_d"]."' 
		,user_addr = '".mysqli_real_escape_string($sqli, $_POST["user_addr"])."' ,city_code = '".$_POST["city_code"]."' where user_id = '".$_SESSION["user_id"]."'";
		$_SESSION["user_nick"] = $_POST["user_nick"];
		if(!mysqli_query($sqli,$sql))
			echo '1';
		else{
			$_SESSION["user_nick"]=$_POST["user_nick"];
			echo '0';
		}
	}
	else if($action == "change_email"){
		$sql = "update user set email = '".mysqli_real_escape_string($sqli, $_POST["change_email"])."' , user_state = 0 where user_id = '".$_SESSION["user_id"]."'";
		if(!mysqli_query($sqli,$sql)){
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="信箱变更错误";
			header("Location: ../my_setting.php");
		}
		else{
			require("../include/js/mailer/class.phpmailer.php");
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPAuth = true; // turn on SMTP authentication
			$mail->CharSet = "utf-8"; 
			//這幾行是必須的
			
			$mail->Username = 'papcada1.clayart@gmail.com'; //
			$mail->Password = 'Q92001532'; //
			//這邊是你的gmail帳號和密碼
			
			$mail->FromName = "宝玉石网";
			// 寄件者名稱(你自己要顯示的名稱)
			$webmaster_email = 'papcada1.clayart@gmail.com'; 
			//回覆信件至此信箱
			
			
			//$email="papcada1.clayart@gmail.com"; //papcada.clayart@yahoo.com.tw
			// 收件者信箱
			$name=$_POST["user_name"];
			// 收件者的名稱or暱稱
			$mail->From = $webmaster_email;
			
			
			$mail->AddAddress($_POST["change_email"],$_POST["email_user_nick"]);
			$mail->AddReplyTo($webmaster_email,"Squall.f");
			//這不用改
			
			$mail->WordWrap = 50;
			//每50行斷一次行
			
			//$mail->AddAttachment("/XXX.rar");
			// 附加檔案可以用這種語法(記得把上一行的//去掉)
			
			$mail->IsHTML(true); // send as HTML
			
			$content = "亲爱的会员您好︰<br/><br/>";
			$content .= "因变更信箱後需要重新验证开通，请点击以下网址进行开通，如果该网址没有出现连结，则请自行复制贴到网址列上<br/><br/>";
			$content .= "http://220.134.32.90/66_gat/ajax/register.php?action=verify&uid=".$_SESSION["user_id"]."";
			
			$mail->Subject = "宝玉石网-帐号开通"; 
			// 信件標題
			$mail->Body = $content;
			//信件內容(html版，就是可以有html標籤的如粗體、斜體之類)
			$mail->AltBody = $content; 
			//信件內容(純文字版)
			
			if(!$mail->Send()){
				$sql = "delete from user where u_id='".$user_id."'";
				//mysqli_query($sqli,$sql);
				echo "1|注册验证信件發生錯誤：" . $mail->ErrorInfo;
				//如果有錯誤會印出原因
			}
			session_destroy();
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="信箱变更成功，请重新登入";
			header("Location: ../login.php");
		}
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