<div class="col-lg-6 col-lg-offset-3">
	<input type="button" id="add_btn" name="add_btn" value="新增品牌" class="btn btn-primary" data-toggle="modal" data-target="#add_Modal"  data-backdrop="static" data-keyboard=false>
	<input type="hidden" id="standby" name="standby" value="">
	<input type="file" id="add_file_img" name="add_file_img" style="display:none;">
	<table class='table'>
		<thead><tr><th>品牌名称</th><th>品牌logo</th><th>品牌叙述</th><th>动作</th></tr></thead>
		<tbody>
		<?
			$sql = "select * from brand";
			$result = mysqli_query($sqli,$sql);
			while($row = mysqli_fetch_array($result)){
				$brand_introduce = $row["brand_introduce"];
				$brand_introduce = str_replace("\n","<br>",$brand_introduce);
		?>
		<tr id='brand_tr<? echo $row["brand_id"]; ?>'>
			<td>
				<div id="brand_name_div<? echo $row["brand_id"]; ?>" onclick="none(this.id);block('brand_name<? echo $row["brand_id"]; ?>');Dd('brand_name<? echo $row["brand_id"]; ?>').focus();Dd('brand_name<? echo $row["brand_id"]; ?>').value='';Dd('brand_name<? echo $row["brand_id"]; ?>').value=Dd(this.id).innerHTML;"><? echo $row["brand_name"]; ?></div>
				<input type="text" class="form-control" id="brand_name<? echo $row["brand_id"]; ?>" value="<? echo $row["brand_name"]; ?>" style="display:none;" onblur="edit_brand('brand_name',<? echo $row["brand_id"]; ?>,this.value)" >
			</td>
			<? 
				if($row["brand_logo"]!="")
					$logo_url = "../update/brand_s/".$row["brand_logo"];
				else
					$logo_url = "";
			?>
			<td>
				<img id="brand_logo<? echo $row["brand_id"]; ?>" src="<? echo $logo_url; ?>" data-toggle="context" data-target="#logo_change_menu" onclick="Dd('standby').value=<? echo $row["brand_id"]; ?>;">
				<div id="brand_logo_div<? echo $row["brand_id"]; ?>" <? if($row["brand_logo"]!=""){ echo "style='display:none;'";} ?>>
					目前尚无logo<input type="button" onclick="add_logo(<? echo $row["brand_id"]; ?>);" class="btn btn-info" value="上传">
				</div>
			</td>
			<td>
				<div id="brand_introduce_div<? echo $row["brand_id"]; ?>" onclick="none(this.id);block('brand_introduce<? echo $row["brand_id"]; ?>');Dd('brand_introduce<? echo $row["brand_id"]; ?>').focus();"><? echo $brand_introduce; ?></div>
				<textarea class="form-control"  id="brand_introduce<? echo $row["brand_id"]; ?>" style="display:none;" onblur="edit_brand('brand_introduce',<? echo $row["brand_id"]; ?>,this.value)"><? echo $row["brand_introduce"]; ?></textarea>
			</td>
			<td><input type="button" onclick='remove_brand(<? echo $row["brand_id"]; ?>);' class='btn btn-danger' value='删除'></td>
		</tr>
		<? } ?>
		</tbody>
	</table>
</div>
<form id='add_form' action='ajax/brand.php' method="post" enctype="multipart/form-data">
	<div class="modal fade" id="add_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<h1 align='center'>新增品牌</h1>
	      </div>
	      <div class="modal-body">
	      	<font id='add_from'></font>
	      	<label>品牌名称︰</label>
	      	<input type='text' class='form-control' id='brand_name_add' name='brand_name_add' >
	      	<input type='file' id='logo_add' name='logo_add' accept="image/*">
	      	<label>品牌叙述︰</label>
	      	<textarea id="brand_introduce_add" name="brand_introduce_add" class="form-control"></textarea>
	      </div>
	      <div class="modal-footer">
	      	<input type='hidden' id='action' name='action' value='add'>
	        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	        <button type="button" class="btn btn-primary" id='add_brand_btn'>确定</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>
<div class="modal fade" id="change_logo_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      	<h1 align='center'>变更logo</h1>
      </div>
      <div class="modal-body">
      	<input type="file" id="logo_file" name="logo_file"  accept="image/*">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary" id='add_brand_btn' onclick="change_logo();">确定</button>
      </div>
    </div>
  </div>
</div>
<div id="logo_change_menu">
  <ul class="dropdown-menu" role="menu">
    <li><a tabindex="-1" href="#" onclick="change_logo();">变更照片</a></li>
    <li><a tabindex="-1" href="#" onclick="remove_logo();">移除照片</a></li>
  </ul>
</div>
<script>
	//新增品牌
	$('#add_brand_btn').click(function(e){
		$('#add_Modal').modal('hide');
		if(Dd('brand_name_add').value.trim()==""){
			alert('品牌名称为空不得新增');
			Dd('add_form').reset();
		}
		else
			Dd('add_form').submit();
	})
	
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
	
	function add_logo(brand_id){
		Dd('standby').value=brand_id;
		$('#add_file_img').click();
	}
	
	function change_logo(){
		$('#add_file_img').click();
	}
	
	//变更品牌内容
	function edit_brand(this_target , brand_id , this_value){
		$.ajax({
	      url: 'ajax/brand.php',
	      data: 'action=rename&brand_id='+brand_id+"&target="+this_target+"&value="+this_value,
	      type:"POST",
	      dataType:'text',
	
	      success: function(mytext){
	      	var arr = new Array();
	      	arr = mytext.split("|");
	      	if(arr[0]=='0'){
	      		if(arr[2]=='brand_name')
	      			Dd(arr[2]+"_div"+arr[1]).innerHTML=arr[3];
	      		else{
	      			var str = arr[3].replace(/\n/g, "<br>");
	      			Dd(arr[2]+"_div"+arr[1]).innerHTML=str;
	      		}
	      		none(arr[2]+arr[1]);
	      		block(arr[2]+"_div"+arr[1]);
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
	
	//删除品牌
	function remove_brand(brand_id){
		if(confirm("确定删除该品牌？")){
			$.ajax({
	      url: 'ajax/brand.php',
	      data: 'action=remove_brand&brand_id='+brand_id,
	      type:"POST",
	      dataType:'text',
	
	      success: function(mytext){
	      	var arr = new Array();
	      	arr = mytext.split("|");
	      	if(arr[0]=='0'){
	      		$("#brand_tr"+arr[1]).remove();
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
</script>