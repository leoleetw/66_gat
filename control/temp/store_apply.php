<div class="col-lg-10 col-lg-offset-1">
	<table class='table'>
		<thead><tr><th>会员资讯</th><th>实名</th><th>手机</th><th>银行帐户</th><th>附件</th><th>申请日期</th><th>动作</th></tr></thead>
		<tbody>
		<?
			$sql = "select a.* , b.* , c.* from user a 
		inner join user_attest b on b.user_id = a.user_id 
		inner join store_apply c on c.user_id = a.user_id and c.sa_state = 0 
		where 1 order by c.apply_date";
			$result = mysqli_query($sqli,$sql);
			while($row = mysqli_fetch_array($result)){
		?>
		<tr id="tr<? echo $row["user_id"]; ?>">
			<td>
				<? echo $row["user_id"]."<br>".$row["user_name"]."<br>".$row["user_nick"]; ?>
			</td>
			<td>
					<img style="width:100px;" src="../update/attest/<? echo $row["name_photo"]; ?>">
			</td>
			<td>
					<? echo $row["mobile"]; ?>
			</td>
			<td>
					<img style="width:100px;" src="../update/attest/<? echo $row["bank_photo"]; ?>">
			</td>
			<td>
					<?
						if(trim($row["sa_photo"])!=""){
							$arr = Array();
							$arr = explode("|",$row["sa_photo"]);
							for($i = 0 ; $i < count($arr) ; ++$i){
					?>
								<img src="../update/store_apply/<? echo $arr[$i]; ?>" styly="width:100px;">
					<?
							}
						}
					?>
			</td>
			<td><? echo $row["apply_date"]; ?></td>
			<td><button class="btn btn-success" onclick="apply_check('pass',<? echo $row["user_id"]; ?>);">一般店家</button>
					<button class="btn btn-warning" onclick="apply_check('attest',<? echo $row["user_id"]; ?>);">认证店家</button>
					<button class="btn btn-danger" onclick="apply_check('fail',<? echo $row["user_id"]; ?>);">不通过</button>
			</td>
		</tr>
		<? } ?>
		</tbody>
	</table>
</div>

<script>
	//变更品牌内容
	function apply_check(result , user_id){
		$.ajax({
	      url: 'ajax/user.php',
	      data: 'action=check_store&result='+result+'&user_id='+user_id,
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