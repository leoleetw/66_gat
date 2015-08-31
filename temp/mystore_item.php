<?
	include_once("include/dbinclude.php");
	include_once("temp/mystore/header.php");
?>

<div class="col-lg-2">
	<a href="mystore_item.php?action=add"><div>新增商品</div></a>
	<a href="mystore_item.php?action=shelves"><div>架上商品</div></a>
	<a href="mystore_item.php?action=depot"><div>商品仓库</div></a>
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