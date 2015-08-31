<?
	include_once("include/dbinclude.php");
	include_once("temp/nav.php");
?>
<div class="col-lg-9">
	<div class="itemBlock_Wrapper">
		每周推荐This Week
		<div class="row">
		<?
			$sql = "select a.item_id , a.item_name , a.item_price , a.item_photo , b.store_id ,b.store_name from item a
			inner join store b on a.store_id = b.store_id
			where a.item_state = 1 and a.is_best = 1 ORDER BY RAND() LIMIT 0,4;";
			$result = mysqli_query($sqli,$sql);
			while($row = mysqli_fetch_array($result)){
				$photo_img = explode("|",$row["item_photo"]);
		?>
				<div class="col-xs-6 col-lg-3">
				  <div class="merchandise_wrapper">
				    <a href="item_info.php?item_id=<? echo $row["item_id"]; ?>" class="thumbnail">
				      <div class="imgOverflow split_four"><img src="update/item_s/<? echo $photo_img[0];?>" alt=""></div>
				    </a>
				    <div class="caption">
					    <h3><? echo $row["item_price"]; ?></h3>
					    <font><? echo $row["item_name"]; ?></font><br/>
					    <font><? echo $row["store_name"]; ?></font>
			      	</div>
				  </div>
				</div>

		<?
			}
		?>
		</div>
		<button type="button" id="" name="" onclick="location.href='item_list.php?is_best=1'" class="btn btn-danger">推荐商品一览</button>
	</div>
	<div class="itemBlock_Wrapper">
		最新商品New Items
		<div class="row">
		<?
			$sql = "select a.item_id , a.item_name , a.item_price , a.item_photo , b.store_id ,b.store_name from item a
			inner join store b on a.store_id = b.store_id
			where a.item_state = 1 and a.is_new = 1 ORDER BY RAND() LIMIT 0,4;";
			$result = mysqli_query($sqli,$sql);
			while($row = mysqli_fetch_array($result)){
				$photo_img = explode("|",$row["item_photo"]);
		?>
				<div class="col-xs-6 col-lg-3">
				  <div class="merchandise_wrapper">
				    <a href="item_info.php?item_id=<? echo $row["item_id"]; ?>" class="thumbnail">
				      <div class="imgOverflow split_four"><img src="update/item_s/<? echo $photo_img[0];?>" alt=""></div>
				    </a>
				    <div class="caption">

					    <font><? echo $row["item_name"]; ?></font><br/>
					    <font><? echo $row["store_name"]; ?></font>
					    <h3><? echo $row["item_price"]; ?></h3>
			      	</div>
				  </div>
				</div>

		<?
			}
		?>
		</div>
		<button type="button" id="" name="" onclick="location.href='item_list.php?is_new=1'" class="btn btn-danger">最新商品一览</button>
	</div>
	<div class="itemBlock_Wrapper">
		热买商品Hot Items
		<div class="row">
		<?
			$sql = "select a.item_id , a.item_name , a.item_price , a.item_photo , b.store_id ,b.store_name from item a
			inner join store b on a.store_id = b.store_id
			where a.item_state = 1 and a.is_hot = 1 ORDER BY RAND() LIMIT 0,4;";
			$result = mysqli_query($sqli,$sql);
			while($row = mysqli_fetch_array($result)){
				$photo_img = explode("|",$row["item_photo"]);
		?>
				<div class="col-xs-6 col-lg-3">
				  <div class="merchandise_wrapper">
				    <a href="item_info.php?item_id=<? echo $row["item_id"]; ?>" class="thumbnail">
				      <div class="imgOverflow split_four"><img src="update/item_s/<? echo $photo_img[0];?>" alt=""></div>
				    </a>
				    <div class="caption">
					    <h3><? echo $row["item_price"]; ?></h3>
					    <font><? echo $row["item_name"]; ?></font><br/>
					    <font><? echo $row["store_name"]; ?></font>
			      	</div>
				  </div>
				</div>

		<?
			}
		?>
		</div>
		<button type="button" id="" name="" onclick="location.href='item_list.php?is_hot=1'" class="btn btn-danger">热卖商品一览</button>
	</div>
	<div class="itemBlock_Wrapper">最新消息News</div>
</div>