<?
	include_once("include/dbinclude.php");
	include_once("temp/my_header.php");
?>
<div class="col-lg-12 bgWrapper">
	<div class="row lightBlueBg">
		<div class="biueItemBtn">
			<a href="my_recode.php?action=qa" <? if($_GET["action"]=='qa'||$_GET["action"]==''){ echo "style='background-image: url(include/images/blueBtn.png);'";} ?> >问与答</a>
			<a href="my_recode.php?action=score" <? if($_GET["action"]=='score'){ echo "style='background-image: url(include/images/blueBtn.png);'";} ?>>评价纪录</a>
		</div>

<?
	if($_GET["action"]=='qa'||$_GET["action"]=='')
		include_once("temp/my/recode_qa.php");
	else if($_GET["action"]=='score')
		include_once("temp/mystore/recode_score.php");
?>
	</div>
</div>