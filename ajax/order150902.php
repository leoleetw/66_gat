<?
	include_once("../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == "creat_order"){
		$error = false;
		$cart = explode("|",$_COOKIE["cart"]);
		// transactions
		$sqli->autocommit(FALSE);
    //$sqli->beginTransaction();
    for($i = 0 ; $i < count($cart) ; ++$i){
    	$sql = "select item_stock from item where item_id =".$cart[$i];
    	$result = $sqli->query($sql);
			$row = $result->fetch_array();
			if($row["item_stock"] < $_POST["cart_item_count".$cart[$i]])
				$error = true;
			else{
				if($row["item_stock"] == $_POST["cart_item_count".$cart[$i]])
					$sql = "update item set item_stock = item_stock - ".$_POST["cart_item_count".$cart[$i]]." , item_state = 0 where item_id =".$cart[$i];
				else
					$sql = "update item set item_stock = item_stock - ".$_POST["cart_item_count".$cart[$i]]." where item_id =".$cart[$i];
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
			
			$sql = "INSERT INTO `order` (`order_state` , `order_user_id`, `total_price`, `rec_name`, `rec_mobile`, `rec_addr`, `rec_note`, `creat_date`) VALUES 
				(0 , '".$_SESSION["user_id"]."', '".$_POST["total_price"]."', '".$_POST["rec_name"]."', '".$_POST["rec_mobile"]."', '".$_POST["rec_addr"]."', '".$_POST["rec_note"]."', '".date("Y-m-d H:i:s")."' )";
			$sqli->query($sql);
			$order_id = $sqli->insert_id;
			for($i = 0 ; $i < count($cart) ; ++$i){
				$sql = "select a.* , b.user_id from item a inner join store b on a.store_id = b.store_id where a.item_id = ".$cart[$i];
				$result = $sqli->query($sql);
				$row = $result->fetch_array();
				$photo = explode("|",$row["item_photo"]);
				$sql = "INSERT INTO order_item(order_id, item_id, item_name, item_count, item_price, item_total_price, item_photo, item_state, store_id) VALUES 
				('".$order_id."' , '".$cart[$i]."', '".$row["item_name"]."' , '".$_POST["cart_item_count".$cart[$i]]."' , '".$row["item_price"]."','".($_POST["cart_item_count".$cart[$i]]*$row["item_price"])."' , '".$photo[0]."' ,0,'".$row["store_id"]."');";
				$sqli->query($sql);
			}
			$store = Array();
			$sql = "select a.store_id , a.item_total_price ,b.user_id  from order_item a inner join store b on a.store_id = b.store_id  where a.order_id = ".$order_id." order by a.store_id";
			$result = $sqli->query($sql);
			for($i = 0 , $n = 0; $i < $row = $result->fetch_array() ; ++$i){
				if($i == 0){
					$store[$n] = $row["store_id"];
					$store[$n+1] = intval($row["item_total_price"]);
					$store[$n+2] = $row["user_id"];
				}
				else{
					if($row["store_id"]==$store[$n]){
						$store[$n+1] += intval($row["item_total_price"]);
					}
					else{
						$n += 3 ;
						$store[$n] = $row["store_id"];
						$store[$n+1] = intval($row["item_total_price"]);
						$store[$n+2] = $row["user_id"];
					}
				}
			}
			for($n = 0 ; $n < count($store) ;$n+=3){
				$sql = "INSERT INTO `order_store`(`order_id`, `store_id`, `store_state`, `store_total_price`) VALUES 
				('".$order_id."' , '".$store[$n]."' , 0 , '".$store[$n+1]."')";
				$sqli->query($sql);
				$msg = "使用者 ".$_SESSION["user_nick"]." 已向你下定单，快去确认下吧！";
				send_msg('system' , $store[$n+2], $msg );
			}
			
			$_COOKIE["cart"] = "";
			$_SESSION["errnumber"]=1;
			$_SESSION["msg"]="订单产生成功，请稍等卖方确认订单後付款！！";
			header("Location: ../my_order.php");
			
		}
	}
	else if($action == "order_store"){
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