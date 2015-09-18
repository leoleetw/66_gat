<?
	include_once("include/dbinclude.php");
	include_once("temp/my_header.php");

	$sql = "select a.*  from user a
	where a.user_id = ".$_SESSION["user_id"];
	$result = mysqli_query($sqli,$sql);
	$row = mysqli_fetch_array($result);
?>
<div>
	<ul class="nav nav-tabs tabs_blue" role="tablist">
	    <li role="presentation" class="active"><a href="#setting_self" aria-controls="setting_self" role="tab" data-toggle="tab">个人设置</a></li>
	    <li role="presentation"><a href="#setting_safe" aria-controls="setting_safe" role="tab" data-toggle="tab">安全设置</a></li>
	</ul>

  <!-- Tab panes -->
  <div class="tab-content lightBlueBg">
  	<!--商品html页面-->
    <div role="tabpanel" class="tab-pane active" id="setting_self">
    	<form id="self_form">
    	<div class='col-lg-6 col-lg-offset-3 settingWrapper'>
    		<img src="include/images/setting_bg.png">
			<div class='nick_keyin'><input type='text' class='form-control' id='user_nick' name='user_nick' value='<? echo $row['user_nick'];?>'></div>
			<div class="info_keyin">
				<input type='radio' id='user_sex0' name='user_sex' value='0' <? if($row['user_sex']=='0'){echo 'checked';}?>> 男
				<input type='radio' id='user_sex1' name='user_sex' value='1' <? if($row['user_sex']=='1'){echo 'checked';}?>> 女
				<div>
					<?
						$birth = explode("-",$row['user_birthday']);
					?>
					<select id='birth_y' name='birth_y' class='form-control' style='width:34%;float:left;'>
						<?
							for($i = 1900 ; $i <= (intval(date("Y"))-10) ; ++$i){
								echo "<option value='".$i."' ";
								if($i == intval($birth[0]))
									echo "selected";
								echo "> ".$i."</option>";
							}
						?>
					</select>
					<select id='birth_m' name='birth_m' class='form-control' style='width:33%;float:left;'>
						<?
							for($i = 1 ; $i <= 12 ; ++$i){
								echo "<option value='";
								if($i < 10 )
									echo "0";
								echo $i."' ";
								if($i == intval($birth[1]))
									echo "selected";
								echo "> ";
								if($i < 10 )
									echo "0";
								echo $i."</option>";
							}
						?>
					</select>
					<select id='birth_d' name='birth_d' class='form-control' style='width:33%;float:left;'>
						<?
							for($i = 1 ; $i <= 31 ; ++$i){
								echo "<option value='";
								if($i < 10 )
									echo "0";
								echo $i."' ";
								if($i == intval($birth[2]))
									echo "selected";
								echo "> ";
								if($i < 10 )
									echo "0";
								echo $i."</option>";
							}
						?>
					</select>
				</div>
				<input type='text' class='form-control' id='email' value='<? echo $row['email'];?>' readonly>
		    	<button type="button" id="change_email_btn" name="change_email_btn" class="btn btn-primary change_email"></button>
			</div>
	    		<!--table width='100%'>
	    			<tr>
	    				<td>
	    					昵称显示
	    				</td>
	    				<td>
	    					<input type='text' class='form-control' id='user_nick' name='user_nick' value='<? echo $row['user_nick'];?>'>
	    				</td>
	    			</tr>
	    			<tr>
	    				<td>
	    					性别
	    				</td>
	    				<td>
	    					<input type='radio' id='user_sex0' name='user_sex' value='0' <? if($row['user_sex']=='0'){echo 'checked';}?>> 男 <input type='radio' id='user_sex1' name='user_sex' value='1' <? if($row['user_sex']=='1'){echo 'checked';}?>> 女
	    				</td>
	    			</tr>
	    			<tr>
	    				<td>
	    					生日
	    				</td>
	    				<td>
	    					<?
	    						$birth = explode("-",$row['user_birthday']);
	    					?>
	    					<select id='birth_y' name='birth_y' class='form-control' style='width:34%;float:left;'>
	    						<?
	    							for($i = 1900 ; $i <= (intval(date("Y"))-10) ; ++$i){
	    								echo "<option value='".$i."' ";
	    								if($i == intval($birth[0]))
	    									echo "selected";
	    								echo "> ".$i."</option>";
	    							}
	    						?>
	    					</select>
	    					<select id='birth_m' name='birth_m' class='form-control' style='width:33%;float:left;'>
	    						<?
	    							for($i = 1 ; $i <= 12 ; ++$i){
	    								echo "<option value='";
	    								if($i < 10 )
	    									echo "0";
	    								echo $i."' ";
	    								if($i == intval($birth[1]))
	    									echo "selected";
	    								echo "> ";
	    								if($i < 10 )
	    									echo "0";
	    								echo $i."</option>";
	    							}
	    						?>
	    					</select>
	    					<select id='birth_d' name='birth_d' class='form-control' style='width:33%;float:left;'>
	    						<?
	    							for($i = 1 ; $i <= 31 ; ++$i){
	    								echo "<option value='";
	    								if($i < 10 )
	    									echo "0";
	    								echo $i."' ";
	    								if($i == intval($birth[2]))
	    									echo "selected";
	    								echo "> ";
	    								if($i < 10 )
	    									echo "0";
	    								echo $i."</option>";
	    							}
	    						?>
	    					</select>
	    				</td>
	    			</tr>
	    			<tr>
	    				<td>
	    					信箱
	    				</td>
	    				<td>
	    					<input type='text' class='form-control' id='email' value='<? echo $row['email'];?>' readonly style="width:80%;float:left;">
	    					<button type="button" id="change_email_btn" name="change_email_btn" class="btn btn-primary">变更信箱</button>
	    				</td>
	    			</tr>
	    			<tr>
	    				<td colspan='2'>
	    					<input type="hidden" id="self_action" name="action" value="self">
	    					<button type='button' id='self_btn' name='self_btn' class='btn btn-primary'>储存设置</button>
	    				</td>
	    			</tr>
	    		</table-->
    		</div>
    		<div class="col-lg-6 col-lg-offset-3">
		    	<input type="hidden" id="self_action" name="action" value="self">
			    <button type='button' id='self_btn' name='self_btn' class='btn btn-primary settingSave'>储　存</button>
    		</div>
    	</form>
    </div>


    <div role="tabpanel" class="tab-pane" id="setting_safe">
    	<div class='col-lg-6 col-lg-offset-3'>
    		<form id="safe_form">
    			<div class="safeBg">
		    		<table width='100%'>
		    			<tr>
		    				<td>
		    					帐号
		    				</td>
		    				<td>
		    					<div class="form-group">
		    						<input type='text' class='form-control' id='' name='' value='<? echo $row['email'];?>' readonly>
		    					</div>
		    				</td>
		    			</tr>
		    			<tr>
		    				<td>
		    					原密码
		    				</td>
		    				<td>
		    					<div id='user_pwd_div' class="form-group"><!-- has-success has-error-->
									<input type='password' class='form-control' id='user_pwd' name='user_pwd' value='' >
								</div>
		    				</td>
		    			</tr>
		    			<tr>
		    				<td>
		    					新密码(8～16字元)
		    				</td>
		    				<td>
		    					<div id='new_pwd_div' class="form-group">
									<input type='password' class='form-control' id='new_pwd' name='new_pwd' value='' >
								</div>
		    				</td>
		    			</tr>
		    			<tr>
		    				<td>
		    					再次输入新密码
		    				</td>
		    				<td>
		    					<div id='check_pwd_div' class="form-group">
									<input type='password' class='form-control' id='check_pwd' name='check_pwd' value='' >
								</div>
		    				</td>
		    			</tr>
		    		</table>
		    	</div>
				<input type="hidden" id="safe_action" name="action" value="safe">
				<button type='button' id='safe_btn' name='safe_btn' class='btn btn-primary settingSave'>储　存</button>
	    	</form>
    	</div>
    </div>
  </div>
</div>
<form id='email_form' action='ajax/setting.php' method="POST">
	<div class="modal fade" id="email_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<button type="button" class="btn btn-default" data-dismiss="modal" style="float:right">X</button>
	      	<input type="hidden" id="email_user_nick" name="email_user_nick" value='<? echo $row['user_nick'];?>'>
	      	<h1 align='center'>变更信箱</h1>
	      </div>
	      <div class="modal-body">
	      	<label>原信箱︰</label>
	      	<input type="text" class="form-control" id="change_email_o" name="change_email_o" value="<? echo $row["email"]; ?>" readonly>
	      	<label>新信箱︰</label>
	      	<input type="text" class="form-control" id="change_email" name="change_email" value="">
	      	<font class="emailWarning">信箱变更後，需重新登入，并重新验证信箱</font>
	      </div>
	      <div class="modal-footer">
	      	<input type="hidden" name="action" value="change_email">
	        <button type="button" class="btn btn-primary settingSave" id='email_btn'>确定</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>
<script>
	$('#self_btn').click(function(e){ //变更其他资讯
		$.ajax({
      url: 'ajax/setting.php',
      data: $('#self_form').serialize(),
      type:"POST",
      dataType:'text',

      success: function(mytext){
      	var arr = new Array();
      	arr = mytext.split("|");
      	if(arr[0]=='0'){
      		alert("资料更新成功");
      	}
      	else if(arr[0]=='1'){
      		alert("资料更新失败");
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
	});
	$('#safe_btn').click(function(e){ //变更密码
		if($('#user_pwd_div').attr("class").indexOf("has-success") > 0 && $('#new_pwd_div').attr("class").indexOf("has-success") > 0  && $('#check_pwd_div').attr("class").indexOf("has-success") > 0 ){
			$.ajax({
	      url: 'ajax/setting.php',
	      data: $('#safe_form').serialize(),
	      type:"POST",
	      dataType:'text',

	      success: function(mytext){
	      	Dd("safe_form").reset();
	      	$('#user_pwd_div').attr('class','form-group');
	      	$('#new_pwd_div').attr('class','form-group');
	      	$('#check_pwd_div').attr('class','form-group');
	      	var arr = new Array();
	      	arr = mytext.split("|");
	      	if(arr[0]=='0'){
	      		alert("新密码设置成功");
	      	}
	      	else if(arr[0]=='1'){
	      		alert("新密码设置错误");
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
	$('#user_pwd').change(function(e){ //确认原密码正确
		if($('#user_pwd').val()=='')
			$('#user_pwd_div').attr('class','form-group');
		else{
			$.ajax({
	      url: 'ajax/setting.php',
	      data: 'action=check_pwd&pwd='+$('#user_pwd').val(),
	      type:"POST",
	      dataType:'text',

	      success: function(mytext){

	      	var arr = new Array();
	      	arr = mytext.split("|");
	      	if(arr[0]=='0'){
	      		$('#user_pwd_div').attr('class','form-group has-success');
	      	}
	      	else if(arr[0]=='1'){
	      		$('#user_pwd_div').attr('class','form-group has-error');
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
	$('#new_pwd').change(function(e){ //新密码验证
		if($('#new_pwd').val().trim()=='')
			$('#new_pwd_div').attr('class','form-group');
		else{
			if($('#new_pwd').val().length < 8 || $('#new_pwd').val().length >16)
				$('#new_pwd_div').attr('class','form-group has-error');
			else
				$('#new_pwd_div').attr('class','form-group has-success');
		}
	});
	$('#check_pwd').change(function(e){ //确认两次新密码
		if($('#check_pwd').val().trim()=='')
			$('#check_pwd_div').attr('class','form-group');
		else{
			if($('#check_pwd').val() == $('#new_pwd').val())
				$('#check_pwd_div').attr('class','form-group has-success');
			else
				$('#check_pwd_div').attr('class','form-group has-error');
		}
	});
	$('#change_email_btn').click(function(e){ // 显示变更信箱
		$('#email_Modal').modal({
			backdrop:"static",
			keyboard:false
		});
	});
	$('#email_btn').click(function(e){ // 变更信箱
		if(Dd("change_email").value.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/) != -1){
			if(confirm("确定更改信箱为' "+Dd("change_email").value+" '？"))
				Dd("email_form").submit();
			else
				Dd("change_email").value="";
		}
		else{
			alert("信箱格式错误");
			Dd("change_email").focus();
		}
	});
</script>