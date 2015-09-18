<?
	include_once("include/dbinclude.php");
	$sql_rec = "select * from recommend where rec_id = ".$_GET["rec_id"]." ";
	$result_rec = mysqli_query($sqli,$sql_rec);
	$row_rec = mysqli_fetch_array($result_rec);
	$start_date = strtotime($row_rec["start_date"]);
	$end_date = strtotime($row_rec["end_date"]);
	$now = strtotime(date("Y-m-d"));
	if($now < $start_date || $now > $end_date){
		header("Location: rec_list.php");
	}
	else{
?>
		<div class="col-lg-12">
			<div class="recBanner"><? echo $row_rec["rec_title"];?></div>
		</div>
		<?
			include_once("temp/nav.php");
		?>
		<div class="col-lg-9">
			<div class="recContent">
				<div>
					<? echo $row_rec["rec_content"];?>
				</div>
			</div>
				<div>
					<div class="recProduct">
					<h3>本推荐所介绍的商品</h3>
					<?
						$rec_item = Array();
						$rec_item = explode("|",$row_rec["rec_item"]);
						for($i = 0 ; $i < count($rec_item) ; ++$i){
							$sql = "select a.item_id , a.item_name , a.item_price , a.item_photo , b.store_id ,b.store_name from item a
							inner join store b on a.store_id = b.store_id
							inner join category c on a.cate_id = c.cate_id
							where a.item_id = ".$rec_item[$i];
							$result = mysqli_query($sqli,$sql);
							$row = mysqli_fetch_array($result);
							$photo_img = Array();
							$photo_img = explode("|",$row["item_photo"]);
					?>

							<div class="col-xs-6 col-lg-3">
								<div class="merchandise_wrapper">
							    <a href="item_info.php?item_id=<? echo $row["item_id"]; ?>" class="thumbnail">
							      <div class="imgOverflow split_four"><img src="update/item_s/<? echo $photo_img[0];?>" alt=""></div>
							    </a>
							    <div class="caption">
								    <p><h4><? echo $row["item_name"]; ?></h4></p>
										<p><font class="storeName"><? echo $row["store_name"]; ?></font></p>
										<img src="include/images/price.png"><h4><font class="item_price"><? echo $row["item_price"]; ?></font></h4>
					      		</div>
								</div>
							</div>
					</div>
					<?	}	?>
				</div>

<?
		$sql = "select * from recommend where rec_id > ".$_GET["rec_id"]." AND (CURRENT_DATE() between start_date and end_date) order by rec_id;";
		$result = mysqli_query($sqli,$sql);
		$count = mysqli_num_rows($result);
		if($count != 0){
			$$row = mysqli_query($sqli,$sql);
?>
			<button type='button' id='last_btn' onclick="location.href='rec_info.php?rec_id=<? $row["rec_id"];?>'">上一则</button>
<?
		}
		$sql = "select * from recommend where rec_id < ".$_GET["rec_id"]." AND (CURRENT_DATE() between start_date and end_date) order by rec_id DESC;";
		$result = mysqli_query($sqli,$sql);
		$count = mysqli_num_rows($result);
		if($count != 0){
			$$row = mysqli_query($sqli,$sql);
?>
			<button type='button' id='last_btn' onclick="location.href='rec_info.php?rec_id=<? $row["rec_id"];?>'">下一则</button>
<?
		}
	}
?>
		</div>