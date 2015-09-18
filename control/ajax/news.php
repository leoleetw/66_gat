<?
	//ALTER TABLE category AUTO_INCREMENT =0
	include_once("../../include/dbinclude.php");
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
	
	if($action == "add"){
		$sql = "INSERT INTO `news`(`news_title`, `news_content`, `start_date`, `end_date`) VALUES ('".mysqli_real_escape_string($sqli, trim($_POST["news_title"]))."' , '".stripslashes($_POST["news_content"])."' , '".$_POST["start_date"]."' , '".$_POST["end_date"]."')";
		if(!mysqli_query($sqli,$sql)){
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="消息新增失败!";
			header("Location: ../news_manage.php");
		}
		else{
			$news_id = mysqli_insert_id($sqli);
			$sub_name = explode(".",$_FILES["news_cover"]["name"]);
			$folder_o = "../../update/news/";
			$folder_s = "../../update/news_s/";
			if(!is_dir($folder_o))
				mkdir($folder_o);
			if(!is_dir($folder_s))
				mkdir($folder_s);
			$new_name = $news_id.".".$sub_name[(count($sub_name)-1)];
			move_uploaded_file($_FILES["news_cover"]["tmp_name"], $folder_o.$new_name);
			resize_img($folder_o ,$folder_s , $new_name ,150 ,150 );
			$sql = "update news set news_cover = '".$new_name."' where news_id = ".$news_id;
			if(!mysqli_query($sqli,$sql)){
				$_SESSION["errnumber"]=1;
				$_SESSION["msg"]="消息新增失败!";
				header("Location: ../news_manage.php");
			}
			else{
				header("Location: ../news_manage.php");
			}
		}
	}
	else if($action == "edit"){
		$sql = "update news set news_title = '".mysqli_real_escape_string($sqli, trim($_POST["news_title"]))."' , news_content = '".stripslashes($_POST["news_content"])."' , start_date = '".$_POST["start_date"]."' , end_date = '".$_POST["end_date"]."' where news_id = '".$_POST["news_id"]."'";
		mysqli_query($sqli,$sql);
		if($_FILES["news_cover"]["name"] != "" || $_FILES["news_cover"]["name"] != null){
			$sub_name = explode(".",$_FILES["news_cover"]["name"]);
			$folder_o = "../../update/news/";
			$folder_s = "../../update/news_s/";
			$new_name = $_POST["news_id"].".".$sub_name[(count($sub_name)-1)];
			move_uploaded_file($_FILES["news_cover"]["tmp_name"], $folder_o.$new_name);
			resize_img($folder_o ,$folder_s , $new_name ,150 ,150 );
			$sql = "update news set news_cover = '".$new_name."' where news_id = ".$_POST["news_id"];
			mysqli_query($sqli,$sql);
		}
		header("Location: ../news_manage.php");
	}
	else if($action == "get_news"){
		$list = Array();
		$sql = "select * from news where news_id = ".$_POST["news_id"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
		$list = $row ;
		echo json_encode($list);
	}
?>