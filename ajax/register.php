<?
	include_once("../include/dbinclude.php");
	header("Content-Type:text/html; charset=utf-8");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	
	if($action == "reg"){ //帐号注册
		$email = $_POST["email"];
		//再次验证帐号重复（修复重整）
		$sql = "select * from user where email='".mysqli_real_escape_string($sqli, $email)."'";
		$result = mysqli_query($sqli,$sql);
		$rs_cn = mysqli_num_rows($result);
		if($rs_cn != 0 ){
				$_SESSION["errnumber"]=1;
				$_SESSION["msg"]="已有相同信箱，请更换过後在重新注册";
				header("Location: ../index.php");
		}
		else{
			$updatedate = date("Y-m-d H:i:s");
			$sql = "INSERT INTO user ( user_state, email, user_name , user_nick, user_pwd, user_sex, user_birthday, reg_time) 
			VALUES ( '0' , '".$email."' , '".mysqli_real_escape_string($sqli,$_POST["user_name"])."' , '".mysqli_real_escape_string($sqli,$_POST["user_nick"])."' ,'".md5(md5($_POST["pwd"]))."','".$_POST["sex"]."','".$_POST["birth_y"]."-".$_POST["birth_m"]."-".$_POST["birth_d"]."','".$updatedate."')";
			if(!mysqli_query($sqli,$sql)){
				$_SESSION["errnumber"]=1;
				$_SESSION["msg"]="注册帐号失败！";
				header("Location: ../index.php");
			}
			else{
				$user_id = mysqli_insert_id($sqli);		
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
				
				
				$mail->AddAddress($email,$name);
				$mail->AddReplyTo($webmaster_email,"Squall.f");
				//這不用改
				
				$mail->WordWrap = 50;
				//每50行斷一次行
				
				//$mail->AddAttachment("/XXX.rar");
				// 附加檔案可以用這種語法(記得把上一行的//去掉)
				
				$mail->IsHTML(true); // send as HTML
				
				$content = "亲爱的会员您好︰<br/><br/>";
				$content .= "欢迎加入宝玉石网，请点击以下网址进行开通，如果该网址没有出现连结，则请自行复制贴到网址列上<br/><br/>";
				$content .= "http://220.134.32.90/66_gat/ajax/register.php?action=verify&uid=".$user_id."";
				
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
				else{
					$_SESSION["errnumber"]=1;
					$_SESSION["msg"]="注册完毕，请先至信箱收信开启认证！！";
					header("Location: ../index.php");
				}
			}
		}
	}
	if($action == "check"){ // 判定重复帐号
		$target = $_POST["target"];
		$value = $_POST["value"];
		$sql = "select * from user where ".$target."='".mysqli_real_escape_string($sqli, $value)."'";
		$result = mysqli_query($sqli,$sql);
		$rs_cn = mysqli_num_rows($result);
		echo $rs_cn."|".$target;
	}
	if($action == "verify"){ // 帐号注册邮件开通
		$sql = "select * from user where user_id='".mysqli_real_escape_string($sqli, $_GET["uid"])."';";
		$result = mysqli_query($sqli,$sql);
		$rs_cn = mysqli_num_rows($result);
		if($rs_cn!=1){
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="帐号资讯发生问题，请提交email至官方网站获得帮助";
			header("Location: ../index.php");
		}
		else{
			$row = mysqli_fetch_array($result) ;
			if($row["user_state"]!=0){
				$_SESSION["errnumber"]=1;
				$_SESSION["msg"]="此帐号以获得会员开通资格，请勿重复点击网址";
				header("Location: ../index.php");
			}
			else{
				$sql = "update user set user_state=1 where user_id='".$_GET["uid"]."';";
				if(!mysqli_query($sqli,$sql)){
					$_SESSION["errnumber"]=1;
					$_SESSION["msg"]="会员帐号资格开通失败，请提交email至官方网站获得帮助";
					header("Location: ../index.php");
				}
				else{
					$_SESSION["errnumber"]=1;
					$_SESSION["msg"]="恭喜您，会员资格开通成功，请重新登入";
					header("Location: ../index.php");
				}
			}
		}
	}
?>