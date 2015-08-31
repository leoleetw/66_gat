<?
	include_once("include/dbinclude.php");
?>
<div class="col-lg-12">
	<div class="categoryBanner">这里是品牌名称</div>
</div>
<?
	include_once("temp/nav.php");
?>
<div class="col-lg-9">
	<?
		$sql = "select * from brand where brand_id = '".$_GET["brand_id"]."'";
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="seller_info">
				<div class="store_logoWrapper">
					<img id="main_photo" src="update/brand_s/<? echo $row['brand_logo'];?>">
				</div>
				<div style="display: inline-block;vertical-align: top">
					<p><font>品牌名称︰</font><? echo $row["brand_name"]; ?></p>
					<p><font>品牌自介︰</font><? echo $row["brand_introduce"]; ?></p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="row">
			<div class="itemBlock_Wrapper">
				<h4> —————最新入库—————</h4>
				<?
					$sql_newitem = "select * from item where brand_id =".$_GET["brand_id"]." order by shelves_date DESC limit 0,3";
					$result_newitem = mysqli_query($sqli,$sql_newitem);
					while($row_newitem = mysqli_fetch_array($result_newitem)){
						$photo_img = explode("|",$row_newitem["item_photo"]);
				?>
				<div class="col-xs-6 col-lg-4">
					<div class="merchandise_wrapper">
					    <a href="item_info.php?item_id=<? echo $row_newitem["item_id"]; ?>" class="thumbnail">
					      <div class="imgOverflow split_three"><img src="update/item_s/<? echo $photo_img[0];?>" alt=""></div>
					    </a>
					    <div class="caption">
				        <button type="button" class="btn btn-primary" onclick="location.href='item_info.php?item_id=<? echo $row_newitem["item_id"]; ?>'" >查看详情</button>
				      	</div>
				    </div>
		  		</div>
			<? }?>
			</div>
		</div>
	</div>
	<div>排序︰
			<?
				if($_GET["orderby"]=="")
					$orderby = "item_name";
				else
					$orderby = $_GET["orderby"];
			?>
			<button class="btn btn-<? if($orderby=="item_popular"){ echo "danger";}else{ echo "default";} ?>" onclick="" >购买人气</button>
			<button class="btn btn-<? if($orderby=="item_name"){ echo "danger";}else{ echo "default";} ?>" onclick="" >商品名称</button>
			<button class="btn btn-<? if($orderby=="item_price"){ echo "danger";}else{ echo "default";} ?>" onclick="" >价钱高低</button>
			<button class="btn btn-<? if($orderby=="item_new"){ echo "danger";}else{ echo "default";} ?>" onclick="" >最新上架</button>
		</div>
	<div class="row">
		<?
			if($_GET["new_page"]=="")
			$this_page = 1;
			else
				$this_page = intval($_GET["new_page"]);
			$sql_item = "select a.item_id , a.item_name , a.item_price , a.item_photo , b.store_id ,b.store_name from item a
			inner join store b on a.store_id = b.store_id
			where a.item_state = 1 and a.brand_id = ".$_GET["brand_id"];
			$sql_item .= " order by item_id desc";
			$rs_count = mysqli_num_rows(mysqli_query($sqli,$sql_item));
			$total_page = ceil($rs_count/20);
			$result_item = mysqli_query($sqli,$sql_item." limit ".(($this_page-1)*8).",8");
			$i = 1;
			while($row_item = mysqli_fetch_array($result_item)){
				$photo_img = explode("|",$row_item["item_photo"]);
				if(($i % 4) == 0){
		?>
				<div class="row">
		<?  } ?>
				<div class="col-xs-6 col-lg-3">
				  	<div class="merchandise_wrapper">
					    <a href="item_info.php?item_id=<? echo $row_item["item_id"]; ?>" class="thumbnail">
					      <div class="imgOverflow split_four"><img src="update/item_s/<? echo $photo_img[0];?>" alt=""></div>
					    </a>
					    <div class="caption">
					        <h3><? echo $row_item["item_name"]; ?></h3>
					        <p><? echo $row_item["store_name"]; ?></p>
					        <p><? echo $row_item["item_price"]; ?></p>
				      	</div>
				  	</div>
				</div>
		<?	if(($i % 4) == 0){ ?>
				</div>
		<?
				}
				$i++;
			}
		?>
	</div>
</div>

<script>
	$( document ).ready(function() {
	  var cart = $.cookie('cart');
	  var temp = new Array();
	  temp = cart.split("|");
	  if($.inArray( "<? echo $row["item_id"];?>", temp ) > -1)
	  	Dd("add_cart_btn").disabled = "disabled";
	});
</script>