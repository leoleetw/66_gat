<?
	include_once("include/dbinclude.php");
	include_once("temp/my_header.php");
?>
<div>
<?
	$sql = "select a.* , b.* from user a left join user_attest b on a.user_id = b.user_id where a.user_id=".$_SESSION["user_id"];
	$result = mysqli_query($sqli,$sql);
	$row = mysqli_fetch_array($result);
?>
	<div class="col-lg-4">
		<h2>实名认证</h2>
		<? if((intval($row["user_attest"])&1)== true){//通过 ?>
			<img src="include/images/control/ok.png"> 已认证
		<? }else if($row["name_attest"]=='0'){//审查中 ?>
			<img src="include/images/control/warning.png"> 认证审核中
		<? }else{ ?> 
			<font>认证方式︰拍摄你的大头相与身份证至同一张相片，并上传至网站等候审核</font>
			<? if($row["name_attest"]=='2'){//审查未通过 ?>
				<img src="include/images/control/no.png"><font sytle="color:red">认证未通过</font>
			<? }?>
			<form id="name_form" action="ajax/attest.php" method="post" enctype="multipart/form-data">
				<input type="hidden" id="action" name="action" value="name">
				<input type="file" id="name_img" name="name_img" accept="image/*">
				<button type="button" class="btn btn-primary" onclick="send_name_attest();">送出审核</button>
			</form>
		<? } ?>
	</div>
	<div class="col-lg-4">
		<h2>手机认证</h2>
		<? if((intval($row["user_attest"])&2)== true){//通过 ?>
			<img src="include/images/control/ok.png"> 已认证
		<? }else if($row["mobile_attest"]=='0'){//审查中 ?>
			<img src="include/images/control/warning.png"> 认证审核中
		<? }else{ ?> 
			<div><font>认证方式︰下方输入手机号码後点选按钮取得认证码</font></div>
			<? if($row["mobile_attest"]=='2'){//审查未通过 ?>
				<img src="include/images/control/no.png"><font sytle="color:red">认证码错误，或已经过期</font>
			<? }?>
				<label>手机号码</label>
				<input type="text" id="mobile" name="mobile" value="" class="form-control">
				<button type="button" class="btn btn-default" onclick="creat_mobile_attest();">按此发送简讯至您的手机</button>
				<font id="mobile_attest_font" style="display:none;color:red">123</font>
				<form id="mobile_form" action="ajax/attest.php" method="post">
					<input type="hidden" id="mobile_action" name="action" value="mobile">
					<input type="text" id="mobile_attest" name="mobile_attest" value="" class="form-control">
					<button type="button" class="btn btn-primary" onclick="check_mobile_attest();">送出审核</button>
				</form>
		<? } ?>
	</div>
	<div class="col-lg-4">
		<h2>银行帐户认证</h2>
		
		<? if((intval($row["user_attest"])&4 )== true){//通过 ?>
			<img src="include/images/control/ok.png"> 已认证
		<? }else if($row["bank_attest"]=='0'){//审查中 ?>
			<img src="include/images/control/warning.png"> 认证审核中
		<? }else{ ?> 
				<font>认证方式︰拍摄你的银行帐户相片，并上传至网站等候审核</font>
			<? if($row["bank_attest"]=='2'){//审查未通过 ?>
				<img src="include/images/control/no.png"><font sytle="color:red">认证未通过</font>
			<? }?>
			<form id="bank_form" action="ajax/attest.php" method="post" enctype="multipart/form-data">
				<input type="hidden" id="action" name="action" value="bank">
				<input type="file" id="bank_img" name="bank_img" accept="image/*">
				<button type="button" class="btn btn-primary" onclick="send_bank_attest();">送出审核</button>
			</form>
		<? } ?>
	</div>
</div>

<script>
	function check_mobile_attest(){
		if(Dd("mobile_attest").value == "")
			alert("请先输入手机验证码");
		else
			Dd("mobile_form").submit();
	}
	function creat_mobile_attest(){
		if(Dd("mobile").value == "")
			alert("请先输入手机号码");
		else{
			$.ajax({
	      url: 'ajax/attest.php',
	      data: 'action=get_mobile&mobile='+Dd("mobile").value,
	      type:"POST",
	      dataType:'text',
	
	      success: function(mytext){
	      	var arr = new Array();
	      	arr = mytext.split("|");
	      	if(arr[0]=='0'){
	      		Dd("mobile_attest_font").innerHTML = "尚无api建制功能，请在"+arr[2]+"前，在下方验证码填入『"+arr[1]+"』，并送出！";
	      		block("mobile_attest_font");
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
	function send_name_attest(){
		if(Dd('name_img').value=="")
			alert("请先选择照片在上传");
		else
			Dd("name_form").submit();
	}
	function send_bank_attest(){
		if(Dd('bank_img').value=="")
			alert("请先选择照片在上传");
		else
			Dd("bank_form").submit();
	}
</script>