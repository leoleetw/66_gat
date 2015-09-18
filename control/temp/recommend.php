<style>
	.merchandise_wrapper{
		width:160px;
		height:220px;
		float:left;
		margin-right:10px;
		margin-top:10px;
		position:relative;
	}
	.merchandise_wrapper .caption{
		padding-left: 5px;
	}

	.imgOverflow{
		width: 100%;
		height:160px;
		line-height:160px;
		overflow: hidden;
	}
	.merchandise_wrapper img{width: 100%;}
	.merchandise_wrapper span{
		width:30px;height:30px;
		background:#fff;
		border-radius:4px;
		position:absolute;
		top:10px;right:10px;
		text-align:center;
		line-height:30px;
	}
</style>
<div class="col-lg-6 col-lg-offset-3" id='rec_list_div'>
	<button type="button" id="add_btn" name="add_btn">新增推荐</button>
	<table class='table'>
		<tr><th>推荐标题</th><th>封面图片</th><th>推荐时间</th></tr>
		<?
			if($_GET["now_page"]=="")
				$now_page = 1;
			else
				$now_page = $_GET["now_page"];
			$limit_count = 20;
			$sql = "select * from recommend order by rec_id DESC";
			$result1 = mysqli_query($sqli,$sql);
			$total_count = mysqli_num_rows($result1);
			$page_count = ceil($total_count / $limit_count);
			$result = mysqli_query($sqli,$sql." limit ".($now_page-1)*$limit_count.",".$limit_count);
			while($row = mysqli_fetch_array($result)){
		?>
		<tr onclick='show_rec(<? echo $row["rec_id"];?>);'>
			<td>
				<a onclick=''><? echo $row["rec_title"]; ?></a>
			</td>
			<td>
				<? echo $row["rec_cover"]; ?>
			</td>
			<td>
				<? echo $row["start_date"]."～".$row["end_date"]; ?>
			</td>
		</tr>
		<? } ?>
	</table>
	<button type='button' id='next_btn' onclick="location.href='recommend.php?now_page=<? echo $now_page-1; ?>'" <? if($now_page == 1 ){echo "style='display:none;'";} ?>>上一页</button>
	<button type='button' id='last_btn' onclick="location.href='recommend.php?now_page=<? echo $now_page+1; ?>'" <? if($page_count <= 1 || $page_count == $now_page){echo "style='display:none;'";} ?>>下一页</button>
</div>
<div class="col-lg-6 col-lg-offset-3" id='rec_info_div' style='display:none;'>
	<form id="rec_form" action="ajax/recommend.php" method="post" enctype="multipart/form-data">
		<table class='table'>
			<input type='hidden' id='rec_id' name='rec_id' value=''>
			<input type='hidden' id='action' name='action' value='add'>
			<tr><td>标题</td><td><input type='text' id='rec_title' name='rec_title' class='form-control' value=''></td></tr>
			<tr>
				<td>推荐时间</td>
				<td>
					<input type='text' id='week_date' name='week_date' class='form-control week-picker' value='' readonly>
					<input type='hidden' id='start_date' name='start_date' value=''>
					<input type='hidden' id='end_date' name='end_date' value=''>
				</td>
			</tr>
			<tr>
				<td>推荐商品</td>
				<td>
					<button type='button' id='add_item_btn' class='btn btn-primary'>新增商品</button>
					<input type='hidden' id='rec_item' name='rec_item' >
					<div style='border:1px;' id='item_div'></div>
				</td>
			</tr>
			<tr><td>封面图片</td><td><img src='' style='width:150px;display:none;' id='rec_cover_img'><input type='file' id='rec_cover' name='rec_cover' class="file" accept="image/*" data-show-upload="false" data-show-caption="true"></td></tr>
			<tr><td>内文</td><td><textarea id='rec_content' name='rec_content' class='textarea form-control' style='width:100%;height:700px;'></textarea></td></tr>
			<tr><td colspan='2'><button type='button' id='back_btn' class='btn btn-primary'>回上页</button><button type='submit' id='save_btn' class='btn btn-primary'>储存</button></td></tr>
		</table>
	</form>
</div>
<script>
  $('.week-picker').datepicker( {
  		dayNames:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"],
			dayNamesMin:["日","一","二","三","四","五","六"],
			monthNames:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
			monthNamesShort:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
			prevText:"上月",
			nextText:"次月",
			weekHeader:"週",
			showMonthAfterYear:true,
			dateFormat:"yy-mm-dd",
      showOtherMonths: true,
      selectOtherMonths: true,
      onSelect: function(dateText, inst) {
          var date = $(this).datepicker('getDate');
          var startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
          var endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);
          var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
          $('#start_date').val($.datepicker.formatDate( dateFormat, startDate, inst.settings ));
          $('#end_date').val($.datepicker.formatDate( dateFormat, endDate, inst.settings ));
          $('#week_date').val($('#start_date').val()+"～"+$('#end_date').val());
      }
  });
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
		Dd('rec_form').reset();
		$('#action').val('add');
		none('rec_list_div');
		block('rec_info_div');
	});
	$('#back_btn').click(function(e){
		Dd('rec_form').reset();
		none('rec_cover_img');
		$('#action').val('add');
		none('rec_info_div');
		block('rec_list_div');
	});
	function show_rec(rec_id){
		$.ajax({
      url: 'ajax/recommend.php',
      data: 'action=get_rec&rec_id='+rec_id,
      type:"POST",
      dataType:'JSON',

      success: function(myjson){
      	var str = "";
      	$('#rec_id').val(myjson.rec_id);
      	$('#rec_title').val(myjson.rec_title);
      	$('#start_date').val(myjson.start_date);
      	$('#end_date').val(myjson.end_date);
      	$('#week_date').val(myjson.start_date+"～"+myjson.end_date);
      	$('#rec_item').val(myjson.rec_item);
      	$('#rec_cover_img').attr('src','../update/recommend/'+myjson.rec_cover+'?'+Math.random());
      	for(var i = 0 ; i < myjson.item.length ; ++i){
      		str += "<div id='item_div"+myjson.item[i].item_id+"' class='merchandise_wrapper'>";
				  str += "  <div class='thumbnail'><div class='imgOverflow'><img src='../update/item_s/"+myjson.item[i].item_photo+"' ><span onclick=remove_item("+myjson.item[i].item_id+");>X</span></div></div>";
				  str += "  <div class='caption'>";
					str += "    <p><h4>"+myjson.item[i].item_name+"</h4></p>";
			    str += "  </div>";
				  str += "</div>";
      	}
      	$('#item_div').html(str);
      	block('rec_cover_img');
      	tinyMCE.get('rec_content').setContent(myjson.rec_content);
      	$('#action').val('edit');
      	none('rec_list_div');
				block('rec_info_div');
      },

       error:function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
       }
  	});
	}
	function remove_item(item_id){
		var rec_item = new Array();
		rec_item = $('#rec_item').val().split("|");
		var remove_index = $.inArray( item_id.toString(), rec_item );
		rec_item.splice(remove_index,1);
		$('#rec_item').val(rec_item.join("|"));
		$('#item_div'+item_id).remove();
	}
	$('#add_item_btn').click(function(e){
		window.open("item_select.php", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=0, left=500, width=500, height=760");
	});
	function add_item(myjson){
		var item = new Array();
		var str = "";
		var rec_item = new Array();
		item = JSON.parse( myjson );
		if($('#rec_item').val()!=""){
			rec_item = $('#rec_item').val().split("|");
			for(var i = 0 ; i < item.length ; ++i){
				if($.inArray( item[i].item_id.toString() , rec_item ) < 0 ){
					str += "<div id='item_div"+item[i].item_id+"' class='merchandise_wrapper'>";
				  str += "  <div class='thumbnail'><div class='imgOverflow'><img src='../update/item_s/"+item[i].photo+"' ><span onclick=remove_item("+item[i].item_id+");>X</span></div></div>";
				  str += "  <div class='caption'>";
					str += "    <p><h4>"+item[i].item_name+"</h4></p>";
			    str += "  </div>";
				  str += "</div>";
				  rec_item[rec_item.length]=item[i].item_id;
				}
			}
		}
		else{
			for(var i = 0 ; i < item.length ; ++i){
					str += "<div id='item_div"+item[i].item_id+"' class='merchandise_wrapper'>";
				  str += "  <div class='thumbnail'><div class='imgOverflow'><img src='../update/item_s/"+item[i].photo+"' ><span onclick=remove_item("+item[i].item_id+");>X</span></div></div>";
				  str += "  <div class='caption'>";
					str += "    <p><h4>"+item[i].item_name+"</h4></p>";
			    str += "  </div>";
				  str += "</div>";
				  rec_item[i]=item[i].item_id;
			}
		}
		$('#rec_item').val(rec_item.join("|"));
		$('#item_div').html($('#item_div').html()+str);
	}
</script>