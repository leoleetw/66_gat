<?
	include_once("include/dbinclude.php");
	include_once("temp/nav.php");
?>
<div class="col-lg-9">
	<?
		if($_GET["new_page"]=="")
			$this_page = 1;
		else
			$this_page = intval($_GET["new_page"]);
		if($_GET['sql']==''){
			$sql = "select store_id , store_name , store_logo from store where store_state = 1 ";
			if($_GET['search_type']=='store')
				$sql .= "and store_name like '%".$_GET['search_value']."%' ";
		}
		$sql .= " order by store_name desc";
		$rs_count = mysqli_num_rows(mysqli_query($sqli,$sql));
		$total_page = ceil($rs_count/20);
		$result = mysqli_query($sqli,$sql." limit ".(($this_page-1)*12).",12");
		$i = 1;
		while($row = mysqli_fetch_array($result)){
			$photo_img = explode("|",$row["item_photo"]);
			$sql_item = "select item_id from item where store_id = ".$row["store_id"]." and item_state = '1'";
			$rs_item_count = mysqli_num_rows(mysqli_query($sqli,$sql));
			if(($i % 3) == 0){
	?>
			<div class="row">
	<?  } ?>
			  <div class="col-xs-6 col-lg-4">
			    <a href="store_info.php?store_id=<? echo $row["store_id"]; ?>" class="thumbnail">
			      <img src="update/store/<? echo $row["store_logo"];?>" alt="">
			    </a>
			    <div class="caption">
		        <h3><? echo $row["store_name"]; ?></h3>
		        <p><? echo $rs_item_count; ?></p>
		      </div>
			  </div>
	<?	if(($i % 3) == 0){ ?>
			</div>
	<?
			}
			$i++;
		}
	?>
</div>