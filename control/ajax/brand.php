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
	else if($action == "remove_brand"){
		$sql = "select brand_logo from brand where brand_id=".$_POST["brand_id"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
		if($row["brand_logo"]!=""){
			unlink('../../update/brand/'.$row["brand_logo"]);
			unlink('../../update/brand_s/'.$row["brand_logo"]);
		}
			
		$sql = "delete from brand where brand_id=".$_POST["brand_id"];
		if(!mysqli_query($sqli,$sql))
			echo "1|";
		else
			echo "0|".$_POST["brand_id"];
	}
	else if($action == "remove_logo"){
		$sql = "select brand_logo from brand where brand_id=".$_POST["brand_id"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
		if($row["brand_logo"]!=""){
			unlink('../../update/brand/'.$row["brand_logo"]);
			unlink('../../update/brand_s/'.$row["brand_logo"]);
		}
			
		$sql = "update brand set brand_logo = '' where brand_id=".$_POST["brand_id"];
		if(!mysqli_query($sqli,$sql))
			echo "1|";
		else
			echo "0|".$_POST["brand_id"];
	}
	else if($action == "rename"){
		$sql = "update brand set ".$_POST["target"]." ='".$_POST["value"]."' where brand_id=".$_POST["brand_id"];
		if(!mysqli_query($sqli,$sql))
			echo "1|";
		else
			echo "0|".$_POST["brand_id"]."|".$_POST["target"]."|".$_POST["value"];
	}
	else if($action == "change_logo"){
		$sub_name = explode(".",$_FILES["add_file_img"]["name"]);
		$folder_o = "../../update/brand/";
		$folder_s = "../../update/brand_s/";
		if(!is_dir($folder_o))
			mkdir($folder_o);
		if(!is_dir($folder_s))
			mkdir($folder_s);
		$new_name = $_POST["brand_id"].".".$sub_name[(count($sub_name)-1)];
		move_uploaded_file($_FILES["add_file_img"]["tmp_name"], $folder_o.$new_name);
		resize_img($folder_o ,$folder_s , $new_name ,150 ,150 );
		$sql = "update brand set brand_logo = '".$new_name."' where brand_id = ".$_POST["brand_id"];
		if(!mysqli_query($sqli,$sql)){
			echo "1|";
		}
		else{
			echo "0|".$_POST["brand_id"]."|".$new_name;
		}
	}
?>