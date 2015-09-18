<style>
	.merchandise_wrapper{
	margin-right: -15px;
	position:relative;
	height:285px;
}
	.merchandise_wrapper .thumbnail{
		width: 100%;
		height:auto;
		margin-bottom: 10px;
	}
	.merchandise_wrapper .caption{
		padding-left: 5px;
	}

	.merchandise_wrapper .caption img{
		width:53px;
		height:18px;
		position:absolute;
		top:90%;
	}
	.item_price{position:absolute;top:90%;right:10%;}
	.imgOverflow{
		width: 100%;
		overflow: hidden;
	}
	.split_four{height:160px;line-height: 160px;}
	.split_three{height:220px;line-height: 220px;}
	.merchandise_wrapper img{width: 100%;}
	.storeName{position: absolute;top:80%;}
	.merchandise_wrapper:hover {
	  box-shadow:0 -2px 4px #1591ce;
  }
  .selected {
  	border : 1px solid #073970;
  }
</style>
<form id="rec_form" action="item_select.php" method="post">
	<input type='hidden' class='form-control' id='search_value' name='search_value' >
	<button type='submit' id='search_btn' class='btn btn-primary' >搜寻</button>
</form>
<div id='result_div'>
	<?
		if($_GET["now_page"]=="")
			$now_page = 1;
		else
			$now_page = intval($_GET["now_page"]);
		$limit_count = 12;
		$sql = "select * from item where item_name like '%".$_POST["search_value"]."%' order by item_id DESC ";
		$result1 = mysqli_query($sqli,$sql);
		$total_count = mysqli_num_rows($result1);
		$page_count = ceil($total_count / $limit_count);
		$result = mysqli_query($sqli,$sql." limit ".($now_page-1)*$limit_count.",".$limit_count);
		$i = 1;
		while($row = mysqli_fetch_array($result)){
		$photo_img = explode("|",$row["item_photo"]);
		if(($i % 4) == 1){
	?>
		<div class="row" style='margin-right: 15px;margin-left: 15px;'>
	<?  	} ?>
			<div class="col-xs-3 col-lg-1">
				  <div id='item_div<? echo $row["item_id"]; ?>' class="merchandise_wrapper" style='height: 220px;' onclick="selected_item(<? echo $row["item_id"]; ?>,'<? echo $photo_img[0];?>','<? echo $row["item_name"];?>');">
				      <div class="thumbnail imgOverflow split_four" style='height: 100px;line-height: 100px;'><img src="../update/item_s/<? echo $photo_img[0];?>" alt=""></div>
				    <div class="caption">
					    <p><h4><? echo $row["item_name"]; ?></h4></p>
			      </div>
				  </div>
			</div>
	<?		if(($i % 4) == 0){ ?>
			</div>
	<?
				}
				$i++;
		}
	?>
	<button type='button' id='next_btn' onclick="location.href='item_select.php?now_page=<? echo $now_page-1; ?>'" <? if($now_page == 1 ){echo "style='display:none;'";} ?>>上一页</button>
	<button type='button' id='last_btn' onclick="location.href='item_select.php?now_page=<? echo $now_page+1; ?>'" <? if($page_count <= 1 || $page_count == $now_page){echo "style='display:none;'";} ?>>下一页</button>
	<input type='text' id='selected_item' name='selected_item' value=''>
	<button type='button' id='cancel_btn' class='btn btn-danger' >取消</button>
	<button type='button' id='add_btn' class='btn btn-primary' >加入</button>
</div>
<script>
	function selected_item(item_id,photo,item_name){
		var item = new Array();
		if($('#item_div'+item_id).hasClass( "selected" )){
			var error_count = 0;
			$('#item_div'+item_id).removeClass('selected');
			item = JSON.parse($('#selected_item').val());
			for(var i = 0 ; i < item.length ; i++)
				if(item[i].item_id == item_id)
					item.splice(i,1);
		}
		else{
			$('#item_div'+item_id).addClass('selected');
			if($('#selected_item').val()==''){
				var obj = {
				    item_id : item_id,
				    photo : photo,
				    item_name : item_name
				};
				item[0] = obj;
			}
			else{
				item = JSON.parse($('#selected_item').val());
				var obj = {
				    item_id : item_id,
				    photo : photo,
				    item_name : item_name
				};
				item[item.length]=obj;
			}
			
		}
		var str = JSON.stringify(item);
		$('#selected_item').val(str);
	}
	$('#add_btn').click(function(e){
		opener.add_item($('#selected_item').val());
		self.close();
	});
	$('#cancel_btn').click(function(e){
		self.close();
	});
</script>