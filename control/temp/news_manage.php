<div class="col-lg-6 col-lg-offset-3" id='news_list_div'>
	<button type="button" id="add_btn" name="add_btn">新增消息</button>
	<table class='table'>
		<tr><th>消息标题</th><th>封面图片</th><th>开放时间</th><th>结束时间</th></tr>
		<?
			if($_GET["now_page"]=="")
				$now_page = 1;
			else
				$now_page = $_GET["now_page"];
			$limit_count = 20;
			$sql = "select * from news order by news_id DESC";
			$result1 = mysqli_query($sqli,$sql);
			$total_count = mysqli_num_rows($result1);
			$page_count = ceil($total_count / $limit_count);
			$result = mysqli_query($sqli,$sql." limit ".($now_page-1)*$limit_count.",".$limit_count);
			while($row = mysqli_fetch_array($result)){
		?>
		<tr onclick='show_news(<? echo $row["news_id"];?>);'>
			<td>
				<a onclick=''><? echo $row["news_title"]; ?></a>
			</td>
			<td>
				<? echo $row["news_cover"]; ?>
			</td>
			<td>
				<? echo $row["start_date"]; ?>
			</td>
			<td>
				<? echo $row["end_date"]; ?>
			</td>
		</tr>
		<? } ?>
	</table>
	<button type='button' id='next_btn' onclick="location.href='news_manage.php?now_page=<? echo $now_page-1; ?>'" <? if($now_page == 1 ){echo "style='display:none;'";} ?>>上一页</button>
	<button type='button' id='last_btn' onclick="location.href='news_manage.php?now_page=<? echo $now_page+1; ?>'" <? if($page_count <= 1 || $page_count == $now_page){echo "style='display:none;'";} ?>>下一页</button>
</div>
<div class="col-lg-6 col-lg-offset-3" id='news_info_div' style='display:none;'>
	<form id="news_form" action="ajax/news.php" method="post" enctype="multipart/form-data">
		<table class='table'>
			<input type='hidden' id='news_id' name='news_id' value=''>
			<input type='hidden' id='action' name='action' value='add'>
			<tr><td>标题</td><td><input type='text' id='news_title' name='news_title' class='form-control' value=''></td></tr>
			<tr><td>开始时间</td><td><input type='text' id='start_date' name='start_date' class='form-control' value='' readonly></td></tr>
			<tr><td>结束时间</td><td><input type='text' id='end_date' name='end_date' class='form-control' value='' readonly></td></tr>
			<tr><td>封面图片</td><td><img src='' style='width:150px;display:none;' id='news_cover_img'><input type='file' id='news_cover' name='news_cover' class="file" accept="image/*" data-show-upload="false" data-show-caption="true"></td></tr>
			<tr><td>内文</td><td><textarea id='news_content' name='news_content' class='textarea form-control' style='width:100%;height:700px;'></textarea></td></tr>
			<tr><td colspan='2'><button type='button' id='back_btn' class='btn btn-primary'>回上页</button><button type='submit' id='save_btn' class='btn btn-primary'>储存</button></td></tr>
		</table>
	</form>
</div>
<script>
	var opt={
   dayNames:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"],
   dayNamesMin:["日","一","二","三","四","五","六"],
   monthNames:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
   monthNamesShort:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
   prevText:"上月",
   nextText:"次月",
   weekHeader:"週",
   showMonthAfterYear:true,
   dateFormat:"yy-mm-dd"
   };
	$( "#start_date" ).datepicker(opt);
	$( "#end_date" ).datepicker(opt);
	tinymce.init({
		mode : "specific_textareas",
    editor_selector : "textarea",
    language:"zh_CN",
    //selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
	});
	$('#add_btn').click(function(e){
		Dd('news_form').reset();
		$('#action').val('add');
		none('news_list_div');
		block('news_info_div');
	});
	$('#back_btn').click(function(e){
		Dd('news_form').reset();
		none('news_cover_img');
		$('#action').val('add');
		none('news_info_div');
		block('news_list_div');
	});
	function show_news(news_id){
		$.ajax({
      url: 'ajax/news.php',
      data: 'action=get_news&news_id='+news_id,
      type:"POST",
      dataType:'JSON',

      success: function(myjson){
      	$('#news_id').val(myjson.news_id);
      	$('#news_title').val(myjson.news_title);
      	$('#start_date').val(myjson.start_date);
      	$('#end_date').val(myjson.end_date);
      	$('#news_cover_img').attr('src','../update/news/'+myjson.news_cover+'?'+Math.random());
      	block('news_cover_img');
      	tinyMCE.get('news_content').setContent(myjson.news_content);
      	$('#action').val('edit');
      	none('news_list_div');
				block('news_info_div');
      },

       error:function(xhr, ajaxOptions, thrownError){ 
          alert(xhr.status); 
          alert(thrownError); 
       }
  	});
	}
</script>