<?
	include_once("include/dbinclude.php");
?>

<?
	//评价基本资料
	$sql = "select * from score where user_id =".$_SESSION["user_id"];
	$result = mysqli_query($sqli,$sql);
	$count = mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);
	//最後一笔交易时间
	$sql1 = "select a.end_date from `order` a inner join store b on a.store_id = b.store_id where (a.order_user_id = ".$_SESSION["user_id"].") AND a.order_state = 1 order by a.end_date DESC limit 0,1";
	$result1 = mysqli_query($sqli,$sql1);
	$row1 = mysqli_fetch_array($result1);
	//卖家待确认
	$sql2 = "select a.order_id from `order` a inner join store b on a.store_id = b.store_id where (b.user_id = ".$_SESSION["user_id"]." ) AND a.order_state = 0 AND a.order_check = 0";
	$result2 = mysqli_query($sqli,$sql2);
	$count2 = mysqli_num_rows($result2);
	//待付款
	$sql3 = "select a.order_id from `order` a inner join store b on a.store_id = b.store_id where (a.order_user_id = ".$_SESSION["user_id"].") AND a.order_state = 0 AND a.order_check = 1 AND a.pay_state = 0";
	$result3 = mysqli_query($sqli,$sql3);
	$count3 = mysqli_num_rows($result3);
	//待收货
	$sql4 = "select a.order_id from `order` a inner join store b on a.store_id = b.store_id where (a.order_user_id = ".$_SESSION["user_id"].") AND a.order_state = 0 AND a.order_check = 1 AND a.pay_state > 0";
	$result4 = mysqli_query($sqli,$sql4);
	$count4 = mysqli_num_rows($result4);
	//待发货
	$sql5 = "select a.order_id from `order` a inner join store b on a.store_id = b.store_id where (b.user_id = ".$_SESSION["user_id"]." OR a.order_user_id = ".$_SESSION["user_id"].") AND a.order_state = 0 AND a.order_check = 1 AND a.item_state = 0";
	$result5 = mysqli_query($sqli,$sql5);
	$count5 = mysqli_num_rows($result5);
	//待评价
	$sql6 = "select order_id from `score_recode` where (buy_user_id = ".$_SESSION["user_id"]." and for_sell_score is NULL) and NOW() between limit_date and limit_date + INTERVAL 7 DAY";
	$result6 = mysqli_query($sqli,$sql6);
	$count6 = mysqli_num_rows($result6);
?>
<table class='table'>
	<tr><th>交易评价</th><th>最後一笔交易时间</th><th>待付款</th><th>待收货</th><th>待确认</th><th>待发货</th><th>待评价</th></tr>
	<tr>
		<td>
			<?	if($count == 0){?>
				<img src="include/images/active_good.png"> 0 <img src="include/images/active_bad.png"> 0 
			<?	}else{?>
				<img src="include/images/active_good.png"> <? echo $row["buy_good_count"]; ?> <img src="include/images/active_bad.png"> <? echo $row["buy_bad_count"]; ?> 
			<?	}	?>
		</td>
		<td>
			<? 
			$end_date = explode(" ", $row1["end_date"]);
			echo $end_date[0];
			?>
		</td>
		<td>
			<a href='my_order.php?action=undone'><? echo $count3;?></a>
		</td>
		<td>
			<? echo $count4;?>
		</td>
		<td>
			<a href='mystore_order.php?action=undone'><? echo $count2;?></a>
		</td>
		<td>
			<? echo $count5;?>
		</td>
		<td>
			<a href='my_recode.php?action=score'><? echo $count6;?></a>
		</td>
	</tr>
</table>