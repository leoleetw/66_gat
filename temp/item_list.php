<?
	include_once("include/dbinclude.php");
	//echo "<script>alert(".$_COOKIE["click_item"].");</script>";
?>
<div class="col-lg-12">
	<div class="categoryBanner">商品 ITEMS</div>
</div>
<?
	include_once("temp/nav.php");
?>
<div class="col-lg-9">
	<?
		$get_value = "";
		if($_GET["action"]=='hot')
			$get_value = "&action=hot";
		else if($_GET["action"]=='new')
			$get_value = "&action=new";
		if($_GET["search_type"]!=''){
			if($_GET["search_type"]=='keyword')
				$get_value .= "&search_type=keyword&search_value=".$_GET["search_value"];
			else if($_GET["search_type"]=='price')
				$get_value .= "&search_type=price&price1=".$_GET["price1"]."&price2=".$_GET["price2"];
		}

	?>
	<div class="sorting01">排序︰
		<?
			if($_GET["seq"]=="")
				$seq = "exp";
			else
				$seq = $_GET["seq"];
		?>
		<button class="btn btn-<? if($seq=="exp"){ echo "danger";}else{ echo "default";} ?>" onclick="location.href='item_list.php?seq=exp<? echo $get_value;?>'" >价钱高低</button>
		<button class="btn btn-<? if($seq=="new"){ echo "danger";}else{ echo "default";} ?>" onclick="location.href='item_list.php?seq=new<? echo $get_value;?>'" >最新上架</button>
	</div>
	<div class="numberButton">
		<ul>
		<?
			if($_GET["now_page"]=="")
			$now_page = 1;
		else
			$now_page = intval($_GET["now_page"]);
			$limit_count = 12;
			$sql = "select a.item_id , a.item_name , a.item_price , a.item_photo , b.store_id ,b.store_name from item a
			inner join store b on a.store_id = b.store_id
			inner join category c on a.cate_id = c.cate_id
			where a.item_state = 1 ";
			if($_GET["cate_id"]!="")
				$sql .= " and (a.cate_id = ".$_GET["cate_id"]." or c.parent_id = ".$_GET["cate_id"].")";
			if($_GET["action"]=='new')
				$sql .= " and a.is_new = 1";
			if($_GET["action"]=='hot')
				$sql .= " and a.is_hot = 1";
			if($_GET["search_type"]!=''){
				if($_GET["search_type"]=='keyword')
					$sql .= " and( a.item_name like '%".$_GET["search_value"]."%' or b.store_name like '%".$_GET["search_value"]."%')";
				else if($_GET["search_type"]=='price')
					$sql .= " and ( a.item_price between ".$_GET["price1"]." and ".$_GET["price2"].")";
			}
			$sql .= " order by ";
			if($_GET["seq"]=="" || $_GET["seq"]=="new")
				$sql .= "a.shelves_date desc";
			else if($_GET["seq"]=="old")
				$sql .= "a.shelves_date";
			else if($_GET["seq"]=="exp")
				$sql .= "a.item_price desc";
			else if($_GET["seq"]=="inexp")
				$sql .= "a.item_price";
			$rs_count = mysqli_num_rows(mysqli_query($sqli,$sql));
			$page_count = ceil($rs_count/$limit_count);
			$result = mysqli_query($sqli,$sql." limit ".(($now_page-1)*$limit_count).",".$limit_count);

			if($_GET["seq"]!='')
			$get_value .= "&seq=".$_GET["seq"];
			//clicked_numberButton
			$page_list = floor($now_page / 5);
			$page_error = $now_page % 5;
		?>
  			<li <? if($now_page == 1 ){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="item_list.php?now_page=1<? echo $get_value; ?>">&laquo;</a></li>
  			<li <? if($now_page == 1 ){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="item_list.php?now_page=<? echo ($now_page-1).$get_value; ?>">&#8249;</a></li>
  		<?
  			if($page_error != 0)
				$page = ($page_list*5)+1;
			else
				$page = (($page_list-1)*5)+1;
  			for( $n = 0; $n < 5 && $page <= $page_count; ++$n , ++$page){

  				echo "<li><a href='item_list.php?now_page=".$page.$get_value."' ";
	  			if($page == $now_page)
	  				echo "class='clicked_numberButton'";
	  			else
	  				echo "class='be4_numberButton'";
	  			echo ">".$page."</a></li>";

  			}

  		?>
			<li <? if($page_count <= 1 || $page_count == $now_page){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="item_list.php?now_page=<? echo ($now_page+1).$get_value; ?>">&#8250;</a></li>
			<li <? if($page_count == $now_page){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="item_list.php?now_page=<? echo $page_count.$get_value; ?>">&raquo;</a></li>
		</ul>
	</div>
	<?
		if($rs_count == 0){
	?>
		<div>此分类找不到商品</div>
	<?
		}
		else{
			$this_count = mysqli_num_rows($result);
			$i = 1;
			while($row = mysqli_fetch_array($result)){
				$photo_img = explode("|",$row["item_photo"]);
				if(($i % 4) == 1){
	?>
			<div class="row">
	<?  	} ?>
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
	<?		if((($i % 4) == 0) || $i == $this_count){ ?>
			</div>
	<?
				}
				$i++;
			}

	?><!--上下页-->
		<!--button type='button' id='next_btn' class='btn btn-primary' onclick="location.href='item_list.php?<? echo "now_page=".($now_page-1).$get_value; ?>'" <? if($now_page == 1 ){echo "style='display:none;'";} ?>>上一页</button>
		<button type='button' id='last_btn' class='btn btn-primary' onclick="location.href='item_list.php?<? echo "now_page=".($now_page+1).$get_value; ?>'" <? if($page_count <= 1 || $page_count == $now_page){echo "style='display:none;'";} ?>>下一页</button-->
	<div class="numberButton">
		<ul>
  			<li <? if($now_page == 1 ){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="item_list.php?now_page=1<? echo $get_value; ?>">&laquo;</a></li>
  			<li <? if($now_page == 1 ){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="item_list.php?now_page=<? echo ($now_page-1).$get_value; ?>">&#8249;</a></li>
  		<?
  			if($page_error != 0)
				$page = ($page_list*5)+1;
			else
				$page = (($page_list-1)*5)+1;
  			for( $n = 0; $n < 5 && $page <= $page_count; ++$n , ++$page){

  				echo "<li><a href='item_list.php?now_page=".$page.$get_value."' ";
	  			if($page == $now_page)
	  				echo "class='clicked_numberButton'";
	  			else
	  				echo "class='be4_numberButton'";
	  			echo ">".$page."</a></li>";
	  		}
  		?>
			<li <? if($page_count <= 1 || $page_count == $now_page){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="item_list.php?now_page=<? echo ($now_page+1).$get_value; ?>">&#8250;</a></li>
			<li <? if($page_count == $now_page){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="item_list.php?now_page=<? echo $page_count.$get_value; ?>">&raquo;</a></li>
		</ul>
	</div>
	<?
		}
	?>
	<div>
		<div class="checkedItemName">
			<img src="include/images/news_info_bar.png">
			<h4>最新点选过的商品</h4>
			<img src="include/images/news_info_bar.png">
		</div>
		<div class="checkedItem">
		<div class='row'>
		<?
			if($_COOKIE["click_item"] != ""){
				$click_item = explode("|",$_COOKIE["click_item"]);
				for($i = count($click_item)-1 , $n = 0; $i >= 0 && $n < 6 ; --$i , ++$n){
					$sql = "select a.item_id , a.item_name , a.item_price , a.item_photo , b.store_id ,b.store_name from item a
					inner join store b on a.store_id = b.store_id
					inner join category c on a.cate_id = c.cate_id
					where a.item_state = 1 and a.item_id=".$click_item[$i];
					$result = mysqli_query($sqli,$sql);
					$row = mysqli_fetch_array($result);
					$photo_img = explode("|" , $row["item_photo"]);
		?>
					<div class="col-xs-2 col-lg-2 split_six">
					  <div class="merchandise_wrapper checked_wrapper">
					    <a href="item_info.php?item_id=<? echo $row["item_id"]; ?>" class="thumbnail">
					      <div class="imgOverflow split_four"><img src="update/item_s/<? echo $photo_img[0];?>" alt=""></div>
					    </a>
					    <!--<div class="caption">
						    <p><h4><? echo $row["item_name"]; ?></h4></p>
							<p><font class="storeName"><? echo $row["store_name"]; ?></font></p>
							<img src="include/images/price.png"><h4><font class="item_price"><? echo $row["item_price"]; ?></font></h4>
				      	</div>-->
					  </div>
					</div>
		<?
				}
			}
		?>
		</div>
		</div>
	</div>
</div>