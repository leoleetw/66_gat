<?
	include_once("include/dbinclude.php");
	?>
<div class="col-lg-12">
	<div class="newsBanner">最新消息 NEWS</div>
</div>
<?
	include_once("temp/nav.php");
?>
<div class="col-lg-9">
	<h3 class="fl">最新消息</h3>
	<section class="newsList">
	<?
		if($_GET["now_page"]=="")
			$now_page = 1;
		else
			$now_page = intval($_GET["now_page"]);
		$limit_count = 20;
		$sql = "select * from news where (CURRENT_DATE() between start_date and end_date) order by news_id DESC";
		$result1 = mysqli_query($sqli,$sql);
		$total_count = mysqli_num_rows($result1);
		$page_count = ceil($total_count / $limit_count);
		$result = mysqli_query($sqli,$sql." limit ".($now_page-1)*$limit_count.",".$limit_count);
		while($row = mysqli_fetch_array($result)){
	?>
		<div class="news_group clearfix">
			<a href='news_info.php?news_id=<? echo $row["news_id"];?>'>
				<div class="fl"><? echo $row["start_date"];?></div>
				<div class="fl line-gray"><div class="diamond"></div></div>
				<div class="fl"><? echo $row["news_title"];?></div>
			</a>
 		</div>
	<?
		}
	?>
	</section>
	<button type='button' id='next_btn' onclick="location.href='news_list.php?now_page=<? echo $now_page-1; ?>'" style='display:none;'>上一页</button>
	<button type='button' id='last_btn' onclick="location.href='news_list.php?now_page=<? echo $now_page+1; ?>'" <? if($page_count <= 1 ){echo "style='display:none;'";} ?>>下一页</button>
</div>
