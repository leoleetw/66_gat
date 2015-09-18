<?
	include_once("include/dbinclude.php");
	$sql = "select a.store_name , b.user_name from store a inner join user b on a.user_id = b.user_id where a.user_id=".$_SESSION["user_id"];
	$result = mysqli_query($sqli,$sql);
	$store_count = mysqli_num_rows($result);
	if($store_count == 0){
		header("Location: login.php");
	}
	$row = mysqli_fetch_array($result);
?>
<div class="col-lg-12">
	<div class="row headerWrapper">
		<div class="left_bar gat_green"></div>
		<div class="count_info">
			<a><? echo $row["user_name"]; ?></a>
			<a></a>
			<a><? echo $row["store_name"]; ?></a>
		</div>
		<div class="mynav_wrapper">
			<div class="mynav navBorder">
				<a href="mystore_order.php">
					<div class="navTop left_radius">订单管理</div>
					<div class="navBottom">
						<div class="navLabel gat_green"></div>
					</div>
				</a>
			</div>
			<div class="mynav navBorder">
				<a href="mystore_item.php">
					<div class="navTop">商品管理</div>
					<div class="navBottom">
						<div class="navLabel gat_green"></div>
					</div>
				</a>
			</div>
			<div class="mynav navBorder">
				<a href="mystore_recode.php">
					<div class="navTop">交易管理</div>
					<div class="navBottom">
						<div class="navLabel gat_green"></div>
					</div>
				</a>
			</div>
			<div class="mynav navBorder">
				<a href="mystore_manage.php">
					<div class="navTop">店舖管理</div>
					<div class="navBottom">
						<div class="navLabel gat_green"></div>
					</div>
				</a>
			</div>
			<div class="mynav">
				<a href="my.php">
					<div class="navTop right_radius">我的帐号</div>
					<div class="navBottom">
						<div class="navLabel gat_green"></div>
					</div>
				</a>
			</div>
		</div>
	</div>
</div>