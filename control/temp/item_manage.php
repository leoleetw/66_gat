<div class="col-lg-10 col-lg-offset-1">
	<form id='search_form' action='item_manage.php'>
		<select id='search_type' name='search_type'>
			<option value='item_name'>商品名称</option>
			<option value='store_name'>店家名称</option>
			<option value='item_id'>商品编号</option>
			<option value='store_id'>店家编号</option>
		</select>
		<input type='text' id='search_value' name='search_value' class='form-control' value=''>
		<button type='submit' class='btn btn-primary' >搜寻</button>
	</form>
</div>
<div class="col-lg-10 col-lg-offset-1">
		<table class='table'>
		<thead><tr><th>商品名称</th><th>商品图片</th><th>所属店家</th><th>分类</th><th>品牌</th><th>最新</th><th>热门</th><th>当前状态</th><th>动作</th></tr></thead>
		<tbody>
		<?
			if($_GET["now_page"]=="")
				$now_page = 1;
			else
				$now_page = $_GET["now_page"];
			$limit_count = 10;
			$sql = "select a.* , b.store_name ,b.store_id from item a inner join store b on a.store_id = b.store_id ";
			if($_GET['search_type']!=""){
				if($_GET["search_type"]=='item_name')
					$sql .= "where a.item_name like '%".$_GET["search_value"]."%' ";
				else if($_GET["search_type"]=='store_name')
					$sql .= "where b.store_name like '%".$_GET["search_value"]."%' ";
				else if($_GET["search_type"]=='item_id')
					$sql .= "where a.item_id = '".$_GET["search_value"]."' ";	
				else if($_GET["search_type"]=='store_id')
					$sql .= "where a.store_id = '".$_GET["search_value"]."' ";
			}
			$sql .= "order by shelves_date DESC";
			$result1 = mysqli_query($sqli,$sql);
			$total_count = mysqli_num_rows($result1);
			$page_count = ceil($total_count / $limit_count);
			$result = mysqli_query($sqli,$sql." limit ".($now_page-1)*$limit_count.",".$limit_count);
			while($row = mysqli_fetch_array($result)){
				$item_photo = explode("|" ,$row["item_photo"] );
		?>
				<tr id='item_tr<? echo $row["item_id"]; ?>'>
					<td>
						<a href="../item_info.php?item_id=<? echo $row["item_id"];?>" target="_blank"><? echo $row["item_name"]; ?><br><? echo $row["item_id"]; ?>
					</td>
					<td>
						<img src="../update/item_s/<? echo $item_photo[0]; ?>" style="width:100px">
					</td>
					<td>
						<a href="../store_info.php?store_id=<? echo $row["store_id"];?>" target="_blank"><? echo $row["store_name"]; ?></a>
					</td>
					<td>
						分类
					</td>
					<td>
						品牌
					</td>
					<td>
						<?
							if($row["is_new"]=="0")
								$img = "no.png";
							else
								$img = "ok.png";
						?>
						<img src="../include/images/control/<? echo $img; ?>" onclick="change_state('is_new',<? echo $row["item_id"].",".$row["is_new"]; ?>)">
					</td>
					<td>
						<?
							if($row["is_hot"]=="0")
								$img = "no.png";
							else
								$img = "ok.png";
						?>
						<img src="../include/images/control/<? echo $img; ?>" onclick="change_state('is_hot',<? echo $row["item_id"].",".$row["is_hot"]; ?>)">
					</td>
					<!--td>
						<?
							if($row["is_best"]=="0")
								$img = "no.png";
							else
								$img = "ok.png";
						?>
						<img src="../include/images/control/<? echo $img; ?>" onclick="change_state('is_best',<? echo $row["item_id"].",".$row["is_best"]; ?>)">
					</td-->
					<td>
						<?
							if($row["item_state"]=="0")
								echo "<font style='color:yellow'>仓库</font>";
							else if($row["item_state"]=="1")
								echo "<font style='color:#24D424'>架上</font>";
							else if($row["item_state"]=="9")
								echo "<font style='color:red'>强制下架</font>";
						?>
					</td>
					<td><input type="button" onclick='remove_brand(<? echo $row["brand_id"]; ?>);' class='btn btn-danger' value='强制下架'></td>
				</tr>
		<? } ?>
		</tbody>
	</table>
	<button type='button' id='next_btn' onclick="location.href='item_manage.php?<? echo "now_page=".($now_page-1)."&search_type=".$_GET["search_type"]."&search_value=".$_GET["search_value"]; ?>'" <? if($now_page == 1 ){echo "style='display:none;'";} ?>>上一页</button>
	<button type='button' id='last_btn' onclick="location.href='item_manage.php?<? echo "now_page=".($now_page+1)."&search_type=".$_GET["search_type"]."&search_value=".$_GET["search_value"]; ?>'" <? if($page_count <= 1 || $page_count == $now_page){echo "style='display:none;'";} ?>>下一页</button>
</div>

<script>
	//变更物品状态
	function change_state(this_type , item_id , state){
		$.ajax({
      url: 'ajax/item.php',
      data: 'action=change_state&this_type='+this_type+'&item_id='+item_id+"&state="+state,
      type:"POST",
      dataType:'text',

      success: function(mytext){
      	var arr = new Array();
      	arr = mytext.split("|");
      	if(arr[0]=='0'){
      		
      	}
      	else if(arr[0]=='1'){
      		alert('error');
      	}
      	else{
      		alert(mytext);
      	}
      },

       error:function(xhr, ajaxOptions, thrownError){ 
          alert(xhr.status); 
          alert(thrownError); 
       }
  	});
	}
	
	//強制下架
	
	//删除logo
	function remove_logo(){
		if(confirm("确定删除该LOGO？")){
			$.ajax({
	      url: 'ajax/brand.php',
	      data: 'action=remove_logo&brand_id='+Dd("standby").value,
	      type:"POST",
	      dataType:'text',
	
	      success: function(mytext){
	      	var arr = new Array();
	      	arr = mytext.split("|");
	      	if(arr[0]=='0'){
	      		Dd("brand_logo"+arr[1]).src = "";
	      		none("brand_logo"+arr[1]);
      			block("brand_logo_div"+arr[1]);
	      	}
	      	else if(arr[0]=='1'){
	      		alert('error');
	      	}
	      	else{
	      		alert(mytext);
	      	}
	      },
	
	       error:function(xhr, ajaxOptions, thrownError){ 
	          alert(xhr.status); 
	          alert(thrownError); 
	       }
	  	});
		}
	}
	
	//新增 修改logo
	$('#add_file_img').change(function(e){
		var formData = new FormData();
		formData.append("add_file_img", this.files[0]);
		formData.append("brand_id", Dd("standby").value);
		formData.append("action", 'change_logo');
		$.ajax({
	    type: 'post',
	    url: 'ajax/brand.php',
	    data: formData,
	    dataType:'text',
	    cache:false,
	    contentType: false,
	    processData: false,
	    success: function(mytext){
      	var arr = new Array();
      	arr = mytext.split("|");
      	if(arr[0]=='0'){
      		$("#brand_logo"+arr[1]).removeAttr("src").attr("src", "../update/brand_s/"+arr[2]+'?'+Math.random());
      		none("brand_logo_div"+arr[1]);
      		block("brand_logo"+arr[1]);
      	}
      	else if(arr[0]=='1'){
      		alert('error');
      	}
      	else{
      		alert(mytext);
      	}
      },

       error:function(xhr, ajaxOptions, thrownError){ 
          alert(xhr.status); 
          alert(thrownError); 
       }
	  });
		
	})
	
</script>