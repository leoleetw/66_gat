<?
	include_once("include/dbinclude.php");
?>

<div id="order_div" class='col-lg-11 col-lg-offset-1 recodeWrapper'>
	<font>查询︰</font>
	<input type="text" id="start_date" class="form-control blueBorder" value="<? echo date("Y-m-d"); ?>" readonly>～
	<input type="text" id="end_date" class="form-control blueBorder" value="<? echo date("Y-m-d"); ?>" readonly>
	<button type="button" id="search_btn" class="btn btn-primary gat_blue qa_button" >确定</button>
	<div id='qa_div'>
		<?
			$sql = "select a.* , d.item_name , d.item_photo , c.store_name , c.store_id from qa a
		    	inner join item d on d.item_id = a.item_id
		    	left join user b on a.user_id = b.user_id
		    	left join store c on c.store_id = d.store_id
		    	where a.user_id = ".$_SESSION["user_id"]." order by a.q_creatdate desc limit 0,10";
			$result = mysqli_query($sqli,$sql);
			while($row = mysqli_fetch_array($result)){
				$item_photo = explode("|",$row["item_photo"]);
		?>
		<div class="qaWrapper row">
			<div class="col-lg-3">
				<div class="qaPhoto_wrapper"><img src="update/item_s/<? echo $item_photo[0];?>"></div>
				<font class="qaItemName"><a href="item_info.php?item_id=<? echo $row["item_id"]; ?>" target="_blank"><? echo $row["item_name"]; ?></a></font>
			</div>
			<div class="col-lg-9 qaContent qaBlueBorder">
				<div class="qText">
					<p>我的问题：<font class="qaDate"><?	echo $row["q_creatdate"]; ?></font></p>
					<p><?	echo $row["q_content"]; ?></p>
				</div>
				<?	if($row["a_content"]!="" && $row["a_creatdate"] != "0000-00-00 00:00:00"){	?>
				<div class="aText">
					<p>店家回覆：
						<a href="store_info.php?store_id=<? echo $row["store_id"]; ?>" target="_blank"><? echo $row["store_name"];	?></a>
						<font class="qaDate"><? echo $row["a_creatdate"];?></font>
					</p>
					<p><? echo $row["a_content"];?></p>
				</div>
				<?	}	?>
			</div>
		</div>
		<?	}	?>
	</div>
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
	$('#search_btn').click(function(e){
		$.ajax({
      url: 'ajax/qanda.php',
      data: 'action=my_get_qa&start_date='+$('#start_date').val()+'&end_date='+$('#end_date').val(),
      type:"POST",
      dataType:'JSON',

      success: function(myjson){
      	var str = "";
      	if(myjson.length == 0)
      		alert("查无资料");
      	else{
      		var item_photo = new Array();
      		for(var i = 0 ; i < myjson.length ; ++i){
	      		item_photo = myjson[i].item_photo.split("|");
	      		str += "<div class='qaWrapper row'>";
						str += "	<div class='col-lg-3'>";
						str += "		<div class='qaPhoto_wrapper'><img src='update/item_s/"+item_photo[0]+"'></div>";
						str += "		<font class='qaItemName'><a href='item_info.php?item_id="+myjson[i].item_id+"' target='_blank'>"+myjson[i].item_name+"</a></font>";
						str += "	</div>";
						str += "	<div class='col-lg-9 qaContent'>";
						str += "		<div class='qText'>";
						str += "			<p>我的问题：<font class='qaDate'>"+myjson[i].q_creatdate+"</font></p>";
						str += "			<p>"+myjson[i].q_content+"</p>";
						str += "		</div>";
						if(myjson[i].a_content != "" && myjson[i].a_creatdate != "0000-00-00 00:00:00"){
							str += "		<div class='aText'>";
							str += "			<p>店家回覆：";
							str += "				<a href='store_info.php?store_id="+myjson[i].store_id+"' target='_blank'>"+myjson[i].store_name+"</a>";
							str += "				<font class='qaDate'>"+myjson[i].a_creatdate+"</font>";
							str += "			</p>";
							str += "			<p>"+myjson[i].a_content+"</p>";
							str += "		</div>";
						}
						str += "	</div>";
						str += "</div>";

	      	}
	      	$('#qa_div').html(str);
      	}
      },

       error:function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
       }
  	});
	});
</script>