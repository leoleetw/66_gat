<div class="col-lg-6 col-lg-offset-3">
	<div class='col-lg-8'><input type="text" class="form-control" id="search_value" name="search_value" value=""></div>
	<div class='col-lg-4'><button type="button" id="search_btn" class="btn btn-primary" >搜寻</button></div>
	<table class='table'>
		<thead><tr><th>帐号</th><th>真实姓名</th><th>昵称</th><th>动作</th></tr></thead>
		<tbody>
		<?
			$sql = "select * from user order by user_id desc";
			$result = mysqli_query($sqli,$sql);
			while($row = mysqli_fetch_array($result)){
		?>
		<tr>
			<td>
				<? echo $row["email"]; ?>
			</td>
			<td><div id='user_name<? echo $row["user_id"]; ?>'><? echo $row["user_name"]; ?></div></td>
			<td><? echo $row["user_nick"]; ?></td>
			<td>
				<button type="button" id="search_btn" class="btn btn-primary" onclick="change_name(<? echo $row["user_id"]; ?>);">更改真实姓名</button>
				<button type="button" id="search_btn" class="btn btn-primary" onclick="change_pwd(<? echo $row["user_id"]; ?>);">更改密码</button>
			</td>
		</tr>
		<? } ?>
		</tbody>
	</table>
</div>
<div class="modal fade" id="name_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      	<h1 align='center'>变更姓名</h1>
      </div>
      <div class="modal-body">
      	<input type="hidden" id="name_user_id" value="">
      	<label>原始姓名︰</label>
      	<input type="text" class="form-control" id="user_name" value="" readonly>
      	<label>新姓名︰</label>
      	<input type="text" class="form-control" id="new_name" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary" id='name_btn'>确定</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="pwd_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      	<h1 align='center'>变更密码</h1>
      </div>
      <div class="modal-body">
      	<input type="hidden" id="pwd_user_id" value="">
      	<label>新密码︰</label>
      	<input type="password" class="form-control" id="user_pwd" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary" id='pwd_btn'>确定</button>
      </div>
    </div>
  </div>
</div>
<script>
	$('#name_btn').click(function(e){
		$.ajax({
	      url: 'ajax/user.php',
	      data: 'action=change_name&name='+$('#new_name').val()+'&user_id='+$('#name_user_id').val(),
	      type:"POST",
	      dataType:'text',
	
	      success: function(mytext){
	      	var arr = new Array();
	      	arr = mytext.split("|");
	      	if(arr[0]=='0'){
	      		
	      		$('#name_Modal').modal('hide');
	      		alert('成功变更');
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
	});
	$('#pwd_btn').click(function(e){
		$.ajax({
	      url: 'ajax/user.php',
	      data: 'action=change_pwd&user_pwd='+$('#user_pwd').val()+'&user_id='+$('#pwd_user_id').val(),
	      type:"POST",
	      dataType:'text',
	
	      success: function(mytext){
	      	var arr = new Array();
	      	arr = mytext.split("|");
	      	if(arr[0]=='0'){
	      		$('#user_pwd').val('');
	      		$('#pwd_Modal').modal('hide');
	      		alert('成功变更');
	      	}
	      	else if(arr[0]=='1'){
	      		$('#user_pwd').val('');
	      		$('#pwd_Modal').modal('hide');
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
	});
	function change_name(user_id){
		$('#name_user_id').val(user_id);
		$('#user_name').val(Dd('user_name'+user_id).innerHTML);
		$('#name_Modal').modal({
			backdrop:"static",
			keyboard:false
		});
	}
	function change_pwd(user_id){
		$('#pwd_user_id').val(user_id);
		$('#pwd_Modal').modal({
			backdrop:"static",
			keyboard:false
		});
	}
	//变更品牌内容
	function apply_check(result , user_id){
		$.ajax({
	      url: 'ajax/store_apply.php',
	      data: 'action=check&result='+result+'&user_id='+user_id,
	      type:"POST",
	      dataType:'text',
	
	      success: function(mytext){
	      	var arr = new Array();
	      	arr = mytext.split("|");
	      	if(arr[0]=='0'){
	      		$('#tr'+arr[1]).remove();
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