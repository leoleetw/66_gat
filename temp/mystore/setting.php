<?
	include_once("include/dbinclude.php");
	$sql = "select a.* , b.* from store a inner join user b on a.user_id = b.user_id where a.user_id =".$_SESSION["user_id"];
	$result = mysqli_query($sqli,$sql);
	$row = mysqli_fetch_array($result);
?>
<form id="store_form" action="ajax/mystore.php" method="post" enctype="multipart/form-data">
		<div class="keyIn_wrapper">
			<div class='col-lg-2' style="text-align:right;"><font class="keyIn_text">店家编号︰</font></div>
			<div class='col-lg-10'><? echo $row["store_id"];?></div>
		</div>
		<div class="keyIn_wrapper">
			<div class='col-lg-2' style="text-align:right;"><font class="keyIn_text">店家名称︰</font></div>
			<div class='col-lg-10 keyIn_underline'><input type='text' class='form-control' id='store_name' name='store_name' value='<? echo $row['store_name'];?>'></div>
		</div>
		<div class="keyIn_wrapper_plus">
			<div class='col-lg-2' style="text-align:right;"><font class="keyIn_text">店家标志︰</font></div>
			<div class='col-lg-10 keyIn_underline'>
				<div class="miniPhoto_wrapper"><img src='update/store/<? echo $row["store_logo"];?>?<? echo rand();?>'></div>
				<input type='file' id='store_logo' name='store_logo' class="file" accept="image/*">
				<div class="store_set"></div>
			</div>
		</div>
		<div class="keyIn_wrapper_plus">
			<div class='col-lg-2' style="text-align:right;"><font class="keyIn_text">店家介绍︰</font></div>
			<div class='col-lg-10 keyIn_underline'>
				<textarea id='store_introduce' name='store_introduce' class='form-control'><? echo $row['store_introduce'];?></textarea>
			</div>
		</div>








		<!--div>店家编号︰<? echo $row["store_id"];?></div>
		<div>
			店家名称︰<input type='text' class='form-control' id='store_name' name='store_name' value='<? echo $row['store_name'];?>'>
			店家标志︰<img src='update/store/<? echo $row["store_logo"];?>?<? echo rand();?>' style='width:150px;'><input type='file' id='store_logo' name='store_logo' class="file" accept="image/*">
			店家介绍︰<textarea id='store_introduce' name='store_introduce' class='form-control'><? echo $row['store_introduce'];?></textarea>
		</div-->
	<input type='hidden' id='store_id' name='store_id' value='<? echo $row['store_id'];?>'>
	<input type='hidden' id='action' name='action' value='setting'>
	<button type='button' id='save_btn' name='save_btn' class='btn btn-primary saveBtn'>储　存</button>
</form>
<script>
	$('#save_btn').click(function(e){
		if($('#store_name').val().trim()=='')
			alert('店舖名称不得为空');
		else if($('#store_name').val().length > 20)
			alert('店舖名称长度不得超过20个字');
		else
			Dd('store_form').submit();
	});
</script>