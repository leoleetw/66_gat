<?
	//ALTER TABLE category AUTO_INCREMENT =0
	include_once("../../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;	
	if($action == "change_state"){
		$sql = "select a.* , b.user_id from `order` a inner join store b on a.store_id = b.store_id where a.order_id = ".$_POST["order_id"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
		if($row["order_check"]==0){
			echo "1|";
		}
		else{
			if($row["pay_state"]==0){
				$sql = "update `order` set pay_state = 1  where order_id =".$_POST["order_id"];
				if(!mysqli_query($sqli,$sql))
					echo "1|";
				else{
					$msg = "订单 ".$_POST["order_id"]." 已付款";
					$url = "";
					send_msg('system' , $row['user_id'], $msg, $url , 1 );
					echo "0|";
				}
			}
			else if($row["item_state"]==0){
				$sql = "update `order` set item_state = 1 where order_id =".$_POST["order_id"];
				if(!mysqli_query($sqli,$sql))
					echo "1|";
				else
					echo "0|";
			}
			else if($row["item_state"]==1){
				$sql = "update `order` set item_state = 2 where order_id =".$_POST["order_id"];
				if(!mysqli_query($sqli,$sql))
					echo "1|";
				else
					echo "0|";
			}
			else if($row["item_state"]==2){
				$sql = "update `order` set item_state = 3 where order_id =".$_POST["order_id"];
				if(!mysqli_query($sqli,$sql))
					echo "1|";
				else
					echo "0|";
			}
			else if($row["item_state"]==3){
				$sql = "update `order` set item_state = 4, end_date = '".date("Y-m-d H:i:s")."' where order_id =".$_POST["order_id"];
				if(!mysqli_query($sqli,$sql))
					echo "1|";
				else{
					$sql = "INSERT INTO `score_recode`(`order_id`, `buy_user_id`, `sell_user_id` , `limit_date`) VALUES ('".$_POST["order_id"]."' , '".$row["order_user_id"]."' , '".$row["user_id"]."' , '".date("Y-m-d H:i:s")."')";
					mysqli_query($sqli,$sql);
					//买家评分
					$sql = "select * from score where user_id = ".$row["order_user_id"];
					$rs_count = mysqli_query($sqli,$sql);
					$total_count = mysqli_num_rows($rs_count);
					if($total_count==0)
						$sql = "INSERT INTO `score`(`user_id`, `buy_count`) VALUES ('".$row["order_user_id"]."' , 1)";
					else
						$sql = "update score set buy_count = buy_count + 1 where user_id = ".$row["order_user_id"];
					mysqli_query($sqli,$sql);
					//卖家评分
					$sql = "select * from score where user_id = ".$row["user_id"];
					$rs_count = mysqli_query($sqli,$sql);
					$total_count = mysqli_num_rows($rs_count);
					if($total_count==0)
						$sql = "INSERT INTO `score`(`user_id`, `sell_count`) VALUES ('".$row["user_id"]."' , 1)";
					else
						$sql = "update score set sell_count = sell_count + 1 where user_id = ".$row["user_id"];
					mysqli_query($sqli,$sql);
					$msg = "您的订单 ".$_POST["order_id"]." 物品已送达买家，您可对买家进行评价";
					$url = "mystore_recode.php?action=score";
					send_msg('system' , $row['user_id'], $msg, $url , 1 );
					echo "0|";
				}
			}
			else if($row["pay_state"]==1){
				$sql = "update `order` set pay_state = 2 , order_state = 1  where order_id =".$_POST["order_id"];
				if(!mysqli_query($sqli,$sql))
					echo "1|";
				else{
					echo "0|";
				}
			}
			else{
				$sql = "update `order` set pay_state = 2 , order_state = 1 where order_id =".$_POST["order_id"];
				mysqli_query($sqli,$sql);
					echo "0|";
			}
		}
	}
?>