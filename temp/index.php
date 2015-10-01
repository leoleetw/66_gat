<?
	include_once("include/dbinclude.php");
	include_once("temp/nav.php");
?>
<div class="col-lg-9" id="itemContent">
	<div class="itemBlock_Wrapper">
		<div class="innerBlock_Wrapper">
			<img src="include/images/circle.png">
			<h4>每周推荐On This Week</h4>
			<h2>好物推荐</h2>
		</div>
		<div class="row" id="recommend_row">
		<?
			$sql = "select * from recommend where (CURRENT_DATE() between start_date and end_date) order by rec_id limit 0,6";
			$result = mysqli_query($sqli,$sql);
			while($row = mysqli_fetch_array($result)){
		?>
				<div class="col-xs-6 col-lg-5">
				  <!--<div class="recommend_wrapper">
				    <a href="rec_info.php?rec_id=<? echo $row["rec_id"]; ?>" class="thumbnail">
				      <div class="imgOverflow split_two"><img src="update/recommend_s/<? echo $row["rec_cover"];?>" alt=""></div>
				    </a>
				    <h4><? echo $row["rec_title"];?></h4>
				  </div>-->

				<div class="flr recommend_wrapper">
        			<a href="rec_info.php?rec_id=<? echo $row["rec_id"]; ?>" class="thumbnail">
	           			<div class="imgOverflow split_two"><img src="update/recommend_s/<? echo $row["rec_cover"];?>" alt="<? echo $row["rec_title"];?>" /></div>
	            		<p class="link">■ <? echo $row["rec_title"];?></p>
	       			</a>
    			</div>
				</div>
		<?
			}
		?>
		</div>
		<!--<button type="button" id="btn_recommend" name="" onclick="location.href='item_list.php?is_best=1'"></button>-->
	</div>
	<div class="itemBlock_Wrapper">
		<div class="innerBlock_Wrapper">
			<img src="include/images/circle.png">
			<h4>最新商品New Items</h4>
		</div>

		<div class="row" id="row_row">
		<?
			$sql = "select a.item_id , a.item_name , a.item_price , a.item_photo , b.store_id ,b.store_name from item a
			inner join store b on a.store_id = b.store_id
			where a.item_state = 1 and a.is_new = 1 ORDER BY RAND() LIMIT 0,4;";
			$result = mysqli_query($sqli,$sql);
			while($row = mysqli_fetch_array($result)){
				$photo_img = explode("|",$row["item_photo"]);
		?>
				<div class="col-xs-6 col-lg-3" id="product_list">
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

		<?
			}
		?>
		</div>
		<button type="button" id="btn_newItems" name="" onclick="location.href='item_list.php?action=new'" >最新商品一览</button>
	</div>
	<div class="itemBlock_Wrapper">
	<div class="innerBlock_Wrapper">
			<img src="include/images/circle.png">
			<h4>热买商品Hot Items</h4>
		</div>

		<div class="row" id="row_row">
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
					    <p><h4><? echo $row["item_name"]; ?></h4></p>
						<p><font class="storeName"><? echo $row["store_name"]; ?></font></p>
						<img src="include/images/price.png"><h4><font class="item_price"><? echo $row["item_price"]; ?></font></h4>
			      	</div>
				  </div>
				</div>

		<?
			}
		?>
		</div>
		<button type="button" id="btn_hotItems" name="" onclick="location.href='item_list.php?action=hot'">热卖商品一览</button>
	</div>
	<div class="itemBlock_Wrapper">
		<div id="news_info">
			<div id="newsTitle" onclick="location.href='news_list.php'">
				<img src="include/images/news_info_bar.png">
				<h3>最新消息News</h3>
				<img src="include/images/news_info_bar.png">
			</div>
				<div id="news_block">
				<?
					$sql = "select * from news where (CURRENT_DATE() between start_date and end_date) order by news_id DESC limit 0,3";
					$result = mysqli_query($sqli,$sql);
					while($row = mysqli_fetch_array($result)){
				?>
					<div class="news_block_info" onclick="location.href='news_info.php?news_id=<? echo $row["news_id"];?>'">
						<img src="update/news_s/<? echo $row["news_cover"];?>" style='width:170px;'>
						<p><? echo $row["start_date"]."～".$row["end_date"]; ?></p>
						<p><? echo $row["news_title"];?></p>
					</div>
				<?	}	?>
			</div>
		</div>
	</div>
</div>