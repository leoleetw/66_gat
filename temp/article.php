<?
	include_once("include/dbinclude.php");
?>
<div class="col-lg-12">
	<div class="categoryBanner">這裡是商品名稱</div>
</div>
<?
	include_once("temp/nav.php");
?>
<div class="col-lg-9">
	<div class="item_wrapper">
		<!--button type='button' class='btn btn-primary' id='back_list_btn' onclick="location.href='art_list.php'">回到文章列表</button-->
		<?
			$sql = "select * from article where art_title_en = '".$_GET["action"]."'";
			$result = mysqli_query($sqli,$sql);
			$row = mysqli_fetch_array($result);
		?>
		<h1><? echo $row["art_title_cn"];?></h1>
		<div><? echo $row["art_content"]; ?></div>
	</div>
</div>
