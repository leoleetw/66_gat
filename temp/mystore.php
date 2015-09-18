<?
	include_once("include/dbinclude.php");
	include_once("temp/mystore/header.php");
?>
	<?
		$sql = "select * from store where user_id='".$_SESSION["user_id"]."'";
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
		if(trim($row["store_name"])==""){ //尚未建立店家资料
	?>
		<form id="creat_store_form" action="ajax/mystore.php" method="post" enctype="multipart/form-data">
			<div>
				<label for="creat_store_name">商店名称︰</label>
				<input type="text" class="form-control" id="creat_store_name" name="creat_store_name" value="">
				<label for="creat_store_logo">商店logo(非必填)︰</label>
				<input type="file" id="creat_store_logo" name="creat_store_logo" >
				<label for="creat_store_introduce">商店自介︰</label>
				<textarea id="creat_store_introduce" name="creat_store_introduce" class="form-control"></textarea>
				<input type="hidden" id="aciton" name="action" value="creat_store" >
				<button type="button" class="btn btn-primary" onclick="check_creat_info();">确认</button>
			</div>
		</form>
	<?
		}else{
			include_once("temp/mystore/index.php");
		} ?>
	<div>
	</div>
	<script>
		function check_creat_info(){
			if(Dd("creat_store_name").value == ""||Dd("creat_store_introduce").value == "" )
				alert("请先填妥完整商店基本资讯");
			else
				Dd("creat_store_form").submit();
		}

	</script>