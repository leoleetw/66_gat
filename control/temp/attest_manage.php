<div class="col-lg-6 col-lg-offset-3">
	<table class='table'>
		<thead><tr><th>会员资讯</th><th>实名认证</th><th>银行帐户认证</th><th>申请日期</th></tr></thead>
		<tbody>
		<?
			$sql = "select a.* , b.* from user_attest a , user b where a.user_id = b.user_id AND (name_attest = 0 OR bank_attest = 0) order by a.apply_date DESC;";
			$result = mysqli_query($sqli,$sql);
			while($row = mysqli_fetch_array($result)){
		?>
		<tr>
			<td>
				<? echo $row["user_id"]."<br>".$row["user_name"]."<br>".$row["user_nick"]; ?>
			</td>
			<td>
				<? if($row["name_photo"]!=""){ ?>
					<img style="width:150px;" src="../update/attest/<? echo $row["name_photo"]; ?>"><br>
						<button id="name_pass_btn<? echo $row["user_id"]; ?>" <? if($row["name_attest"] == 1){ echo "style='display:none;'";}?> class="btn btn-success" onclick="check_attest('name',<? echo $row["user_id"]; ?>,'pass');">通过</button>
						<button id="name_fail_btn<? echo $row["user_id"]; ?>" <? if($row["name_attest"] == 2){ echo "style='display:none;'";}?> class="btn btn-danger" onclick="check_attest('name',<? echo $row["user_id"]; ?>,'fail');">不通过</button>
				<? } ?>
			</td>
			<td>
				<? if($row["bank_photo"]!=""){ ?>
					<img style="width:150px;" src="../update/attest/<? echo $row["bank_photo"]; ?>"><br>
						<button id="bank_pass_btn<? echo $row["user_id"]; ?>" <? if($row["bank_attest"] == 1){ echo "style='display:none;'";}?> class="btn btn-success" onclick="check_attest('bank',<? echo $row["user_id"]; ?>,'pass');">通过</button>
						<button id="bank_fail_btn<? echo $row["user_id"]; ?>" <? if($row["bank_attest"] == 2){ echo "style='display:none;'";}?> class="btn btn-danger" onclick="check_attest('bank',<? echo $row["user_id"]; ?>,'fail');">不通过</button>
				<? } ?>
			</td>
			<td><? echo $row["apply_date"]; ?></td>
		</tr>
		<? } ?>
		</tbody>
	</table>
</div>

<script>
	//变更品牌内容
	function check_attest(subject , user_id , result){
		$.ajax({
	      url: 'ajax/attest.php',
	      data: 'action=check&subject='+subject+'&user_id='+user_id+"&result="+result,
	      type:"POST",
	      dataType:'text',
	
	      success: function(mytext){
	      	var arr = new Array();
	      	arr = mytext.split("|");
	      	if(arr[0]=='0'){
	      		none(arr[1]+"_"+arr[3]+"_btn"+arr[2]);
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