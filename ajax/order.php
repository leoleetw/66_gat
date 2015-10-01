<?
	include_once("../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == "creat_order"){
		$now = date("Y-m-d H:i:s");
		$error = false;
		$cart = json_decode( $_COOKIE["cart"] );
		$cart_indexof = -1;
		for($i = 0 ; $i < count($cart) ; ++$i){
			if($cart[$i]->store_id == $_POST['store_id'])
				$cart_indexof = $i;
		}
		// transactions
		$sqli->autocommit(FALSE);
    //$sqli->beginTransaction();
    for($i = 0 ; $i < count($cart[$cart_indexof]->item) ; ++$i){
    	$sql = "select item_stock from item where item_id =".$cart[$cart_indexof]->item[$i];
    	$result = $sqli->query($sql);
			$row = $result->fetch_array();
			if($row["item_stock"] < $_POST["cart_item_count".$cart[$cart_indexof]->item[$i]])
				$error = true;
			else{
				if($row["item_stock"] == $_POST["cart_item_count".$cart[$cart_indexof]->item[$i]])
					$sql = "update item set item_stock = item_stock - ".$_POST["cart_item_count".$cart[$cart_indexof]->item[$i]]." , item_state = 0 where item_id =".$cart[$cart_indexof]->item[$i];
				else
					$sql = "update item set item_stock = item_stock - ".$_POST["cart_item_count".$cart[$cart_indexof]->item[$i]]." where item_id =".$cart[$cart_indexof]->item[$i];
				$sqli->query($sql);
			}
		}
		if($error == true){ //失败
			$sqli->rollback();
			$sqli->autocommit(TRUE);
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="商品库存不足，请重新选择！！";
			header("Location: ../cart.php");
		}
		else{ //成功
			$sqli->commit();
			$sqli->autocommit(TRUE);
			//运费计算尚未加入
			$sql = "INSERT INTO `order` ( `order_user_id`, `store_id`, `total_item_price`, `edit_price`, `total_price`, `rec_name`, `rec_mobile`, `rec_city_code`, `rec_addr`, `rec_note`, `creat_date`) VALUES 
				( '".$_SESSION["user_id"]."', '".$_POST["store_id"]."', '".$_POST["total_price"]."', '".$_POST["total_price"]."', '".$_POST["total_price"]."', '".mysqli_real_escape_string($sqli, $_POST["rec_name"])."', '".mysqli_real_escape_string($sqli, $_POST["rec_mobile"])."',
				 '".$_POST["rec_city_code"]."', '".mysqli_real_escape_string($sqli, $_POST["rec_addr"])."', '".mysqli_real_escape_string($sqli, $_POST["rec_note"])."', '".$now."' )";
			$sqli->query($sql);
			$order_id = $sqli->insert_id;
			for($i = 0 ; $i < count($cart[$cart_indexof]->item) ; ++$i){
				$sql = "select a.* , b.user_id from item a inner join store b on a.store_id = b.store_id where a.item_id = ".$cart[$cart_indexof]->item[$i];
				$result = $sqli->query($sql);
				$row = $result->fetch_array();
				$photo = explode("|",$row["item_photo"]);
				$sql = "INSERT INTO order_item(order_id, item_id, item_name, item_count, item_price, item_total_price, item_photo, item_state) VALUES 
				('".$order_id."' , '".$cart[$cart_indexof]->item[$i]."', '".$row["item_name"]."' , '".$_POST["cart_item_count".$cart[$cart_indexof]->item[$i]]."' , '".$row["item_price"]."','".($_POST["cart_item_count".$cart[$cart_indexof]->item[$i]]*$row["item_price"])."' , '".$photo[0]."' ,0);";
				$sqli->query($sql);
			}
			$msg = "使用者 ".$_SESSION["user_nick"]." 已向你下定单，快去确认下吧！";
			$url = "mystore_order.php";
			send_msg('system' , $row["user_id"], $msg, $url ,1);
			
			
			unset($cart[$cart_indexof]);
			$_COOKIE["cart"] = json_encode( $cart );
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="订单产生成功，请於三天内至订单清单中申请付款（".strtotime("+3 day", $now)." 前）！！";
			header("Location: ../my_order.php");
			
		}
	}
	else if($action == "order_info"){
		$list = Array();
		$sql = "select a.* from `order` a 
		where a.order_id = ".$_POST["order_id"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
		$list = $row;
		$sql_area = "select city_name from city where city_id = '".substr($row["rec_city_code"],0,3)."000'";
		$result_area = mysqli_query($sqli,$sql_area);
		$row_area = mysqli_fetch_array($result_area);
		$sql_city = "select city_name from city where city_id = '".$row["rec_city_code"]."'";
		$result_city = mysqli_query($sqli,$sql_city);
		$row_city = mysqli_fetch_array($result_city);
		$list += Array('pay_state_font' => pay_state($row["pay_state"]),'item_state_font' => item_state($row["item_state"]),'rec_city_area' => $row_area["city_name"] , 'rec_city_name' => $row_city["city_name"]);
		$item = Array();
		$sql = "select * from order_item where order_id = ".$_POST["order_id"];
		$result = mysqli_query($sqli,$sql);
		for($i = 0 ; $i < $row = mysqli_fetch_array($result); ++$i ){
			$item[$i] = $row;
		}
		$list += Array('item_info' => $item );
		echo json_encode($list);
	}
	else if($action == "order_change_price"){
		$sql = "update `order` set edit_price = '".$_POST["edit_price"]."' , total_price = edit_price + order_shipment where order_id =".$_POST["order_id"];
		//echo $sql;
		if(mysqli_query($sqli,$sql))
			echo "0|";
		else
			echo "1|";
	}
	else if($action == 'seller_check'){
		$sql = "update `order` set order_check = 1 , found_date ='".date('Y-m-d H:i:s')."' where order_id = ".$_POST["order_id"];
		if(!mysqli_query($sqli,$sql))
			echo "1|";
		else{
			$sql = "select order_user_id from `order` where order_id = ".$_POST["order_id"];
			$result = mysqli_query($sqli,$sql);
			$row = mysqli_fetch_array($result);
			$msg = "您有订单已被卖家确认，赶紧去订单专区查看缴费资讯，并於三天内完成缴费动作！";
			$url = "my_order.php";
			send_msg('system' , $row["order_user_id"], $msg, $url ,0);
			echo "0|";
		}
		
		
	}
	else if($action == "order_store"){ // 150902 
		$list = Array();
		$sql = "select a.* , b.* from `order` a 
		inner join order_store b on a.order_id = b.order_id 
		where b.store_id = ".$_POST["store_id"]." AND a.order_id = ".$_POST["order_id"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
		$list = $row;
		$item = Array();
		$sql = "select * from order_item where store_id = ".$_POST["store_id"]." AND order_id = ".$_POST["order_id"];
		$result = mysqli_query($sqli,$sql);
		for($i = 0 ; $i < $row = mysqli_fetch_array($result); ++$i )
			$item[$i] = $row;
		$list += Array('item_info' => $item);
		echo json_encode($list);
	}
?>