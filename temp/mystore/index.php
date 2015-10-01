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
	$sql1 = "select a.end_date from `order` a inner join store b on a.store_id = b.store_id where (b.user_id = ".$_SESSION["user_id"].") AND a.order_state = 1 order by a.end_date DESC limit 0,1";
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
	$sql6 = "select order_id from `score_recode` where ( sell_user_id = ".$_SESSION["user_id"]." and for_buy_score is NULL)  and NOW() between limit_date and limit_date + INTERVAL 7 DAY";
	$result6 = mysqli_query($sqli,$sql6);
	$count6 = mysqli_num_rows($result6);
?>
<div class="col-lg-12 my_index">
	<div class="mystore_index_title">
		<big>店</big><small>家专区</small><font>—售出纪录</font>
		<a>
			售出评价 :&nbsp;&nbsp;
			<?	if($count == 0){?>
				<img src="include/images/active_good.png">&nbsp;&nbsp; 0 &nbsp;&nbsp;&nbsp;&nbsp;<img src="include/images/active_bad.png">&nbsp;&nbsp; 0
			<?	}else{?>
				<img src="include/images/active_good.png">&nbsp;&nbsp;<? echo $row["sell_good_count"]; ?>&nbsp;&nbsp;&nbsp;&nbsp; <img src="include/images/active_bad.png">&nbsp;&nbsp;<? echo $row["sell_bad_count"]; ?>
			<?	}	?>
		</a>
	</div>
	<div class="row">
		<div class="col-lg-4 undone_wrapper">
			<div class="sell_undone_form green_form_style">
				<h4>待确认</h4>
				<h3><a href='mystore_order.php?action=undone'><? echo $count2;?></a></h3>
			</div>
			<div class="sell_undone_form green_form_style">
				<h4>待发货</h4>
				<h3><? echo $count5;?></h3>
			</div>
			<div class="sell_undone_form green_form_style">
				<h4>待评价</h4>
				<h3><a href='my_recode.php?action=score'><? echo $count6;?></a></h3>
			</div>
		</div>
		<div class="col-lg-8 news_form green_form_style">
			<h4>所有消息</h4>
			<?
				$sql_msg = "select * from message where msg_to = ".$_SESSION["user_id"]." and msg_identity = 1 order by msg_date DESC limit 0,5";
				$result_msg = mysqli_query($sqli,$sql_msg);
				while($row_msg = mysqli_fetch_array($result_msg)){
					if($row_msg["msg_url"]=="")
						echo "<div class='row score_news'><div class='col-lg-4 news_date'>".str_replace(" ","，",$row_msg["msg_date"])."</div><div class='col-lg-8 news_text'>".$row_msg["msg_content"]."</div></div>";
					else
						echo "<div class='row score_news'><div class='col-lg-4 news_date'>".str_replace(" ","，",$row_msg["msg_date"])."</div><div class='col-lg-8 news_text'><a href='".$row_msg["msg_url"]."'>".$row_msg["msg_content"]."</a></div></div>";
				}
			?>
		</div>
	</div>
</div>
<!--table class='table'>
	<tr><th>交易评价</th><th>最後一笔交易时间</th><th>待付款</th><th>待收货</th><th>待确认</th><th>待发货</th><th>待评价</th></tr>
	<tr>
		<td>
			<?	if($count == 0){?>
				<img src="include/images/active_good.png"> 0 <img src="include/images/active_bad.png"> 0
			<?	}else{?>
				<img src="include/images/active_good.png"><? echo $row["sell_good_count"]; ?>  <img src="include/images/active_bad.png"><? echo $row["sell_bad_count"]; ?>
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
</table-->