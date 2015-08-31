<?
	include_once("include/dbinclude.php");
?>

<div><!--has-success  has-error-->
	<form id='reg_form' action='ajax/register.php' method="POST">
		<table width=100%>
			<tr>
				<td><label class="control-label" for="user_name">姓名</label></td>
				<td>
					<div id="user_name_div" class="form-group">
						<input type="text" class="form-control" id="user_name" name="user_name" onchange="check_reg_input(this.id , this.value);">
						<font style="color:red;display:inline;" id="user_name_note"></font>
					</div>
				</td>
			</tr>
			<tr>
				<td><label class="control-label" for="birthday">生日</label></td>
				<td>
					<div id="birthday_div" class="form-group" onchange="check_reg_input(this.id , this.value);">
						<select id='birth_y' name='birth_y' class="form-control" style='width:30%;display:inline;' onchange="check_reg_input(this.id , this.value);">
							<option value="" > 年</option>
							<?
								for($i = 1900 ; $i <= intval(date("Y")); ++$i)
									echo "<option value='".$i."' > ".$i."</option>";
							?>
						</select>
						<select id='birth_m' name='birth_m' class="form-control" style='width:30%;display:inline;' onchange="check_reg_input(this.id , this.value);">
							<option value="" > 月</option>
							<?
								for($i = 1 ; $i <= 12; ++$i)
									if($i < 10)
										echo "<option value='0".$i."' > 0".$i."</option>";
									else
										echo "<option value='".$i."' > ".$i."</option>";
							?>
						</select>
						<select id='birth_d' name='birth_d' class="form-control" style='width:30%;display:inline;' onchange="check_reg_input(this.id , this.value);">
							<option value="" > 日</option>
							<?
								for($i = 1 ; $i <= 31; ++$i)
									if($i < 10)
										echo "<option value='0".$i."' > 0".$i."</option>";
									else
										echo "<option value='".$i."' > ".$i."</option>";
							?>
						</select>
						<font style="color:red;display:inline;" id="birthday_note"></font>
					</div>
				</td>
			</tr>
			<tr>
				<td><label class="control-label" for="sex">性别</label></td>
				<td>
					<div id="sex_div" class="form-group">
						<select id="sex" name="sex" class="form-control" onchange="check_reg_input(this.id , this.value);">
							<option value="" > 请选择</option>
							<option value="0" > 男</option>
							<option value="1" > 女</option>
						</select>
						<font style="color:red;display:inline;" id="sex_note"></font>
					</div>
				</td>
			</tr>
			<tr>
				<td><label class="control-label" for="email">E-mail（登入帐号）</label></td>
				<td><div id="email_div" class="form-group"><input type="text" class="form-control" id="email" name="email" onchange="check_reg_input(this.id , this.value);"><font style="color:red;display:inline;" id="email_note"></font></div></td>
			</tr>
			<tr>
				<td><label class="control-label" for="user_nick">登入名称</label></td>
				<td><div id="nick_div" class="form-group"><input type="text" class="form-control" id="user_nick" name="user_nick"></div></td>
			</tr>
			<tr>
				<td><label class="control-label" for="pwd">密码</label></td>
				<td><div id="pwd_div" class="form-group"><input type="password" class="form-control" id="pwd" name="pwd" onchange="check_reg_input(this.id , this.value);"><font style="color:red;display:inline;" id="pwd_note"></font></div></td>
			</tr>
			<tr>
				<td><label class="control-label" for="pwd_check">确认密码</label></td>
				<td><div id="pwd_check_div" class="form-group"><input type="password" class="form-control" id="pwd_check" name="pwdcheck" onchange="check_reg_input(this.id , this.value);"><font style="color:red;display:inline;" id="pwd_check_note"></font></div></td>
			</tr>
			<tr>
				<td><label class="control-label" for="captcha">验证码</label></td>
				<td><div id="captcha_div" class="form-group"><input type="text" class="form-control" id="captcha" name="captcha" onchange="check_reg_input(this.id , this.value);"><font style="color:red;display:inline;" id="captcha_note"></font></div></td>
			</tr>
			<tr>
				<td colspan='2' align='center'>
					<input type="hidden" id="action" name="action" value="reg">
					<input type='button' id='reg_btn' name='reg_btn' value='注册' class='btn btn-primary' onclick="go_reg();">
				</td>
			</tr>
		</table>
	</form>
<script>
	function go_reg(){
		if(Dd("birth_y").value==''||Dd("birth_m").value==''||Dd("birth_d").value==''){
			Dd("birthday_div").className="form-group has-error";
			Dd("birthday_note").innerHTML="";
			alert("尚有项目未填写！！");
		}
		else if(Dd("sex").value==''){
			Dd("sex_div").className="form-group has-error";
			alert("尚有项目未填写！！");
		}
		else if(Dd("sex").value=='' || Dd("email").value==''|| Dd("pwd").value==''|| Dd("pwd_check").value==''){
			alert("尚有项目未填写！！");
		}
		else if(Dd("user_name_div").className=="form-group has-error"||Dd("birthday_div").className=="form-group has-error"||Dd("sex_div").className=="form-group has-error"){
			alert("尚有表单验证未通过");
		}
		else if(Dd("email_div").className=="form-group has-error"||Dd("pwd_div").className=="form-group has-error"||Dd("pwd_check_div").className=="form-group has-error"){
			alert("尚有表单验证未通过");
		}
		else{
			Dd("reg_form").submit();
		}
	}
	function check_reg_input(this_id , this_value){
		var str = ""
		if(this_id == "email"){
			if(Dd(this_id).value.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/)== -1){
				Dd(this_id+"_div").className="form-group has-error";
				Dd(this_id+"_note").innerHTML="＊email格式不符";
			}
			else{
				str = "action=check&target="+this_id+"&value="+this_value;
				$.ajax({
		      url: 'ajax/register.php',
		      data: str,//$('#sentToBack').serialize()
		      type:"POST",
		      dataType:'text',
		
		      success: function(mytext){
		      	  var arr = new Array();
		      	  arr = mytext.split("|");
		      	  if(arr[0]=='0'){
		      	  	Dd(this_id+"_div").className="form-group has-success";
								Dd(this_id+"_note").innerHTML="";
		      	  }
		      	  else if(arr[0]=='1'){
		      	  	Dd(this_id+"_div").className="form-group has-error";
								Dd(this_id+"_note").innerHTML="＊已有相同信箱注册";
		      	  }
		      	  else
		      	  	alert(mytext);
		      },
		
		       error:function(xhr, ajaxOptions, thrownError){ 
		          alert(xhr.status); 
		          alert(thrownError); 
		       }
	    	});
			}
		}
		else if(this_id == 'pwd'){
			if(this_value.length > 16 || this_value.length < 8){
				Dd(this_id+"_div").className="form-group has-error";
				Dd(this_id+"_note").innerHTML="＊密码长度不正确";
			}
			else{
				Dd(this_id+"_div").className="form-group has-success";
				Dd(this_id+"_note").innerHTML="";
			}
		}
		else if(this_id == 'pwd_check'){
			if(this_value!=Dd('pwd').value){
				Dd(this_id+"_div").className="form-group has-error";
				Dd(this_id+"_note").innerHTML="＊两次密码输入不相同";
			}
			else{
				Dd(this_id+"_div").className="form-group has-success";
				Dd(this_id+"_note").innerHTML="";
			}
		}
		else if( this_id == 'user_name'){
			if(this_value.length > 10 || this_value.length < 2){
				Dd(this_id+"_div").className="form-group has-error";
				Dd(this_id+"_note").innerHTML="＊姓名长度不正确";
			}
			else{
				Dd(this_id+"_div").className="form-group has-success";
				Dd(this_id+"_note").innerHTML="";
			}
		}
		else if( this_id == 'sex'){
			if(this_value==""){
				Dd(this_id+"_div").className="form-group has-error";
				Dd(this_id+"_note").innerHTML="＊性别为必填，不得为空";
			}
			else{
				Dd(this_id+"_div").className="form-group has-success";
				Dd(this_id+"_note").innerHTML="";
			}
		}
		else if( this_id == 'birth_y' || this_id == 'birth_m' || this_id == 'birth_d'){
			if(Dd('birth_y').value == ''||Dd('birth_m').value == ''||Dd('birth_d').value == ''){
				Dd("birthday_div").className="form-group has-error";
				Dd("birthday_note").innerHTML="";
			}
			else{
				var dt1 = new Date(Dd('birth_y').value, Dd('birth_m').value-1, Dd('birth_d').value);
				var dt2 = new Date();
				if(dt1 > dt2){
					Dd("birthday_div").className="form-group has-error";
					Dd("birthday_note").innerHTML="＊生日错误";
				}
				else{
					Dd("birthday_div").className="form-group has-success";
					Dd("birthday_note").innerHTML="";
				}
			}
		}
	}
</script>