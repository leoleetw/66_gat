<div class="col-lg-10 col-lg-offset-1">
	<form>
		<select>
			<option value='order_id'>订单编号</option>
			<option value='user_name'>买家姓名</option>
			<option value='order_info_id'>买家编号</option>
			<option value='store_name'>店家名称</option>
			<option value='store_id'>店家编号</option>
		</select>
		<input type='text' id='' name='' value=''>
		<button type='button' class='btn btn-primary' id='' >搜寻</button>
	</form>
	<table class='table'>
		<thead><tr><th>订单编号</th><th>买家资讯</th><th>店家</th><th>付款资讯</th><th>物品资讯</th><th>其余操作</th></tr></thead>
		<tbody>
		<?
			if($_GET["nowpage"]=='')
				$nowpage = 1;
			else
				$nowpage = $_GET["nowpage"];
			
			if($_GET["sql"]==""){
				$sql = "select a.* , b.store_name,c.user_name from `order` a 
				inner join store b on a.store_id = b.store_id 
				inner join user c on c.user_id = a.order_user_id ";
				if($_POST["search_value"] !="" ){
					$sql .= "";
				}
				$sql .= "order by a.creat_date DESC";
			}
			else
				$sql = $_GET["sql"];
			$result = mysqli_query($sqli,$sql);
			while($row = mysqli_fetch_array($result)){
				$btn_text = "";
				$btn_disabled = false;
				if($row["order_check"]==0){
					$btn_text = "买家已付款";
					$btn_disabled = true;
				}
				else if($row["pay_state"]==0)
					$btn_text = "买家已付款";
				else if($row["item_state"]==0)
					$btn_text = "货物运送平台途中";
				else if($row["item_state"]==1)
					$btn_text = "货物已到达平台";
				else if($row["item_state"]==2)
					$btn_text = "货物运送买家途中";
				else if($row["item_state"]==3)
					$btn_text = "货物已送达买家";
				else if($row["pay_state"]==1)
					$btn_text = "款项已汇至卖家";
				else{
					$btn_text = "已结单";
					$btn_disabled = true;
				}
					
		?>
				<tr>
					<td><? echo $row["order_id"]; ?></td>
					<td><? echo $row["user_name"]."(".$row["order_user_id"].")"; ?></td>
					<td><? echo $row["store_name"]; ?></td>
					<td><? echo pay_state($row["pay_state"]); ?></td>
					<td><? echo item_state($row["item_state"]); ?></td>
					<td><button type='button' id='change_state_btn' class='btn btn-primary' onclick="change_state(<? echo $row["order_id"];?>);" <? if($btn_disabled){echo "disabled";}?>><? echo $btn_text; ?></button></td>
				</tr>
		<? } ?>
		</tbody>
	</table>
</div>

<script>
	function change_state(order_id){
		if(confirm("确定更改状态？此动作为不可逆行为")){
			$.ajax({
	      url: 'ajax/order.php',
	      data: 'action=change_state&order_id='+order_id,
	      type:"POST",
	      dataType:'text',
	
	      success: function(mytext){
	      	var arr = new Array();
	      	arr = mytext.split("|");
	      	if(arr[0]=='0'){
	      		history.go(0);
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
</script>