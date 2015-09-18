<?
	include_once("include/dbinclude.php");
	?>
<div class="col-lg-12">
	<div class="categoryBanner">商品 ITEMS</div>
</div>
<?
	include_once("temp/nav.php");
?>
<div class="col-lg-9">
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
		$sql .= " order by a.shelves_date desc";
		$rs_count = mysqli_num_rows(mysqli_query($sqli,$sql));
		$page_count = ceil($rs_count/$limit_count);
		$result = mysqli_query($sqli,$sql." limit ".(($now_page-1)*$limit_count).",".$limit_count);
		if($rs_count == 0){
	?>
		<div>此分类找不到商品</div>
	<?
		}
		else{
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
	<?		if(($i % 4) == 0){ ?>
			</div>
	<?
				}
				$i++;
			}
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
	?><!--上下页-->
		<button type='button' id='next_btn' class='btn btn-primary' onclick="location.href='item_list.php?<? echo "now_page=".($now_page-1).$get_value; ?>'" <? if($now_page == 1 ){echo "style='display:none;'";} ?>>上一页</button>
		<button type='button' id='last_btn' class='btn btn-primary' onclick="location.href='item_list.php?<? echo "now_page=".($now_page+1).$get_value; ?>'" <? if($page_count <= 1 || $page_count == $now_page){echo "style='display:none;'";} ?>>下一页</button>
	<?
		}
	?>
</div>