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
		$sql = "select brand_id , brand_name , brand_logo from brand ";
		$sql .= " order by brand_name desc";
		$rs_count = mysqli_num_rows(mysqli_query($sqli,$sql));
		$total_page = ceil($rs_count/20);
		$result = mysqli_query($sqli,$sql." limit ".(($this_page-1)*12).",12");
		$i = 1;
		while($row = mysqli_fetch_array($result)){
			if(($i % 3) == 0){
	?>
			<div class="row">
	<?  } ?>
			  <div class="col-xs-6 col-lg-3">
			  	<div class="merchandise_wrapper">
				    <a href="brand_info.php?brand_id=<? echo $row["brand_id"]; ?>" class="thumbnail">
				      <div class="imgOverflow split_four"><img src="update/brand_s/<? echo $row["brand_logo"];?>" alt=""></div>
				    </a>
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