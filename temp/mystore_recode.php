<?
	include_once("include/dbinclude.php");
	include_once("temp/mystore/header.php");
?>
<div class="col-lg-12 bgWrapper">
	<div class="row lightGreenBg">
		<div class="greenItemBtn">
		  <a href="mystore_recode.php?action=qa" <? if($_GET["action"]=='qa'||$_GET["action"]==''){ echo "style='background-image: url(include/images/darkGreenBtn.png);'";} ?> >問與答</a></li>
		  <a href="mystore_recode.php?action=score" <? if($_GET["action"]=='score'){ echo "style='background-image: url(include/images/darkGreenBtn.png);'";} ?>>我的評價</a></li>
	</div>

<?
	if($_GET["action"]=='qa'||$_GET["action"]=='')
		include_once("temp/mystore/recode_qa.php");
	else if($_GET["action"]=='score')
		include_once("temp/mystore/recode_score.php");
?>