<?
	include_once("include/dbinclude.php");
	include_once("temp/mystore/header.php");
?>
<div class="col-lg-12 bgWrapper">
	<div class="row lightGreenBg">
		<div class="greenItemBtn">
			<a href="mystore_manage.php?action=setting" <? if($_GET["action"]=='setting'||$_GET["action"]==''){ echo "style='background-image: url(include/images/greenBtn.png);'";}?>>店舖资料</a>
			<a href="mystore_manage.php?action=report" <? if($_GET["action"]=='report'){ echo "style='background-image: url(include/images/greenBtn.png);'";}?>>销售报告</a>
		</div>
		<?
			if($_GET["action"]=='setting'||$_GET["action"]=='')
				include_once("temp/mystore/setting.php");
			else if($_GET["action"]=='report')
				include_once("temp/mystore/report.php");
		?>
	</div>
</div>