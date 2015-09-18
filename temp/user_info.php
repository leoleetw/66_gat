<?
	include_once("include/dbinclude.php");
	include_once("temp/nav.php");
?>
<div class="col-lg-9">
	<?
		$sql = "select a.* , b.* , b.user_id as user_score from user a 
		left join score b on a.user_id = b.user_id 
		where a.user_id =".$_GET["user_id"];
		$result = mysqli_query($sqli,$sql);
		$count = mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
	?>
	<h1><? echo $row["user_nick"];?></h1>
	<table class='table'>
		<tr><th>买入交易评价</th><th>卖出交易评价</th></tr>
		<tr>
			<td>
				<?	if($row["user_score"] == null){?>
					<img src="include/images/active_good.png"> 0 <img src="include/images/active_bad.png"> 0 
				<?	}else{?>
					<img src="include/images/active_good.png"><? echo $row["buy_good_count"]; ?>  <img src="include/images/active_bad.png"><? echo $row["buy_bad_count"]; ?>
				<?	}	?>
			</td>
			<td>
				<?	if($row["user_score"] == null){?>
					<img src="include/images/active_good.png"> 0 <img src="include/images/active_bad.png"> 0 
				<?	}else{?>
					<img src="include/images/active_good.png"><? echo $row["sell_good_count"]; ?>  <img src="include/images/active_bad.png"><? echo $row["sell_bad_count"]; ?>
				<?	}	?>
			</td>
		</tr>
	</table>
</div>