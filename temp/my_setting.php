<?
	include_once("include/dbinclude.php");
	include_once("temp/my_header.php");
	
	$sql = "select a.*  from user a 
	where a.user_id = ".$_SESSION["user_id"];
	$result = mysqli_query($sqli,$sql);
	$row = mysqli_fetch_array($result);
?>
<div>
	<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#setting_self" aria-controls="setting_self" role="tab" data-toggle="tab">个人设置</a></li>
    <li role="presentation"><a href="#setting_safe" aria-controls="setting_safe" role="tab" data-toggle="tab">安全设置</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
  	<!--商品html页面-->
    <div role="tabpanel" class="tab-pane active" id="setting_self">
    	<div class='col-lg-8 col-lg-offset-2'>
    		<form id="self_form">
	    		<table width='100%'>
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
	    					<select id='' name='' class='form-control' style='width:34%;float:left;'>
	    						<? 
	    							for($i = 1900 ; $i <= intval(date("Y")) ; ++$i){
	    								echo "<option value='".$i."' ";
	    								if($i == intval($birth[0]))
	    									echo "selected";
	    								echo "> ".$i."</option>";
	    							}
	    						?>
	    					</select>
	    					<select id='' name='' class='form-control' style='width:33%;float:left;'>
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
	    					<select id='' name='' class='form-control' style='width:33%;float:left;'>
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
	    					<input type='text' class='form-control' id='email' value='<? echo $row['email'];?>' readonly>
	    				</td>
	    			</tr>
	    			<tr>
	    				<td colspan='2'>
	    					<input type="hidden" id="self_action" name="action" value="self">
	    					<button type='button' id='self_btn' name='self_btn' class='btn btn-primary'>储存设置</button>
	    				</td>
	    			</tr>
	    		</table>
	    	</form>
    	</div>
    </div>
    
    
    <div role="tabpanel" class="tab-pane" id="setting_safe">
    	<div class='col-lg-8 col-lg-offset-2'>
    		<form id="safe_form">
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
	    			<tr>
	    				<td colspan='2'>
	    					<input type="hidden" id="safe_action" name="action" value="safe">
	    					<button type='button' id='safe_btn' name='safe_btn' class='btn btn-primary'>储存设置</button>
	    				</td>
	    			</tr>
	    		</table>
	    	</form>
    	</div>
    </div>
  </div>
</div>
<script>
	$('#self_btn').click(function(e){
	});
	$('#safe_btn').click(function(e){
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
	$('#user_pwd').change(function(e){
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
	$('#new_pwd').change(function(e){
		if($('#new_pwd').val().trim()=='')
			$('#new_pwd_div').attr('class','form-group');
		else{
			if($('#new_pwd').val().length < 8 || $('#new_pwd').val().length >16)
				$('#new_pwd_div').attr('class','form-group has-error');
			else
				$('#new_pwd_div').attr('class','form-group has-success');
		}
	});
	$('#check_pwd').change(function(e){
		if($('#check_pwd').val().trim()=='')
			$('#check_pwd_div').attr('class','form-group');
		else{
			if($('#check_pwd').val() == $('#new_pwd').val())
				$('#check_pwd_div').attr('class','form-group has-success');
			else
				$('#check_pwd_div').attr('class','form-group has-error');
		}
	});
</script>