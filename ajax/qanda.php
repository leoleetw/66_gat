<?
	include_once("../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == "my_get_qa"){
		$list = Array();
		$sql = "select a.* , d.item_name , d.item_photo , c.store_name , c.store_id from qa a 
	    	inner join item d on d.item_id = a.item_id 
	    	left join user b on a.user_id = b.user_id 
	    	left join store c on c.store_id = d.store_id 
	    	where a.user_id = ".$_SESSION["user_id"]." and (a.q_creatdate between '".$_POST["start_date"]." 00:00:00' and '".$_POST["end_date"]." 24:59:59') order by a.q_creatdate desc";
	  $result = mysqli_query($sqli,$sql);
		for($i = 0 ;$row = mysqli_fetch_array($result);++$i)
			$list[$i] = $row ;
		echo json_encode($list);
	}
	else if($action == "get_qa"){
		$list = Array();
		$temp = Array();
		if($_POST["qa_state"]=='all')
			$sql = "select a.* , d.item_name , d.item_photo , b.user_nick  from qa a 
		    	inner join item d on d.item_id = a.item_id 
		    	left join user b on a.user_id = b.user_id 
		    	left join store c on c.store_id = d.store_id 
		    	where c.user_id = ".$_SESSION["user_id"]." and (a.q_creatdate between '".$_POST["start_date"]."' and '".$_POST["end_date"]."') order by a.q_creatdate desc";
		else if($_POST["qa_state"]=='reply_yet')
			$sql = "select a.* , d.item_name , d.item_photo , b.user_nick  from qa a 
		    	inner join item d on d.item_id = a.item_id 
		    	left join user b on a.user_id = b.user_id 
		    	left join store c on c.store_id = d.store_id 
		    	where c.user_id = ".$_SESSION["user_id"]." and (a.q_creatdate between '".$_POST["start_date"]."' and '".$_POST["end_date"]."') and a.a_creatdate = '0000-00-00 00:00:00' order by a.q_creatdate desc";
		else if($_POST["qa_state"]=='reply')
			$sql = "select a.* , d.item_name , d.item_photo , b.user_nick  from qa a 
		    	inner join item d on d.item_id = a.item_id 
		    	left join user b on a.user_id = b.user_id 
		    	left join store c on c.store_id = d.store_id 
		    	where c.user_id = ".$_SESSION["user_id"]." and (a.q_creatdate between '".$_POST["start_date"]."' and '".$_POST["end_date"]."') and a.a_creatdate != '0000-00-00 00:00:00' order by a.q_creatdate desc";
	  $rs_count = mysqli_query($sqli,$sql);
	  $total_count = mysqli_num_rows ( $rs_count );
	  $page_count = ceil($total_count / intval($_POST["limit_count"]));
		$result = mysqli_query($sqli,$sql." limit ".(intval($_POST["now_page"])-1)*intval($_POST["limit_count"]).",".$_POST["limit_count"]);
		for($i = 0 ;$row = mysqli_fetch_array($result);++$i)
			$temp[$i] = $row ;
		$list = Array( 'total_count' => $total_count , 'page_count' => $page_count , 'qa' => $temp);
		echo json_encode($list);
	}
	else if($action == "order_info"){
		$list = Array();
		$sql = "select a.* from `order` a 
		where a.order_id = ".$_POST["order_id"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
		$list = $row;
		$list += Array('pay_state_font' => pay_state($row["pay_state"]),'item_state_font' => item_state($row["item_state"]));
		$item = Array();
		$sql = "select * from order_item where order_id = ".$_POST["order_id"];
		$result = mysqli_query($sqli,$sql);
		for($i = 0 ; $i < $row = mysqli_fetch_array($result); ++$i )
			$item[$i] = $row;
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
			send_msg('system' , $row["order_user_id"], $msg );
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