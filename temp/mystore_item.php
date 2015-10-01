<?
	include_once("include/dbinclude.php");
	include_once("temp/mystore/header.php");
?>

<div class="col-lg-12 bgWrapper">
	<div class="row lightGreenBg">
		<div class="greenItemBtn">
			<a href="mystore_item.php?action=add" <? if($_GET["action"]=='add'||$_GET["action"]==''){ echo "style='background-image: url(include/images/darkGreenBtn.png);'";}?>>新增商品</a>
			<a href="mystore_item.php?action=shelves" <? if($_GET["action"]=='shelves'){ echo "style='background-image: url(include/images/darkGreenBtn.png);'";}?>>架上商品</a>
			<a href="mystore_item.php?action=depot" <? if($_GET["action"]=='depot'){ echo "style='background-image: url(include/images/darkGreenBtn.png);'";}?>>商品仓库</a>
		</div>
		<?
			if($_GET["action"]=='add'||$_GET["action"]=='')
				include_once("temp/mystore/item_add.php");
			else if($_GET["action"]=='shelves')
				include_once("temp/mystore/item_shelves.php");
			else if($_GET["action"]=='depot')
				include_once("temp/mystore/item_depot.php");
			else if($_GET["action"]=='edit')
				include_once("temp/mystore/item_edit.php");
		?>
	</div>
</div>
