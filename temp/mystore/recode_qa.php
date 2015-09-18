<?
	include_once("include/dbinclude.php");
?>

<div id="order_div" class='col-lg-11 col-lg-offset-1 recodeWrapper'>
	<font>查询︰</font>
	<input type="text" id="start_date" class="form-control" value="<? echo date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) ); ?>" readonly>～
	<input type="text" id="end_date" class="form-control" value="<? echo date("Y-m-d"); ?>" readonly>
	<button type="button" id="search_btn" class="btn btn-primary gat_green qa_button" >确定</button>
	<select id='qa_state' name='qa_state'>
		<option value='all'>全部</option>
		<option value='reply_yet'>未回覆</option>
		<option value='reply'>已回覆</option>
	</select>
	<input type='hidden' id='now_page' name='now_page' value='10'>
	<input type='hidden' id='qa_state' name='qa_state' value='all'>
	<input type='hidden' id='limit_count' name='limit_count' value='10'>
	<div id='qa_content_div'>
		<?
			$sql = "select a.* , d.item_name , d.item_photo , b.user_nick from qa a
		    	inner join item d on d.item_id = a.item_id
		    	left join user b on a.user_id = b.user_id
		    	left join store c on c.store_id = d.store_id
		    	where c.user_id = ".$_SESSION["user_id"]." order by a.q_creatdate desc";
		  $rs_count = mysqli_query($sqli,$sql);
		  $total_count = mysqli_num_rows($rs_count);
		  $page_count = ceil($total_count / 10);
			$result = mysqli_query($sqli,$sql." limit 0,10");
			while($row = mysqli_fetch_array($result)){
				$item_photo = explode("|",$row["item_photo"]);
		?>
		<div class='row qaWrapper'>
			<div class='col-lg-3'>
				<div class="qaPhoto_wrapper"><img src='update/item_s/<? echo $item_photo[0];?>'></div>
				<font class="qaItemName"><a href="item_info.php?item_id=<? echo $row["item_id"]; ?>" target="_blank"><? echo $row["item_name"]; ?></a></font>
			</div>
			<div class='col-lg-9 qaContent qaGreenBorder'>
				<div class="qText">
					<p>买家问题︰
						<a href="user_info.php?user_id=<? echo $row["user_id"];?>" target="_blank"><? echo $row["user_nick"];?></a>
						<font class="qaDate"><? echo $row["q_creatdate"];?></font>
					</p>
					<p><? echo $row["q_content"];?></p>
				</div>
				<?
					if($row["a_content"]!="" && $row["a_creatdate"] != "0000-00-00 00:00:00"){
				?>
				<div class="aText_green">
					<p>我的回覆︰<font class="qaDate"><? echo $row["a_creatdate"];?></font></p>
					<p><? echo $row["a_content"];?></p>
				</div>
				<? } ?>
			</div>
			<a class='btn btn-primary qaEdit' id='' onclick='show_qa_modal(<? echo $row["qa_id"]; ?>);'></a>
		</div>
		<? } ?>
	</div>
	<button type='button' id='last_btn' class='btn btn-primary' style='display:none;'>上一页</button>
	<button type='button' id='next_btn' class='btn btn-primary' <? if($page_count <= 1){echo "style='display:none;'";} ?> >下一页</button>
</div>
<div class="modal fade" id="qa_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      	<h1 align='center'>问题回覆</h1>
      </div>
      <div class="modal-body">
      	<input type='hidden' id='reply_qa_id' value=''>
      	<font style='color:red;'>字数限制（250字）</font>
      	<textarea id='qa_reply_content' class='form-control'></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary" id='qa_reply_btn' onclick="qa_reply();">确定</button>
      </div>
    </div>
  </div>
</div>
<script>
	function show_qa_modal(qa_id){
		$('#reply_qa_id').val(qa_id);
		$('#qa_Modal').modal({
			backdrop:"static",
			keyboard:false
		});
	}
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

	function qa_content(myjson){
		var str = "";
		var item_photo = new Array();
		for(var i = 0 ; i < myjson.qa.length ; ++i){
			item_photo = myjson.qa[i].item_photo.split("|");
			str += "<div class='row panel panel-default'>";
			str += "	<div class='panel-heading'>";
			str += "    <button type='button' class='btn btn-primary' id='' onclick='show_qa_modal("+myjson.qa[i].qa_id+");' >回覆/编辑</button>";
			str += "  </div>";
			str += "  <div class='panel-body'>";
			str += "		<div class='col-lg-4'><img src='update/item_s/"+item_photo[0]+"' style='width:100px;'>"+myjson.qa[i].item_name+"</div>";
			str += "		<div class='col-lg-8'>";
			str += "			<div class='col-lg-12'>";
			str += "				<div>买家问题︰"+myjson.qa[i].user_nick+"</div>";
			str += "				<div>"+myjson.qa[i].q_creatdate+"</div>";
			str += "				<div>"+myjson.qa[i].q_content+"</div>";
			str += "			</div>"
			if(myjson.qa[i].a_content!="" && myjson.qa[i].a_creatdate != "0000-00-00 00:00:00"){
				str += "				<div class='col-lg-12'>";
				str += "					<div>我的回覆︰</div>";
				str += "					<div>"+myjson.qa[i].a_creatdate+"</div>";
				str += "					<div>"+myjson.qa[i].a_content+"</div>";
				str += "				</div>";
			}
			str += "		</div>";
			str += "	</div>";
			str += "</div>";
		}
		$('#qa_content_div').html(str);
		if($('#now_page').val()!='1')
			block('last_btn');
		else
			none('last_btn');
		if(myjson.page_count > parseInt($('#now_page').val()))
			block('next_btn');
		else
			none('next_btn');
	}
	$('#search_btn').click(function(e){
		$('#now_page').val('1');
		$('#qa_state').val('all');
		$.ajax({
      url: 'ajax/qanda.php',
      data: 'action=get_qa&qa_state='+$('#qa_state').val()+'&limit_count='+$('#limit_count').val()+'&now_page='+$('#now_page').val()+'&start_date='+$('#start_date').val()+'&end_date='+$('#end_date').val(),
      type:"POST",
      dataType:'JSON',

      success: function(myjson){
      	if(myjson.length == 0)
      		alert("查无资料");
      	else{
      		qa_content(myjson);
      	}
      },

       error:function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
       }
  	});
	});
	$('#next_btn').click(function(e){
		$('#now_page').val((parseInt($('#now_page').val())+1));
		$.ajax({
      url: 'ajax/qanda.php',
      data: 'action=get_qa&qa_state='+$('#qa_state').val()+'&limit_count='+$('#limit_count').val()+'&now_page='+$('#now_page').val()+'&start_date='+$('#start_date').val()+'&end_date='+$('#end_date').val(),
      type:"POST",
      dataType:'JSON',

      success: function(myjson){
      	if(myjson.length == 0)
      		alert("查无资料");
      	else{
      		qa_content(myjson);
      	}
      },

       error:function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
       }
  	});
	});
	$('#last_btn').click(function(e){
		$('#now_page').val((parseInt($('#now_page').val())-1));
		$.ajax({
      url: 'ajax/qanda.php',
      data: 'action=get_qa&qa_state='+$('#qa_state').val()+'&limit_count='+$('#limit_count').val()+'&now_page='+$('#now_page').val()+'&start_date='+$('#start_date').val()+'&end_date='+$('#end_date').val(),
      type:"POST",
      dataType:'JSON',

      success: function(myjson){
      	if(myjson.length == 0)
      		alert("查无资料");
      	else{
      		qa_content(myjson);
      	}
      },

       error:function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
       }
  	});
	});
	$('#qa_state').change(function(e){
		$('#now_page').val('1');
		$.ajax({
      url: 'ajax/qanda.php',
      data: 'action=get_qa&qa_state='+$('#qa_state').val()+'&limit_count='+$('#limit_count').val()+'&now_page='+$('#now_page').val()+'&start_date='+$('#start_date').val()+'&end_date='+$('#end_date').val(),
      type:"POST",
      dataType:'JSON',

      success: function(myjson){
      	if(myjson.length == 0)
      		alert("查无资料");
      	else{
      		qa_content(myjson);
      	}
      },

       error:function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
       }
  	});
	});
	$('#last_btn').click(function(e){
		$('#now_page').val((parseInt($('#now_page').val())-1));
		$.ajax({
      url: 'ajax/qanda.php',
      data: 'action=get_qa&qa_state='+$('#qa_state').val()+'&limit_count='+$('#limit_count').val()+'&now_page='+$('#now_page').val()+'&start_date='+$('#start_date').val()+'&end_date='+$('#end_date').val(),
      type:"POST",
      dataType:'JSON',

      success: function(myjson){
      	if(myjson.length == 0)
      		alert("查无资料");
      	else{
      		qa_content(myjson);
      	}
      },

       error:function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
       }
  	});
	});
	$('#qa_reply_btn').click(function(e){
		if($('#qa_reply_content').val().trim()=="")
			alert("回答内容不得为空");
		else if($('#qa_reply_content').val().length > 250)
			alert("回答长度不得超过250");
		else{
			$.ajax({
	      url: 'ajax/item.php',
	      data: 'action=reply_qa&a_content='+$('#qa_reply_content').val().trim()+'&qa_id='+$('#reply_qa_id').val(),
	      type:"POST",
	      dataType:'text',

	      success: function(mytext){
	      	//回覆问题 在进行一次重整 利用AJAX
	      	var arr = new Array();
	      	arr = mytext.split("|");
	      	if(arr[0]=='0')
	      		alert('ok');
	      	else
	      		alert(mytext);
	      },

	       error:function(xhr, ajaxOptions, thrownError){
	          alert(xhr.status);
	          alert(thrownError);
	       }
	  	});
		}
	});
</script>