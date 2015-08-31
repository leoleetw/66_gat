<?
	include_once("include/dbinclude.php");
	?>
<div class="col-lg-12">
	<div class="categoryBanner">這裡是商品分類banner</div>
</div>
<?
	include_once("temp/nav.php");
?>
<div class="col-lg-9">
	<?
		if($_GET["new_page"]=="")
			$this_page = 1;
		else
			$this_page = intval($_GET["new_page"]);
		if($_GET['sql']==""){
			$sql = "select a.item_id , a.item_name , a.item_price , a.item_photo , b.store_id ,b.store_name from item a
			inner join store b on a.store_id = b.store_id
			inner join category c on a.cate_id = c.cate_id
			where a.item_state = 1 ";
			if($_GET["cate_id"]!="")
				$sql .= " and (a.cate_id = ".$_GET["cate_id"]." or c.parent_id = ".$_GET["cate_id"].")";
			if($_GET["is_best"]=='1')
				$sql .= " and a.is_best = 1";
			if($_GET["is_new"]=='1')
				$sql .= " and a.is_new = 1";
			if($_GET["is_hot"]=='1')
				$sql .= " and a.is_hot = 1";
			if($_GET["search_type"]!=''){
				if($_GET["search_type"]=='keyword')
					$sql .= " and( a.item_name like '%".$_GET["search_value"]."%' or b.store_name like '%".$_GET["search_value"]."%')";
				else if($_GET["search_type"]=='price')
					$sql .= " and ( a.item_price between ".$_GET["price1"]." and ".$_GET["price2"].")";
			}
		}
		$sql .= " order by item_id desc";
		$rs_count = mysqli_num_rows(mysqli_query($sqli,$sql));
		$total_page = ceil($rs_count/20);
		$result = mysqli_query($sqli,$sql." limit ".(($this_page-1)*20).",20");
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
					    <h3><? echo $row["item_price"]; ?></h3>
					    <font><? echo $row["item_name"]; ?></font><br/>
					    <font><? echo $row["store_name"]; ?></font>
			      	</div>
				  </div>
			</div>
	<?		if(($i % 4) == 0){ ?>
			</div>
	<?
				}
				$i++;
			}
		}
	?>
</div>