
<div class="col-lg-12">
	<form id="search_form" action="">
		<div class="col-lg-2 col-lg-offset-6">
			<select class="form-control" id="search_type" name="search_type">
				<option value="keyword">关键字</option>
				<option value="price">价格带</option>
			</select>
		</div>
		<div class="col-lg-3">
			<div id="search_div1"><input type="text" class="form-control" id="search_value" name="search_value" value=""></div>
			<div id="search_div2" style="display:none;">
				<input type="text" class="form-control" id="search_value1" name="search_value1" value="" style="width:48%;float:left;">
				~
				<input type="text" class="form-control" id="search_value2" name="search_value2" value="" style="width:48%;float:right;">
			</div>
		</div>
		<div class="col-lg-1"><button type="button" id="search_btn" name="search_btn" class="btn btn-primary" >搜寻</button></div>
	</form>
</div>
<div class="col-lg-3">
	<div class="row">
		<nav>
			<div id="item_list"><img src="include/images/product_02.png"></div>
			<div class="nav_wrapper">
				<ul id="nav_wrapper">
				<?
					$sql = "select * from category where rank = 1";
					$result = mysqli_query($sqli,$sql);
					while($row = mysqli_fetch_array($result)){
						echo "<li><h4>".$row["cate_name"]."</h4><ul>";//a href='item_list.php?cate_id=".$row["cate_id"]."'
						$sql_sub = "select * from category where parent_id='".$row["cate_id"]."'";
						$result_sub = mysqli_query($sqli,$sql_sub);
						while($row_sub = mysqli_fetch_array($result_sub)){
							echo "<li><a href='item_list.php?cate_id=".$row_sub["cate_id"]."'> ".$row_sub["cate_name"]."</a></li>";
						}
						echo "<li><a href='item_list.php?cate_id=".$row["cate_id"]."'> 分类全商品</a></li>";
						echo "</ul></li>";
					}
				?>
				</ul>
				<a href='item_list.php'> 全商品一览</a>

			</div>
			<div id="brand_info"><img src="include/images/brand_02.png"></div>
			<div class="brand_nav_wrapper">

				<?
					$sql = "select * from brand";
					$result = mysqli_query($sqli,$sql);
					while($row = mysqli_fetch_array($result)){
						echo "<li><h4><a href='brand_info.php?brand_id=".$row["brand_id"]."'> ".$row["brand_name"]."</a></h4></li>";
					}
				?>
				<a href='brand_list.php'> 全部品牌</a>
			</div>
		</nav>
	</div>
</div>

<script>
$(document).ready(function(e) {
    	var clickNo = -1;
    $('#nav_wrapper>li>h4').click(function(){
		if($(this).parent().index() !=clickNo ){
			$('#nav_wrapper>li>ul').stop(true,true).slideUp('fast');
			$(this).next().stop(true,true).slideToggle('fast');//slideDown
			clickNo = $(this).parent().index();
		}else{
			$('#nav_wrapper>li>ul').stop(true,true).slideUp('fast');
			clickNo = -1;
		}
	});
});

	$('#search_btn').click(function(e){

		var check = false;
		if($('#search_type').val()=='price'){
			if($('#search_value1').val().trim()!="" &&  $('#search_value2').val().trim()!="")
				check = true;
		}
		else{
			if($('#search_value').val().trim()!="")
				check = true;
		}

		if(!check)
			alert('搜寻值不得为空');
		else{
			var str = "?search_type="+$('#search_type').val();
			if($('#search_type').val()=='price')
				str += "&price1="+$('#search_value1').val()+"&price2="+$('#search_value2').val();
			else
				str += "&search_value="+$('#search_value').val();
			document.location.href='item_list.php'+str;
		}
	});

	$('#search_type').change(function(e){

		if($('#search_type').val()=='price'){
			none('search_div1');
			$('#search_value').val('');
			block('search_div2');
		}
		else{
			none('search_div2');
			$('#search_value1').val('');
			$('#search_value2').val('')
			block('search_div1');
		}
	});
</script>
