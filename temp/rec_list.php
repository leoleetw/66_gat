<?
	include_once("include/dbinclude.php");
	?>
<div class="col-lg-12">
	<div class="newsBanner">本周推荐 RECOMMEND</div>
</div>
<?
	include_once("temp/nav.php");
?>
<div class="col-lg-9">
	<h2 class="fl">最新消息</h2>
	<section class="newsList">
					<div class="news_group clearfix">
						<a href="#">
							<div class="fl">2015-09-15</div>
							<div class="fl line-gray"><div class="diamond"></div></div>
							<div class="fl">被偷走的人生 !</div>
						</a>
					</div>
					<div class="news_group clearfix">
						<a href="#">
							<div class="fl">2015-09-15</div>
							<div class="fl line-gray"><div class="diamond"></div></div>
							<div class="fl">天然寶石 限時特價 !</div>
						</a>
					</div>
					<div class="news_group clearfix">
						<a href="#">
							<div class="fl">2015-09-15</div>
							<div class="fl line-gray"><div class="diamond"></div></div>
							<div class="fl">有好康的有好康的!</div>
						</a>
					</div>
					<div class="news_group clearfix">
						<a href="#">
							<div class="fl">2015-09-14</div>
							<div class="fl line-gray"><div class="diamond"></div></div>
							<div class="fl">每日新闻</div>
						</a>
					</div>
	</section>
	<?
		if($_GET["now_page"]=="")
			$now_page = 1;
		else
			$now_page = intval($_GET["now_page"]);
		$limit_count = 20;
		$sql = "select * from recommend where (CURRENT_DATE() between start_date and end_date) order by news_id DESC";
		$result1 = mysqli_query($sqli,$sql);
		$total_count = mysqli_num_rows($result1);
		$page_count = ceil($total_count / $limit_count);
		$result = mysqli_query($sqli,$sql." limit ".($now_page-1)*$limit_count.",".$limit_count);
		while($row = mysqli_fetch_array($result)){
	?>
		<div class='row' onclick="location.href='news_info.php?news_id=<? echo $row["news_id"];?>'">
			<div class='col-lg-4'><? echo $row["start_date"];?></div>
			<div class='col-lg-4'><? echo $row["news_title"];?></div>
		</div>
	<?
		}
	?>
	<button type='button' id='next_btn' onclick="location.href='news_list.php?now_page=<? echo $now_page-1; ?>'" style='display:none;'>上一页</button>
	<button type='button' id='last_btn' onclick="location.href='news_list.php?now_page=<? echo $now_page+1; ?>'" <? if($page_count <= 1 ){echo "style='display:none;'";} ?>>下一页</button>
</div>
