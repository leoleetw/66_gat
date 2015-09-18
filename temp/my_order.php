<?
	include_once("include/dbinclude.php");
	include_once("temp/my_header.php");
?>
<ul class="nav nav-tabs tabs_blue" role="tablist">
  <li role="presentation" <? if($_GET["action"]=='undone'||$_GET["action"]==''){ echo "class='active'";} ?> ><a href="my_order.php?action=undone">已下标订单</a></li>
  <li role="presentation" <? if($_GET["action"]=='done'){ echo "class='active'";} ?>><a href="my_order.php?action=done">已结束订单</a></li>
</ul>

<?
	if($_GET["action"]=='undone'||$_GET["action"]=='')
		include_once("temp/my/order_undone.php");
	else if($_GET["action"]=='done')
		include_once("temp/my/order_done.php");
?>