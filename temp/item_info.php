<?
	include_once("include/dbinclude.php");
	include_once("include/captcha/simple-php-captcha.php");
	$_SESSION['captcha'] = simple_php_captcha();
?>
<div class="col-lg-12">
	<div class="categoryBanner">這裡是商品名稱</div>
</div>
<?
	include_once("temp/nav.php");
?>
<div class="col-lg-9">
	<div class="item_wrapper">
	<?
		$sql = "select a.* , b.* , c.cate_name ,d.item_id as collect from item a
		inner join store b on a.store_id = b.store_id
		left join category c on a.cate_id = c.cate_id
		left join collect d on a.item_id = d.item_id and d.user_id = '".$_SESSION["user_id"]."'
		where a.item_id = '".$_GET["item_id"]."'";
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
		$photo_img = explode("|",$row["item_photo"]);
		if($row["item_state"]==1){
	?>
	<div class="row">
		<div class="col-lg-7">
			<div class="mainPhoto_wrapper">
				<img id="main_photo" src="update/item/<? echo $photo_img[0];?>">
			</div>
			<div>
				<?
					for($i = 0 ; $i < count($photo_img) ; ++$i){
				?>
					<div class="miniPhoto_wrapper">
						<img src="update/item_s/<? echo $photo_img[$i];?>" onclick="change_show_photo('<? echo $photo_img[$i];?>')">
					</div>
				<? } ?>
			</div>
		</div>
		<div class="col-lg-5">
			<div class="product_info">
				<h3><font></font><? echo $row["item_name"]; ?></h3>
				<ul id="categoryActivityInfo">
        			<li>年中優惠超值檔 破盤回饋</li>
        			<li>情人節愛的禮物 表心意最佳選擇</li>
        			<li>提高雙方的愛意，使戀人永結同心</li>
        		</ul>
				<p><font>库存︰</font><? echo $row["item_stock"]; ?></p>
				<p><font>种类︰</font><? echo $row["cate_name"]; ?></p>
				<p><font>价格︰</font><font class="itemPrice"><? echo $row["item_price"]; ?></font></p>

			<?
				$disabled = false;
				$cart = json_decode( $_COOKIE["cart"] );
				for($i = 0 ; $i < count($cart) ; ++ $i ){
					if($row["store_id"] == $cart[$i]->store_id){
						for($n = 0 ;$n < count($cart[$i]->item) ; ++$n)
							if($row["item_id"] == $cart[$i]->item[$n])
								$disabled =true;
					}
				}
			?>
			<button id="cart_button" id="add_cart_btn" type="button" class="btn btn-default" onclick="addtocart(<? echo $row["item_id"].",".$row["store_id"]; ?>);this.disabled='disabled';" <? if($disabled){echo "disabled";}?>></button>
			<button id="collect_button" type="button" class="btn btn-default" onclick="addtocollect(<? echo $row["item_id"].",".$row["store_id"]; ?>);this.disabled='disabled';" <? if($_SESSION["user_id"]=="" || $row["collect"]!=null ||$row["user_id"]==$_SESSION["user_id"]){ echo "disabled";} ?>></button>
			<button id="shop_button" type="button" class="btn btn-default" onclick="location.href='store_info.php?store_id=<? echo $row["store_id"]; ?>'"></button>
			<!--<div class="seller_info">
				<h4>卖家资料</h4>
				<div class="item_logoWrapper">
					<img src="update/store/<? echo $row["store_logo"]; ?>">
				</div>
				<p><? echo $row["store_name"]; ?></p>
				<button type="button" class="btn btn-default" onclick="location.href='store_info.php?store_id=<? echo $row["store_id"]; ?>'"> 进入店家</button>
			</div>-->
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<?
	    	$sql_qa = "select a.* , b.user_nick from qa a
	    	inner join item d on d.item_id = a.item_id
	    	left join user b on a.user_id = b.user_id
	    	left join store c on c.store_id = d.store_id
	    	where a.item_id = ".$_GET["item_id"];
	    	$result_qa = mysqli_query($sqli,$sql_qa);
	    	$rs_cn_qa = mysqli_num_rows($result_qa);
	   	?>
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active"><a href="#item_html" aria-controls="item_html" role="tab" data-toggle="tab">商品详情</a></li>
		    <li role="presentation"><a href="#qanda" aria-controls="qanda" role="tab" data-toggle="tab">问与答(<? echo $rs_cn_qa;?>)</a></li>
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
		  	<!--商品html页面-->
		    <div role="tabpanel" class="tab-pane active" id="item_html">
		    	<table class="table table-bordered">
						<tr>
							<td><font>尺寸</font></td><td><? echo $row["item_size"]; ?></td>
							<td><font>产地</font></td><td><? echo $row["item_origin"]; ?></td>
						</tr>
						<tr>
							<td><font>重量</font></td><td><? echo $row["item_weigth"]; ?></td>
							<td><font>包装尺寸</font></td><td><? echo $row["package_size"]; ?></td>
						</tr>
						<tr><td><font>注意事项</font></td><td colspan='3'><? echo str_replace("\n","<br>",$row["item_note"]); ?></td></tr>
					</table>
		    	<div><? echo $row['item_html']; ?></div>
		    </div>
		    <!--商品问与答页面-->

		    <div role="tabpanel" class="tab-pane" id="qanda">
		    	<? if($rs_cn_qa==0){ echo "目前尚无问题";}
		    		 else{
		    	?>
		    	<?
		    		 		while($row_qa = mysqli_fetch_array($result_qa)){
		    	?>
		    					<div>
		    						<!--买家问题-->
		    						<div>
		    							买家问题︰<? echo $row_qa["user_nick"]; ?><span><? echo $row_qa["q_creatdate"];?></span>
		    							<div>
		    								<?
		    									if($row_qa["qa_type"]=='1'&&$_SESSION['user_id']!=$row_qa["user_id"]&&$row["user_id"]!=$_SESSION["user_id"])
		    										echo "隐藏讯息";
		    									else
		    										echo str_replace("/n","<br>",$row_qa["q_content"]);
		    								?>
		    							</div>
		    						</div>
		    						<!--卖家回应-->

		    						<?	if($row["user_id"]==$_SESSION["user_id"]){ ?>
		    							<div id='edit_reply_div<? echo $row_qa["qa_id"];?>' <? if($row_qa["a_content"]==''){ echo "style='display:none;'";}?>>
		    								我的回覆︰
			    							<div id='a_content_div<? echo $row_qa["qa_id"];?>'>
			    								<? echo str_replace("/n","<br>",$row_qa["a_content"]);?>
			    							</div>
			    							<input type="hidden" id='a_content<? echo $row_qa["qa_id"];?>' name='a_content<? echo $row_qa["qa_id"];?>' value='<? echo $row_qa["a_content"];?>'>
			    							<button type="button" id="reply_btn<? echo $row_qa["qa_id"];?>" class="btn btn-primary" onclick="reply_qa(<? echo $row_qa["qa_id"];?>);">	编辑回覆</button>
			    						</div>
			    						<div id='add_reply_div<? echo $row_qa["qa_id"];?>' <? if($row_qa["a_content"]!=''){ echo "style='display:none;'";}?>>
			    								<button type="button" id="reply_btn<? echo $row_qa["qa_id"];?>" class="btn btn-primary" onclick="reply_qa(<? echo $row_qa["qa_id"];?>);">	新增回覆</button>
			    						</div>
			    					<?
			    						}
			    						else{
			    							if($row_qa["a_content"]!='' && $row_qa["a_creatdate"]!='0000-00-00 00:00:00'){
			    					?>
			    							卖家回覆︰<? echo $row_qa["store_name"]; ?><span><? echo $row_qa["a_creatdate"];?></span>
				    							<div>
				    								<?
				    								if($row_qa["qa_type"]=='1'&&$_SESSION['user_id']!=$row_qa["user_id"])
			    										echo "隐藏讯息";
			    									else
			    										echo str_replace("/n","<br>",$row_qa["a_content"]);
		    										?>
				    							</div>
				    				<?
				    						}
				    					}
				    				?>
		    					</div>
		    	<? 		}
		    		 }
		    	?>
		    	<?	if($row["user_id"]!=$_SESSION["user_id"]){ ?>
			    	<form id='qa_form' action='ajax/item.php' method="post">
				    	<div class="panel panel-default">
							  <div class="panel-heading">问题提问</div>
							  <div class="panel-body">
							  	<font style="color:red">为避免个人资料遭有心人士利用，请勿在提问内容填写个人相关资料，如:姓名、银行帐户..等。</font><br>
							  	<font style="color:red">提问字数长度为250字内</font>
							  	<input type='hidden' id='action' name='action' value='qa'>
							  	<input type='hidden' id='item_id' name='item_id' value='<? echo $row["item_id"];?>'>
							  	<input type='hidden' id='qa_type0' name='qa_type' value='0'>
							  	<input type='checkbox' id='qa_type1' name='qa_type' value='1'>是否为悄悄话
							    <textarea class="form-control" id='qa_content' name='qa_content'  style="min-width:50%;resize:none;"></textarea>
							    <img id='captcha_img' src="<? echo $_SESSION['captcha']['image_src'];?>" alt="CAPTCHA" />
							    <img id='captcha_reload' src="include/images/reload.png" style="width:25px;">
							    <input type="text" id="captcha_code" name="captcha_code" size="10" maxlength="10" />
							    <button type="button" class="btn btn-primary" id="qa_btn">送出</button>
							  </div>
							</div>
				    </form>
			  	<? } ?>
		    </div>
		  </div>
		</div>
	</div>
	<?	}else{	?>
	<div class="row">
		<div class="col-lg-6">
			<div class="mainPhoto_wrapper">
				<img id="main_photo" src="update/item/<? echo $photo_img[0];?>">
			</div>
			<div>
				<?
					for($i = 0 ; $i < count($photo_img) ; ++$i){
				?>
					<div class="miniPhoto_wrapper">
						<img src="update/item_s/<? echo $photo_img[$i];?>" onclick="change_show_photo('<? echo $photo_img[$i];?>')">
					</div>
				<? } ?>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="product_info">
				<h3><font></font><? echo $row["item_name"]; ?></h3>
				<p><font>价格︰</font><? echo $row["item_price"]; ?></p>
				<p><font>库存︰</font><? echo $row["item_stock"]; ?></p>
				<p><font>种类︰</font><? echo $row["cate_name"]; ?></p>
			</div>
			<div class="seller_info">
				<h4>此商品已下架</h4>
			</div>
		</div>
	</div>
	<?	}	?>
	</div>
</div>
<div class="modal fade" id="reply_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      	<h1 align='center'>问题回覆</h1>
      </div>
      <div class="modal-body">
      	<input type="hidden" id='qa_id' name='qa_id' value=''>
      	<textarea id='a_content' class='form-control'></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary" id='update_reply_btn'>确定</button>
      </div>
    </div>
  </div>
</div>
<script>
	/*
	$( document ).ready(function() {
		if(isnull($.cookie('cart'))!=""){
		  var cart = JSON.parse($.cookie('cart'));
			for(var i = 0 ; i < cart.length ; ++ i ){
				if('<? echo $row["store_id"];?>' == cart[i].store_id){
					for(var n = 0 ; n < cart[i].item.length ; ++n)
						if('<? echo $row["item_id"];?>' == cart[i].item[n])
							$('#add_cart_btn').attr('disabled', true);
				}
			}
	  }
	});
	*/
	/* 150902
	$( document ).ready(function() {
		if($.cookie('cart')){
		  var cart = $.cookie('cart');
		  var temp = new Array();
		  temp = cart.split("|");
		  if($.inArray( "<? echo $row["item_id"];?>", temp ) > -1)
		  	Dd("add_cart_btn").disabled = "disabled";
	  }
	});
	*/
	$('#captcha_reload').click(function(e){
		$.get('ajax/captcha.php', function(url) {
	    $('#captcha_img').attr('src', url);
		});
	})
	$('#captcha_code').change(function(e){
		if($('#captcha_code').val()!=''){
			$.ajax({
	      url: 'ajax/check_captcha.php',
	      data: 'captcha_code='+$('#captcha_code').val(),
	      type:"POST",
	      dataType:'text',

	      success: function(mytext){
	      	var arr = new Array();
	      	arr = mytext.split("|");
	      	if(arr[0]=='0'){

	      	}
	      	else if(arr[0]=='1'){
	      		alert('验证码错误');
	      		$('#captcha_code').focus();
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
	});
	function reply_qa(qa_id){
		Dd('a_content').value = $('#a_content'+qa_id).val();
		Dd('qa_id').value = qa_id;
		$('#reply_Modal').modal({
			backdrop:"static",
			keyboard:false
		});
	}
	$('#update_reply_btn').click(function(e){
		if($('#a_content').val().trim()=="")
			alert('问题回覆不得空白');
		else if($('#a_content').val().length > 250)
				alert("内容长度不得超过250个字");
		else{
			$.ajax({
	      url: 'ajax/item.php',
	      data: 'action=reply_qa&qa_id='+$('#qa_id').val()+'&a_content='+$('#a_content').val(),
	      type:"POST",
	      dataType:'text',

	      success: function(mytext){
	      	var arr = new Array();
	      	arr = mytext.split("|");
	      	if(arr[0]=='0'){
	      		Dd('a_content'+$('#qa_id').val()).value = $('#a_content').val();
	      		Dd('a_content_div'+$('#qa_id').val()).innerHTML = $('#a_content').val();
	      		if(Dd('edit_reply_div'+$('#qa_id').val()).style.display=='none'){
	      			none('add_reply_div'+$('#qa_id').val());
	      			block('edit_reply_div'+$('#qa_id').val());
	      		}
	      		$('#reply_Modal').modal('hide');
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
	});
	$('#qa_btn').click(function(e){
		if('<? echo $_SESSION["user_id"];?>' == '')
			alert('请先登入会员');
		else{
			if($('#qa_content').val().trim()=='')
				alert("内容不得空白");
			else if($('#qa_content').val().length > 250)
				alert("内容长度不得超过250个字");
			else
				$('#qa_form').submit();
		}
	})

	function change_show_photo(photo_url){
		Dd("main_photo").src = "update/item/"+photo_url;
	}
	function addtocollect(item_id , store_id){
		$.ajax({
      url: 'ajax/item.php',
      data: 'action=collect&item_id='+item_id+'&store_id='+store_id,
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
</script>