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
		$sql = "INSERT INTO `recommend`(`rec_title`, `rec_content`, `start_date`, `end_date` ,`rec_item`) VALUES ('".mysqli_real_escape_string($sqli, trim($_POST["rec_title"]))."' , '".stripslashes($_POST["rec_content"])."' , '".$_POST["start_date"]."' , '".$_POST["end_date"]."', '".$_POST["rec_item"]."')";
		if(!mysqli_query($sqli,$sql)){
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="推荐新增失败!";
			header("Location: ../recommend.php");
		}
		else{
			$rec_id = mysqli_insert_id($sqli);
			$sub_name = explode(".",$_FILES["rec_cover"]["name"]);
			$folder_o = "../../update/recommend/";
			$folder_s = "../../update/recommend_s/";
			if(!is_dir($folder_o))
				mkdir($folder_o);
			if(!is_dir($folder_s))
				mkdir($folder_s);
			$new_name = $rec_id.".".$sub_name[(count($sub_name)-1)];
			move_uploaded_file($_FILES["rec_cover"]["tmp_name"], $folder_o.$new_name);
			resize_img($folder_o ,$folder_s , $new_name ,150 ,150 );
			$sql = "update recommend set rec_cover = '".$new_name."' where rec_id = ".$rec_id;
			if(!mysqli_query($sqli,$sql)){
				$_SESSION["errnumber"]=1;
				$_SESSION["msg"]="推荐新增失败!";
				header("Location: ../recommend.php");
			}
			else{
				header("Location: ../recommend.php");
			}
		}
	}
	else if($action == "edit"){
		$sql = "update recommend set rec_title = '".mysqli_real_escape_string($sqli, trim($_POST["rec_title"]))."' , rec_content = '".stripslashes($_POST["rec_content"])."' , start_date = '".$_POST["start_date"]."' , end_date = '".$_POST["end_date"]."', rec_item = '".$_POST["rec_item"]."' where rec_id = '".$_POST["rec_id"]."'";
		mysqli_query($sqli,$sql);
		if($_FILES["rec_cover"]["name"] != "" || $_FILES["rec_cover"]["name"] != null){
			$sub_name = explode(".",$_FILES["rec_cover"]["name"]);
			$folder_o = "../../update/recommend/";
			$folder_s = "../../update/recommend_s/";
			$new_name = $_POST["rec_id"].".".$sub_name[(count($sub_name)-1)];
			move_uploaded_file($_FILES["rec_cover"]["tmp_name"], $folder_o.$new_name);
			resize_img($folder_o ,$folder_s , $new_name ,150 ,150 );
			$sql = "update recommend set rec_cover = '".$new_name."' where rec_id = ".$_POST["rec_id"];
			mysqli_query($sqli,$sql);
		}
		header("Location: ../recommend.php");
	}
	else if($action == "get_rec"){
		$list = Array();
		$temp = Array();
		$rec_item = Array();
		$sql = "select * from recommend where rec_id = ".$_POST["rec_id"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
		$list = $row ;
		$rec_item = explode("|",$row["rec_item"]);
		for($i = 0 ;$i < count($rec_item);++$i){
			$sql = "select item_photo , item_id ,item_name from item where item_id =".$rec_item[$i];
			$result = mysqli_query($sqli,$sql);
			$row = mysqli_fetch_array($result);
			$photo_img = explode("|",$row["item_photo"]);
			$temp[$i] = Array( 'item_id' => $row["item_id"] , 'item_name' => $row["item_name"], 'item_photo' => $photo_img[0]);
		}
		$list += Array( 'item' => $temp);
		echo json_encode($list);
	}
?>