<?
	include_once("include/dbinclude.php");
	include_once("include/captcha/simple-php-captcha.php");
	$_SESSION['captcha'] = simple_php_captcha();
?>

<div>
	<form id='login_form' action='ajax/login.php' method="POST">
		<label>会员登入</label>
		<table width=100%>
			<tr>
				<td><label for='user_email'>帐号︰</label></td>
				<td><input type='text' id='user_email' name='user_email' value='' class='form-control'></td>
			</tr>
			<tr>
				<td><label for='user_pwd'>密码︰</label></td>
				<td><input type='password' id='user_pwd' name='user_pwd' value='' class='form-control'></td>
			</tr>
			<tr>
				<td><label for='captcha'>验证码︰</label></td>
				<td>
					<img id='captcha_img' src="<? echo $_SESSION['captcha']['image_src'];?>" alt="CAPTCHA" />
					<img id='captcha_reload' src="include/images/reload.png" style="width:25px;">
					<input type="text" id="captcha_code" name="captcha_code" size="10" maxlength="10" />
				</td>
			</tr>
			<tr>
				<td></td>
				<td><a href=# onclick=''>忘记密码</a></td>
			</tr>
			<tr>
				<td colspan='2' align='center'>
					<input type="hidden" id="action" name="action" value="login" >
					<input type='button' id='login_btn' name='login_btn' value='登入' class='btn btn-primary'>
				</td>
			</tr>
		</table>
	</form>
</div>
<script>
	$("#login_btn").click(function(e){
			if(Dd("user_email").value == "" || Dd("user_email").value == "user_pwd")
				alert("登入资讯请先填写完整");
			else
				Dd("login_form").submit();
	})
	
	//验证码
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
	})
</script>