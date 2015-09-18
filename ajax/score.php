<?
	include_once("../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == "buy_get_score"){
		$list = Array();
		if($_POST["buy_search"]=='buy_score'){
			if($_POST["buy_date_range"]=='all')
				$sql = "select a.*,c.store_name , c.store_id, b.* from score_recode a 
				inner join `order` b on a.order_id = b.order_id 
				inner join store c on a.sell_user_id = c.user_id 
				where b.pay_state > 0 AND b.item_state = 4 AND b.order_user_id = '".$_SESSION["user_id"]."' order by a.limit_date DESC";
			else{
				if($_POST["buy_date_range"]=='month')
					$mydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) );
				else
					$mydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 year" ) );
				$sql = "select a.*,c.store_name , c.store_id, b.* from score_recode a 
				inner join `order` b on a.order_id = b.order_id 
				inner join store c on a.sell_user_id = c.user_id 
				where b.pay_state > 0 AND b.item_state = 4 AND b.order_user_id = '".$_SESSION["user_id"]."' AND (a.limit_date between '".$mydate."' and '".date("Y-m-d")."') order by a.limit_date DESC";
			}
		}
		else if($_POST["buy_search"]=='buy_score_yet'){
			$mydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+7 day" ) );
			$sql = "select a.*,c.store_name , c.store_id , b.* from score_recode a 
			inner join `order` b on a.order_id = b.order_id 
			inner join store c on a.sell_user_id = c.user_id 
			where b.pay_state > 0 AND b.item_state = 4 AND b.order_user_id = '".$_SESSION["user_id"]."' AND (a.for_sell_score is NULL) AND ('".date("Y-m-d")."' between a.limit_date and '".$mydate."') order by a.limit_date DESC";
		}
	  $result = mysqli_query($sqli,$sql);
		for($i = 0 ;$row = mysqli_fetch_array($result);++$i)
			$list[$i] = $row ;
		echo json_encode($list);
	}
	else if($action == 'for_sell_score'){//更新給賣家評分
		$now = date("Y-m-d H:i:s");
		$sql = "select * from score_recode where order_id =".$_POST["order_id"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
		$sql = "update score_recode set for_sell_score = '".$_POST["for_sell_score"]."' , for_sell_date = '".$now."' , for_sell_comment = '".$_POST["for_sell_comment"]."'  where order_id =".$_POST["order_id"];
		mysqli_query($sqli,$sql);
		if($row["for_sell_score"] == null){
			if($_POST["for_sell_score"] == '0')
				$sell_state = "sell_good_count";
			else if($_POST["for_sell_score"] == '1')
				$sell_state = "sell_normal_count";
			else if($_POST["for_sell_score"] == '2')
				$sell_state = "sell_bad_count";
			$sql = "update score set ".$sell_state." = ".$sell_state." + 1 where user_id=".$row["sell_user_id"];
			mysqli_query($sqli,$sql);
		}
		else{
			if($_POST["for_sell_score"]!=$row["for_sell_score"]){
				if($row["for_sell_score"] == '0')
					$sell_state_o = "sell_good_count";
				else if($row["for_sell_score"] == '1')
					$sell_state_o = "sell_normal_count";
				else if($row["for_sell_score"] == '2')
					$sell_state_o = "sell_bad_count";
					
				if($_POST["for_sell_score"] == '0')
					$sell_state = "sell_good_count";
				else if($_POST["for_sell_score"] == '1')
					$sell_state = "sell_normal_count";
				else if($_POST["for_sell_score"] == '2')
					$sell_state = "sell_bad_count";
				$sql = "update score set ".$sell_state." = ".$sell_state." + 1 , ".$sell_state_o." = ".$sell_state_o." - 1 where user_id=".$row["sell_user_id"];
				mysqli_query($sqli,$sql);
			}
		}
		echo "0|";
	}
	else if($action == "sell_get_score"){
		$list = Array();
		if($_POST["sell_search"]=='sell_score'){
			if($_POST["buy_date_range"]=='all')
				$sql = "select a.*,c.user_nick , b.creat_date , b.end_date from score_recode a 
    		inner join `order` b on a.order_id = b.order_id 
    		inner join user c on a.buy_user_id = c.user_id 
				where b.pay_state > 0 AND b.item_state = 4 AND a.sell_user_id = '".$_SESSION["user_id"]."' order by a.limit_date DESC";
			else{
				if($_POST["sell_date_range"]=='month')
					$mydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) );
				else
					$mydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 year" ) );
				$sql = "select a.*,c.user_nick , b.creat_date , b.end_date from score_recode a 
    		inner join `order` b on a.order_id = b.order_id 
    		inner join user c on a.buy_user_id = c.user_id 
				where b.pay_state > 0 AND b.item_state = 4 AND a.sell_user_id = '".$_SESSION["user_id"]."' AND (a.limit_date between '".$mydate."' and '".date("Y-m-d")."') order by a.limit_date DESC";
			}
		}
		else if($_POST["sell_search"]=='sell_score_yet'){
			$mydate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+7 day" ) );
			$sql = "select a.*,c.user_nick , b.creat_date , b.end_date, b.total_price from score_recode a 
  		inner join `order` b on a.order_id = b.order_id 
  		inner join user c on a.buy_user_id = c.user_id 
			where b.pay_state > 0 AND b.item_state = 4 AND a.sell_user_id = '".$_SESSION["user_id"]."' AND (a.for_buy_score is NULL) AND ('".date("Y-m-d")."' between a.limit_date and '".$mydate."') order by a.limit_date DESC";
		}
	  $result = mysqli_query($sqli,$sql);
		for($i = 0 ;$row = mysqli_fetch_array($result);++$i)
			$list[$i] = $row ;
		echo json_encode($list);
	}
	else if($action == 'for_buy_score'){//更新給買家評分
		$now = date("Y-m-d H:i:s");
		$sql = "select * from score_recode where order_id =".$_POST["order_id"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
		$sql = "update score_recode set for_buy_score = '".$_POST["for_buy_score"]."' , for_buy_date = '".$now."' , for_buy_comment = '".$_POST["for_buy_comment"]."'  where order_id =".$_POST["order_id"];
		mysqli_query($sqli,$sql);
		if($row["for_buy_score"] == null){
			if($_POST["for_buy_score"] == '0')
				$buy_state = "buy_good_count";
			else if($_POST["for_buy_score"] == '1')
				$buy_state = "buy_normal_count";
			else if($_POST["for_buy_score"] == '2')
				$buy_state = "buy_bad_count";
			$sql = "update score set ".$buy_state." = ".$buy_state." + 1 where user_id=".$row["buy_user_id"];
			mysqli_query($sqli,$sql);
		}
		else{
			if($_POST["for_buy_score"]!=$row["for_buy_score"]){
				if($row["for_buy_score"] == '0')
					$buy_state_o = "sell_good_count";
				else if($row["for_buy_score"] == '1')
					$buy_state_o = "sell_normal_count";
				else if($row["for_buy_score"] == '2')
					$buy_state_o = "sell_bad_count";
					
				if($_POST["for_buy_score"] == '0')
					$buy_state = "sell_good_count";
				else if($_POST["for_buy_score"] == '1')
					$buy_state = "sell_normal_count";
				else if($_POST["for_buy_score"] == '2')
					$buy_state = "sell_bad_count";
				$sql = "update score set ".$buy_state." = ".$buy_state." + 1 , ".$buy_state_o." = ".$buy_state_o." - 1 where user_id=".$row["buy_user_id"];
				mysqli_query($sqli,$sql);
			}
		}
		echo "0|";
	}
?>