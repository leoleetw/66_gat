<?
	include_once("include/dbinclude.php");
	$sql_news = "select * from news where news_id = ".$_GET["news_id"]." ";
	$result_news = mysqli_query($sqli,$sql_news);
	$row_news = mysqli_fetch_array($result_news);
	$start_date = strtotime($row_news["start_date"]);
	$end_date = strtotime($row_news["end_date"]);
	$now = strtotime(date("Y-m-d"));
	if($now < $start_date || $now > $end_date){
		header("Location: news_list.php");
	}
	else{
?>
		<div class="col-lg-12">
			<div class="newsBanner">最新消息 NEWS</div>
		</div>
		<?
			include_once("temp/nav.php");
		?>
		<div class="col-lg-9">
			<div class="newsInfo">
				<div class="newsTitleBox">
					<div class="newsTitle"><? echo $row_news["news_title"];?></div>
					<div class="newsDate"><? echo $row_news["start_date"];?></div>
				</div>
				<div class="newsContent">
					<? echo $row_news["news_content"];?>
				</div>
				<div class="backButton"><button type='button' id='back_list_btn' onclick="location.href='news_list.php'" class='btn btn-danger'>返回列表頁</button></div>
				<div class="preNextButton">
					<div class="news_pre">
						<?
							$sql = "select * from news where news_id > ".$_GET["news_id"]." AND (CURRENT_DATE() between start_date and end_date) order by news_id;";
							$result = mysqli_query($sqli,$sql);
							$count = mysqli_num_rows($result);
							if($count != 0){
								$row = mysqli_fetch_array($result);
						?>
							<a href='news_info.php?news_id=<? echo $row["news_id"];?>'>
								<div class="pre_link"><img src="update/news_s/<? echo $row["news_cover"];?>"></div>
								<div class="pre_title"><? echo $row["news_title"];?></div>
							</a>
						<?
							}
						?>
					</div>
					<div class="news_next">
						<?
							$sql = "select * from news where news_id < ".$_GET["news_id"]." AND (CURRENT_DATE() between start_date and end_date) order by news_id DESC;";
							$result = mysqli_query($sqli,$sql);
							$count = mysqli_num_rows($result);
							if($count != 0){
								$row = mysqli_fetch_array($result);
						?>
							<a href='news_info.php?news_id=<? echo $row["news_id"];?>'>
								<div class="next_link"><img src="update/news_s/<? echo $row["news_cover"];?>"></div>
								<div class="next_title"><? echo $row["news_title"];?></div>
							</a>
						<?
							}
						?>
					</div>
				</div>

				<!--<div class="preNextButton">
				<?
						$sql = "select * from news where news_id > ".$_GET["news_id"]." AND (CURRENT_DATE() between start_date and end_date) order by news_id;";
						$result = mysqli_query($sqli,$sql);
						$count = mysqli_num_rows($result);
						if($count != 0){
							$$row = mysqli_query($sqli,$sql);
				?>
							<button type='button' id='last_btn' onclick="location.href='news_info.php?news_id=<? $row["news_id"];?>'">上一则</button>
				<?
						}
				?>
				<?
						$sql = "select * from news where news_id < ".$_GET["news_id"]." AND (CURRENT_DATE() between start_date and end_date) order by news_id DESC;";
						$result = mysqli_query($sqli,$sql);
						$count = mysqli_num_rows($result);
						if($count != 0){
							$$row = mysqli_query($sqli,$sql);
				?>
							<button type='button' id='last_btn' onclick="location.href='news_info.php?news_id=<? $row["news_id"];?>'">下一则</button>
				<?
						}
					}
				?>-------->
				</div>
			</div>
		</div>