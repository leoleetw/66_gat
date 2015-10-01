<?
	include_once("../include/dbinclude.php");
	
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	function resize_img($floder_o ,$floder_s , $filename ,$max_width ,$max_height ){
		if($max_width == '')
			$max_width = 100;
		if($max_height == '')
			$max_height = 100;
		list($width,$height,$type,$attr)=getimagesize($floder_o.$filename);
		
		if($width > $max_width || $height > $max_height){//做縮圖
			if($width > $max_width){
				$proportion = $max_width/$width;
				$new_width = $max_width;
				$new_height = $height*$proportion;
				$thumb = imagecreatetruecolor($new_width, $new_height);
				switch ($type) {
	        case 1: $source = imagecreatefromgif($floder_o.$filename); break;
	        case 2: $source = imagecreatefromjpeg($floder_o.$filename);  break;
	        case 3: 
	        	$source = imagecreatefrompng($floder_o.$filename);
	        	$c=imagecolorallocatealpha($thumb , 0 , 0 , 0 ,127);//拾取一個完全透明的顏色
						imagealphablending($thumb ,false);//關閉混合模式，以便透明顏色能覆蓋原畫布
						imagefill($thumb , 0 , 0, $c);//填充
						imagesavealpha($thumb ,true); 
	        	break;
	        default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
	      }
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				switch ($type) {
	        case 1: imagegif($thumb,$floder_s.$filename); break;
	        case 2: imagejpeg($thumb,$floder_s.$filename , 100);  break;
	        case 3: imagepng($thumb,$floder_s.$filename); break;
	        default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
	      }
				list($width,$height,$type,$attr)=getimagesize($floder_s.$filename);
				if($height > $max_height){
					$proportion = $max_height/$height;
					$new_height = $max_height;
					$new_width = $width*$proportion;
					$thumb = imagecreatetruecolor($new_width, $new_height);
					switch ($type) {
		        case 1:	$source = imagecreatefromgif($floder_s.$filename); 	break;
		        case 2: $source = imagecreatefromjpeg($floder_s.$filename);  break;
		        case 3: 
		        	$source = imagecreatefrompng($floder_s.$filename);
		        	$c=imagecolorallocatealpha($thumb , 0 , 0 , 0 ,127);
							imagealphablending($thumb ,false);
							imagefill($thumb , 0 , 0, $c);
							imagesavealpha($thumb ,true); 
		        	break;
		        default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
		      }
					imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					switch ($type) {
		        case 1: imagegif($thumb,$floder_s.$filename); break;
		        case 2: imagejpeg($thumb,$floder_s.$filename , 100);  break;
		        case 3: imagepng($thumb,$floder_s.$filename); break;
		        default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
		      }
				}
			}
			else if($height > $max_height){
				$proportion = $max_height/$height;
				$new_height = $max_height;
				$new_width = $width*$proportion;
				$thumb = imagecreatetruecolor($new_width, $new_height);
				switch ($type) {
	        case 1:	$source = imagecreatefromgif($floder_o.$filename);	break;
	        case 2: $source = imagecreatefromjpeg($floder_o.$filename);  break;
	        case 3: 
	        $source = imagecreatefrompng($floder_o.$filename); 
	        $c=imagecolorallocatealpha($thumb , 0 , 0 , 0 ,127);
					imagealphablending($thumb ,false);
					imagefill($thumb , 0 , 0, $c);
					imagesavealpha($thumb ,true);
	        break;
	        default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
	      }
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				switch ($type) {
	        case 1: imagegif($thumb,$floder_s.$filename); break;
	        case 2: imagejpeg($thumb,$floder_s.$filename , 100);  break;
	        case 3: imagepng($thumb,$floder_s.$filename); break;
	        default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
	      }
			}
		}
		else{//直接複製
			copy($floder_o.$filename, $floder_s.$filename);
		}
		return true;
	}
	
	if($action == "add_item"){
		$folder_o = "../update/item/";
		$folder_s = "../update/item_s/";
		if(!is_dir($folder_o))
			mkdir($folder_o);
		if(!is_dir($folder_s))
			mkdir($folder_s);
		$sql = "select store_id from store where user_id ='".$_SESSION["user_id"]."'";
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
		$store_id = $row["store_id"];
		$sql = "INSERT INTO item(item_name, item_stock, item_price, item_size, item_origin, item_weight, package_size, item_note, item_html, store_id, brand_id, cate_id)
		 values ('".mysqli_real_escape_string($sqli, trim($_POST["item_name"]))."' , ".trim($_POST["item_stock"]).", ".trim($_POST["item_price"])." , '".mysqli_real_escape_string($sqli, trim($_POST["item_size"]))."' 
		 , '".mysqli_real_escape_string($sqli, trim($_POST["item_origin"]))."', '".mysqli_real_escape_string($sqli, trim($_POST["item_weight"]))."', '".mysqli_real_escape_string($sqli, trim($_POST["package_size"]))."' 
		 , '".mysqli_real_escape_string($sqli, trim($_POST["item_note"]))."', '".stripslashes($_POST['item_html'])."', '".$store_id."', '".trim($_POST["item_brand"])."' ";
		if($_POST["item_subcate"]!="" && $_POST["item_subcate"]!=null)
			$sql .= ", '".$_POST["item_subcate"]."'";
		else
			$sql .= ", '".$_POST["item_cate"]."'";
		$sql .= ")";
		if(!mysqli_query($sqli,$sql)){
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="新增商品失败";
			header("Location: ../mystore_item.php?action=add");
		}
		else{
			$item_id = mysqli_insert_id($sqli);
			$item_photo = "";
			for($i = 0 , $n = 1 ; $i < intval($_POST["item_photo_count"]) ; ++$i){
				if($_FILES["item_photo"]["name"][$i]){
					$sub_name = explode(".",$_FILES["item_photo"]["name"][$i]);
					$new_name = $item_id."_".$n.".".$sub_name[(count($sub_name)-1)];
					move_uploaded_file($_FILES["item_photo"]["tmp_name"][$i], $folder_o.$new_name);
					resize_img($folder_o ,$folder_s , $new_name ,400 ,400 );
					if($item_photo == "")
						$item_photo .= $new_name;
					else
						$item_photo .= "|".$new_name;
					$n++;
				}
			}
			$sql = "update item set item_photo ='".$item_photo."' where item_id='".$item_id."'";
			mysqli_query($sqli,$sql);
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="新增商品完成";
			header("Location: ../mystore_item.php?action=add");
			
		}
	}
	if($action == "edit_item"){
	  $folder_o = "../update/item/";
		$folder_s = "../update/item_s/";
		$item_id = $_POST["item_id"];
		$sql = "update item set item_state = 0 ,item_name = '".mysqli_real_escape_string($sqli, trim($_POST["item_name"]))."', item_stock = ".trim($_POST["item_stock"]).", item_price = ".trim($_POST["item_price"])."
		, item_size = '".mysqli_real_escape_string($sqli, trim($_POST["item_size"]))."', item_origin = '".mysqli_real_escape_string($sqli, trim($_POST["item_origin"]))."', item_weight = '".mysqli_real_escape_string($sqli, trim($_POST["item_weight"]))."'
		, package_size = '".mysqli_real_escape_string($sqli, trim($_POST["package_size"]))."', item_note = '".mysqli_real_escape_string($sqli, trim($_POST["item_note"]))."', item_html = '".stripslashes($_POST['item_html'])."', brand_id = '".trim($_POST["item_brand"])."', cate_id = ";
		if($_POST["item_subcate"]!="" && $_POST["item_subcate"]!=null)
			$sql .= " '".$_POST["item_subcate"]."'";
		else
			$sql .= " '".$_POST["item_cate"]."'";
		$sql .= " where item_id = ".$item_id;
		if(!mysqli_query($sqli,$sql))
			echo "编辑商品失败";
		else{
			$sql = "select item_photo from item where item_id = ".$item_id;
			$result = mysqli_query($sqli,$sql);
			$row = mysqli_fetch_array($result);
			$photo = explode("|",$row["item_photo"]);
			for($i = 0 ; $i < count($photo) ; ++$i){
				if($_FILES["item_photo"]["name"][$i]){
					$sub_name = explode(".",$_FILES["item_photo"]["name"][$i]);
					$new_name = $item_id."_".($i+1).".".$sub_name[(count($sub_name)-1)];
					move_uploaded_file($_FILES["item_photo"]["tmp_name"][$i], $folder_o.$new_name);
					resize_img($folder_o ,$folder_s , $new_name ,400 ,400 );
					$photo[$i] = $new_name;
				}
			}
			$item_photo = implode("|", $photo);
			for($i = count($photo) , $n = (count($photo)+1) ; $i < intval($_POST["item_photo_count"]) ; ++$i){
				if($_FILES["item_photo"]["name"][$i]){
					$sub_name = explode(".",$_FILES["item_photo"]["name"][$i]);
					$new_name = $item_id."_".$n.".".$sub_name[(count($sub_name)-1)];
					move_uploaded_file($_FILES["item_photo"]["tmp_name"][$i], $folder_o.$new_name);
					resize_img($folder_o ,$folder_s , $new_name ,400 ,400 );
					if($item_photo == "")
						$item_photo .= $new_name;
					else
						$item_photo .= "|".$new_name;
					$n++;
				}
			}
			$sql = "update item set item_photo ='".$item_photo."' where item_id='".$item_id."'";
			mysqli_query($sqli,$sql);
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="编辑商品完成";
			header("Location: ../mystore_item.php?action=depot");
			
		}
	}
	else if($action == "out_shelves"){
		$sql = "update item set item_state = 0 where item_id =".$_POST["item_id"];
		if(!mysqli_query($sqli,$sql))
			echo "1|";
		else
			echo "0|".$_POST["item_id"];
	}
	else if($action == "on_shelves"){
		$now = date("Y-m-d H:i:s");
		$sql = "update item set item_state = 1 , shelves_date = '".$now."' where item_id =".$_POST["item_id"];
		if(!mysqli_query($sqli,$sql))
			echo "1|";
		else
			echo "0|".$_POST["item_id"];
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
	else if($action == "collect"){
		$sql = "INSERT INTO collect(user_id, item_id, store_id) VALUES ('".$_SESSION["user_id"]."' , '".$_POST["item_id"]."', '".$_POST["store_id"]."')";
		if(!mysqli_query($sqli,$sql))
			echo "1|";
		else
			echo "0|".$_POST["item_id"];
		
	}
	else if($action == "remove_collect"){
		$sql = "delete from collect where item_id = '".$_POST["item_id"]."' AND user_id ='".$_SESSION["user_id"]."' ";
		if(!mysqli_query($sqli,$sql))
			echo "1|";
		else
			echo "0|".$_POST["item_id"];
		
	}
	else if($action == "remove_collect_all"){
		$sql = "delete from collect where user_id ='".$_SESSION["user_id"]."' ";
		if(!mysqli_query($sqli,$sql))
			echo "1|";
		else
			echo "0|";
		
	}
	else if($action == "qa"){
		if(strtolower($_SESSION['captcha']['code'])!=strtolower($_POST['captcha_code'])){
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="验证码错误！！";
			header("Location: ../item_info.php?item_id=".$_POST["item_id"]);
		}
		else{
			$now = date("Y-m-d H:i:s");
			$sql = "INSERT INTO qa( item_id, qa_type, user_id, q_content, q_creatdate) VALUES ('".$_POST["item_id"]."' , '".$_POST["qa_type"]."' , '".$_SESSION["user_id"]."', '".mysqli_real_escape_string($sqli, trim($_POST["qa_content"]))."', '".$now."')";
			if(!mysqli_query($sqli,$sql)){
				$_SESSION["errnumber"]=1;
				$_SESSION["msg"]="问题提问失败！！";
				header("Location: ../item_info.php?item_id=".$_POST["item_id"]);
			}
			else{
				$qa_id = mysqli_insert_id($sqli);
				$sql = "select b.user_nick , c.item_name , d.user_id from qa a 
				inner join item c on c.item_id = a.item_id 
				left join user b on a.user_id = b.user_id 
				left join store d on d.store_id = c.store_id 
				where a.qa_id = ".$qa_id;
				$result = mysqli_query($sqli,$sql);
				$row = mysqli_fetch_array($result);
				$msg = "使用者 ".$row["user_nick"]." 在您的商品 ".$row["item_name"]." 上提出问题，赶紧帮助他解决疑惑吧";
				$url = "mystore_recode.php";
				send_msg('system' , $row['user_id'], $msg, $url , 1 );
				$_SESSION["errnumber"]=1;
				$_SESSION["msg"]="成功提问问题！！";
				header("Location: ../item_info.php?item_id=".$_POST["item_id"]);
			}
		}
	}
	else if($action == "reply_qa"){
		$now = date("Y-m-d H:i:s");
		$sql = "select * from qa where qa_id = ".$_POST["qa_id"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
		$edit_state = false;
		if($row["a_creatdate"]=='0000-00-00 00:00:00'){
			$sql = "update qa set a_content = '".mysqli_real_escape_string($sqli, trim($_POST["a_content"]))."' , a_creatdate = '".$now."' where qa_id = '".$_POST["qa_id"]."'";
			$edit_state = true;
		}
		else
			$sql = "update qa set a_content = '".mysqli_real_escape_string($sqli, trim($_POST["a_content"]))."' , a_editdate = '".$now."' where qa_id = '".$_POST["qa_id"]."'";
		if(!mysqli_query($sqli,$sql))
			echo "1|";
		else{
			$sql = "select a.user_id ,c.store_name , b.item_name from qa a 
			inner join item b on a.item_id = b.item_id 
			left join store c on c.store_id = b.store_id 
			where a.qa_id = '".$_POST["qa_id"]."'";
			$result = mysqli_query($sqli,$sql);
			$row = mysqli_fetch_array($result);
			if(!$edit_state)
				$msg = "您向 ".$row["store_name"]." 店家的 ".$row["item_name"]." 商品发问的问题 对方已经给予回应罗，赶紧过去查看";
			else
				$msg = "您向 ".$row["store_name"]." 店家的 ".$row["item_name"]." 商品发问的问题 对方已经编辑回应罗，赶紧过去查看";
			$url = "my_recode.php";
			send_msg('system' , $row['user_id'], $msg, $url , 0);
			echo "0|";
		}
	}
?>