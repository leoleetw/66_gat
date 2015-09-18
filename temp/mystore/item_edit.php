<?
	include_once("include/dbinclude.php");
	$sql_item = "select a.* , b.user_id , c.parent_id from item a
		inner join store b on a.store_id = b.store_id
		inner join category c on a.cate_id = c.cate_id
		where a.item_id =".$_GET["item_id"];
	$result_item = mysqli_query($sqli,$sql_item);
	$row_item = mysqli_fetch_array($result_item);
	if($row_item["user_id"]!=$_SESSION["user_id"]){
		$_SESSION["errnumber"]=1;
		$_SESSION["msg"]="请勿乱入他人商品";
		header("Location: index.php");
	}

?>
<div id="item_div" class='col-lg-12'>
	<form id="item_form" action="ajax/item.php" method="post" enctype="multipart/form-data">
		<input type="hidden" id="item_id" name="item_id" value="<? echo $_GET["item_id"];?>">
		<input type="hidden" id="from" name="from" value="">
		<div class="row">
			<div class="keyIn_wrapper">
				<div class='col-lg-2' style="text-align:right;"><font style="color:red">＊</font><font class="keyIn_text">商品名称︰</font></div>
				<div class='col-lg-10 keyIn_underline'><input type="text" class="form-control" id="item_name" name="item_name" value="<? echo $row_item["item_name"]; ?>" ></div>
			</div>
		</div>
		<div class="row">
			<div class="keyIn_wrapper">
				<div class='col-lg-2' style="text-align:right;"><font style="color:red">＊</font><font class="keyIn_text">商品分类︰</font></div>
				<div id="item_cate_parent" class='col-lg-2 keyIn_underline'>
					<select id="item_cate" name="item_cate" class="form-control" onchange="add_subcate(this.value);">
						<option value=""> 请选择</option>
						<?
							$sql = "select * from category where rank = 1";
							$result = mysqli_query($sqli,$sql);
							while($row = mysqli_fetch_array($result)){
								echo "<option value='".$row["cate_id"]."' ";
									if($row_item["parent_id"]=="0"){
										if($row_item["cate_id"]==$row["cate_id"])
											echo "selected";
									}
									else{
										if($row_item["parent_id"]==$row["cate_id"])
											echo "selected";
									}
								echo ">".$row["cate_name"]."</option>";
							}
						?>
					</select>
				</div>
				<div id="item_cate_child" class='col-lg-2 keyIn_underline'>
					<?
						$sql = "select * from category where parent_id = ".$row_item["parent_id"];
						$result = mysqli_query($sqli,$sql);
						$rs_cn = mysqli_num_rows($result);
						if($rs_cn!=0){
							echo "<select id='item_subcate' name='item_subcate' class='form-control'>";
							while($row = mysqli_fetch_array($result)){
								echo "<option value='".$row["cate_id"]."' ";
								if($row_item["cate_id"]==$row["cate_id"])
									echo "selected";
								echo ">".$row["cate_name"]."</option>";
							}
							echo "</select>";
						}
					?>
				</div>
				<div class='col-lg-2' style="text-align:right;"><font class="keyIn_text">商品品牌︰</font></div>
				<div class='col-lg-4 keyIn_underline'>
					<select id="item_brand" name="item_brand" class="form-control">
						<option value=""> 请选择</option>
						<?
							$sql = "select * from brand";
							$result = mysqli_query($sqli,$sql);
							while($row = mysqli_fetch_array($result)){
								echo "<option value='".$row["brand_id"]."' ";
								if($row_item["brand_id"] == $row["brand_id"])
									echo "selected";
								echo ">".$row["brand_name"]."</option>";
							}
						?>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="keyIn_wrapper">
				<div class='col-lg-2' style="text-align:right;"><font style="color:red">＊</font><font class="keyIn_text">商品库存︰</font></div>
				<div class='col-lg-2 keyIn_underline'><input type="text" class="form-control" id="item_stock" name="item_stock" value="<? echo $row_item["item_stock"]; ?>" placeholder='999内' onchange="if(isNaN(this.value)){alert('只能填写数字');this.value='';this.focus();};"></div>
				<div class='col-lg-2 col-lg-offset-2' style="text-align:right;"><font style="color:red">＊</font><font class="keyIn_text">商品价格︰</font></div>
				<div class='col-lg-4 keyIn_underline'><input type="text" class="form-control" id="item_price" name="item_price" value="<? echo $row_item["item_price"]; ?>" onchange="if(isNaN(this.value)){alert('只能填写数字');this.value='';this.focus();};"></div>
			</div>
		</div>
		<div class="row">
			<div class="keyIn_wrapper">
				<div class='col-lg-2' style="text-align:right;"><font style="color:red">＊</font><font class="keyIn_text">商品照片︰<br><h6>(上限4张)</h6><br></font></div>
				<div class="col-lg-10">
					<?
						$photo = explode("|",$row_item["item_photo"]);
						for($i = 0; $i < count($photo); ++$i){
					?>
						<div class="miniPhoto_wrapper">
							<img id="item_img<? echo ($i+1); ?>" src="update/item_s/<? echo $photo[$i]; ?>" onclick="$('#item_photo<? echo ($i+1); ?>').click();">
							<input type="file" id="item_photo<? echo ($i+1); ?>" name="item_photo[]" accept="image/*" style="display:none;" onchange="none('item_img<? echo ($i+1); ?>');block('item_photo<? echo ($i+1); ?>');">
							<div class="photo_delete"></div>
						</div>
					<?
						}
					?>
					<input type='hidden' id='item_photo_count' name='item_photo_count' value='<? echo count($photo); ?>'>
					<div id="add_photo_div"><!--input type="file" id="item_photo1" name="item_photo[]" accept="image/*"--></div>
					<div id='add_item_photo_div'><img src="include/images/add.jpg" onclick="add_item_photo();"></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="keyIn_wrapper">
				<div class='col-lg-2' style="text-align:right;"><font class="keyIn_text">商品描述︰</font></div>
				<div class='col-lg-10'>
					<table class="table table-bordered">
						<tr>
							<td><font>尺寸</font></td><td><div class="keyIn_underline"><input type="text" class="form-control" id="item_size" name="item_size" value="<? echo $row_item["item_size"]; ?>" placeholder='20字内描述'></div></td>
							<td><font>产地</font></td><td><div class="keyIn_underline"><input type="text" class="form-control" id="item_origin" name="item_origin" value="<? echo $row_item["item_orgian"]; ?>" placeholder='20字内描述'></div></td>
						</tr>
						<tr>
							<td><font>重量</font></td><td><div class="keyIn_underline"><input type="text" class="form-control" id="item_weigth" name="item_weigth" value="<? echo $row_item["item_weight"]; ?>" placeholder='20字内描述'></div></td>
							<td><font>包装尺寸</font></td><td><div class="keyIn_underline"><input type="text" class="form-control" id="package_size" name="package_size" value="<? echo $row_item["package_size"]; ?>" placeholder='20字内描述'></div></td>
						</tr>
						<tr><td><font>注意事项</font></td><td colspan='3'><div class="keyIn_underline"><textarea class="form-control" id="item_note" name="item_note" placeholder='50字内描述'><? echo $row_item["item_note"]; ?></textarea></div></td></tr>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="keyIn_wrapper">
				<div class='col-lg-2' style="text-align:right;"><font class="keyIn_text">图文编辑︰</font></div>
				<div class='col-lg-10 textarea_under'>
					<textarea class="textarea form-control" id="item_html" name="item_html" style="width:100%;height:500px;"><? echo $row_item["item_html"]; ?></textarea>
				</div>
			</div>
		</div>
		<font class="redPoint">＊编辑完毕後，商品需要重新上架</font>
		<div class="row">
			<input type='hidden' id='action' name='action' value='edit_item'>
			<button type='button' class="btn btn-primary saveBtn" onclick="check_input_info();" >储存</button>
		</div>
	</form>
</div>
<script>
	(function($) { //判断dom是否存在
	    $.fn.exist = function(){
	        if($(this).length>=1){
	            return true;
	        }
	        return false;
	    };
	})(jQuery);

	function add_item_photo(){
		var file_count = parseInt(Dd("item_photo_count").value);
		if(file_count >= 4 ){
		}
		else{
	  	var file  = document.createElement("input");
	  	file.setAttribute("type", "file");
	  	file.setAttribute("id", "item_photo"+(file_count+1));
	  	file.setAttribute("name", "item_photo[]");
	  	file.setAttribute("accept", "image/*");
	  	$( '#add_photo_div' ).append( file );
	  	Dd('item_photo_count').value = file_count+1;
	  	if(parseInt(Dd("item_photo_count").value) >= 4)
	  		none('add_item_photo_div');
	  }
	}

	function add_subcate(this_value){ //新增子项目
		if(this_value!=""){
			$.ajax({
	      url: 'ajax/gat.php',
	      data: 'action=get_subcate&cate_id='+this_value,
	      type:"POST",
	      dataType:'JSON',

	      success: function(myjson){
	      	var str = "";
	      	if(myjson.length > 0){
	      		str = "<select id='item_subcate' name='item_subcate' class='form-control'><option value='' > 请选择</option>";
	      		for(var i = 0 ; i < myjson.length ; ++i)
	      			str += "<option value='"+myjson[i].cate_id+"'> "+myjson[i].cate_name+"</option>";
	      	}
	      	Dd("item_cate_child").innerHTML = str;
	      },

	       error:function(xhr, ajaxOptions, thrownError){
	          alert(xhr.status);
	          alert(thrownError);
	       }
	  	});
	  }
	  else{
	  	Dd("item_cate_child").innerHTML = '';
	  }
	}

	function check_input_info(){ //新增填写项目完整
		if(Dd("item_name").value==""){
			alert('商品名称为必填');
			Dd('item_name').focus();
		}
		else if(Dd("item_stock").value==""){
			alert('商品库存为必填');
			Dd('item_stock').focus();
		}
		else if(Dd("item_price").value==""){
			alert('商品价格为必填');
			Dd('item_price').focus();
		}
		else{
			if($('#item_subcate').exist()&&Dd("item_subcate").value=="")
				alert('子项目必须选择');
			else if(!$('#item_subcate').exist()&&Dd("item_cate").value=="")
				alert('项目必须选择');
			else{
				var photo_exist = false ;
				for(var n = 1 ; n <= parseInt(Dd('item_photo_count').value) ; ++n){
					if(Dd('item_photo'+n).value != '')
						photo_exist = true;
					if($('#item_img'+n).exist()){
						if(Dd("item_img"+n).display!="none")
							photo_exist = true;
					}
				}
				if(!photo_exist)
					alert('至少上传一张图片');
				else
					Dd('item_form').submit();
			}
		}
	}

	function get_item_html(){

	}
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
</script>