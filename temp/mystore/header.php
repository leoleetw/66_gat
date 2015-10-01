<?
	include_once("include/dbinclude.php");
	$sql = "select a.store_name , b.user_nick from store a inner join user b on a.user_id = b.user_id where a.user_id=".$_SESSION["user_id"];
	$result = mysqli_query($sqli,$sql);
	$store_count = mysqli_num_rows($result);
	if($store_count == 0){
		header("Location: login.php");
	}
	$row = mysqli_fetch_array($result);
	$sql1 = "select a.end_date from `order` a inner join store b on a.store_id = b.store_id where (b.user_id = ".$_SESSION["user_id"].") AND a.order_state = 1 order by a.end_date DESC limit 0,1";
	$result1 = mysqli_query($sqli,$sql1);
	$row1 = mysqli_fetch_array($result1);
?>
<div class="col-lg-12">
	<div class="row headerWrapper">
		<div class="left_bar gat_green"></div>
		<div class="count_info">
			<h5><? echo $row["user_nick"]; ?></h5>
			<h3><? echo $row["store_name"]; ?></h3>
			<h6>最近一次交易时间：
				<?
				$end_date = explode(" ", $row1["end_date"]);
				echo $end_date[0];
				?>
			</h6>
		</div>
		<div class="mynav_wrapper">
			<div class="mynav navBorder">
				<a href="mystore_order.php">
					<div class="navTop light_green left_radius">订单管理</div>
					<div class="navBottom gat_green">
						<div class="navLabel gat_green"></div>
					</div>
				</a>
			</div>
			<div class="mynav navBorder">
				<a href="mystore_item.php">
					<div class="navTop light_green">商品管理</div>
					<div class="navBottom gat_green">
						<div class="navLabel gat_green"></div>
					</div>
				</a>
			</div>
			<div class="mynav navBorder">
				<a href="mystore_recode.php">
					<div class="navTop light_green">交易管理</div>
					<div class="navBottom gat_green">
						<div class="navLabel gat_green"></div>
					</div>
				</a>
			</div>
			<div class="mynav navBorder">
				<a href="mystore_manage.php">
					<div class="navTop light_green">店舖管理</div>
					<div class="navBottom gat_green">
						<div class="navLabel gat_green"></div>
					</div>
				</a>
			</div>
			<div class="mynav">
				<a href="my.php">
					<div class="navTop light_green right_radius">我的帐号</div>
					<div class="navBottom gat_green">
						<div class="navLabel gat_green"></div>
					</div>
				</a>
			</div>
		</div>
	</div>
</div>