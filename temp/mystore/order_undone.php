<?
	include_once("include/dbinclude.php");
?>

<div id="order_div" class='col-lg-12'>
	<div class="row">
	<?
		$sql = "select a.*,c.user_nick from `order` a inner join store b on a.store_id = b.store_id
		inner join user c on a.order_user_id = c.user_id
		where b.user_id = ".$_SESSION["user_id"]." AND a.order_state = 0 and (a.pay_state < 2 OR a.item_state < 4) order by a.creat_date desc";
		//echo $sql;
		/*
		$sql = "select a.* , b.* from `order` a
		inner join order_store b on a.order_id = b.order_id
		inner join store c on b.store_id = c.store_id
		where c.user_id = ".$_SESSION["user_id"]." AND order_state < 3 order by a.creat_date desc";
		*/
		$result = mysqli_query($sqli,$sql);
	?>
		<table class="table orderTable">
			<tr><th>卖家确认</th><th>订单编号</th><th>开始时间</th><th>買家名稱</th><th>订单金额</th><th>买家付款状态</th><th>出货状态</th></tr>
	<?
		while($row = mysqli_fetch_array($result)){
			$order_id_length = $length = strlen((string) $row["order_id"]);
			$order_id = "A";
			for($i = $order_id_length ; $i < 9 ; ++$i )
				$order_id .= "0";
			$order_id .= $row["order_id"];
	?>
			<tr>
				<td>
					<?
						if($row["order_check"]==0)
							echo "<img src='include/images/x_no.png'>";
						else if($row["order_check"] == 1)
							echo "<img src='include/images/v_yes.png'>";
					?>
				</td>
				<td><a onclick="order_info(<? echo $row["order_id"]; ?>);"><? echo $order_id; ?></a></td>
				<td><? echo $row["creat_date"]; ?></td>
				<td><? echo $row["user_nick"]; ?></td>
				<td>
					<?
							echo $row["total_price"];
					?>
				</td>
				<td><? echo pay_state($row["pay_state"]);?></td>
				<td><? echo item_state($row["item_state"]);?></td>
			</tr>
	<?
		}
	?>
		</table>
	</div>
</div>
<div id="order_info_div" style="display:none;">
	<div class='col-lg-12'>
		<div class="orderDetail_title">订单编号︰<font id="order_id"></font></div>
		<table width="100%" id="order_item_table" class='table orderDetail'>
		</table>
	</div>
	<div class='col-lg-7'>
	<table width="100%" class='table orderDetail_table'>
		<tr>
			<td class="greenTitle">下订时间</td>
			<td id="creat_date"></td>
			<td class="greenTitle">卖家付款状态</td>
			<td>
				<input type='hidden' id='pay_state' value=''>
				<font id='pay_state_font'></font>
			</td>
		</tr>
		<tr>
			<td class="greenTitle">结束时间</td>
			<td id="end_date"></td>
			<td class="greenTitle">出货状态</td>
			<td>
				<input type='hidden' id='item_state' value=''>
				<font id='item_state_font'></font>
			</td>
		</tr>
		<tr>
			<td class="greenTitle">订单备注</td>
			<td id="order_note" colspan='3'></td>
		</tr>
	</table>
	</div>
	<div class='col-lg-5'>
		<table width="100%" class='table orderDetail_table'>
			<tr>
				<td class="greenTitle">商品金额</td>
				<td>
					<input type='hidden' id='total_item_price' value=''>
					<div id='total_price_div'>
						<font id='total_price_font'></font>
						<button type='button' id='show_change_btn' class='btn btn-primary editBtn' onclick="none('total_price_div');block('edit_price_div');">更改</button>
					</div>
					<div id='edit_price_div' style='display:none'>
						<input type='text' class='form-control' id='edit_price' value='' style='width:50%;float:left;'>
						<button type='button' id='change_price_btn' class='btn btn-primary editButton'>储存</button>
					</div>
				</td>

			</tr>
			<tr>
				<td class="greenTitle">运费</td>
				<td id='order_shipment'></td>
			</tr>
			<tr>
				<td class="greenTitle">订单总额</td>
				<td><h3 id='order_total_price'></h3></td>
			</tr>
			<tr>
				<td colspan='2' class="set_up">
					<input type='hidden' id='order_check' value='0'>
					<a id='order_state_btn'>成立订单</a>
				</td>
			</tr>
		</table>
	</div>
	<button type="button" class="btn btn-primary previousPage" onclick="none('order_info_div');block('order_div');">回上页</button>
</div>
<script>
	$('#order_state_btn').click(function(e){
		if($('#order_check').val()=='0'){
			if(confirm("成立订单後将不得再度更改金额，确定成立订单？")){
				$.ajax({
		      url: 'ajax/order.php',
		      data: 'action=seller_check&order_id='+$('#order_id').html(),//$('#sentToBack').serialize()
		      type:"POST",
		      dataType:'text',

		      success: function(mytext){
		      	var arr = new Array();
		      	arr = mytext.split("|");
		      	if(arr[0]=='0'){
		      		none('show_change_btn');
		      		Dd('order_state_btn').disabled='disabled';
		      		$('#order_state_btn').html('订单已成立');
      				$('.set_up').css({background:"#999",cursor:"no-drop"});
		      	}
		      	else if(arr[0]=='1')
		      		alert('error');
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
	});
	$('#change_price_btn').click(function(e){
		$.ajax({
      url: 'ajax/order.php',
      data: 'action=order_change_price&order_id='+$('#order_id').html()+'&edit_price='+$('#edit_price').val(),//$('#sentToBack').serialize()
      type:"POST",
      dataType:'text',

      success: function(mytext){
      	var arr = new Array();
      	arr = mytext.split("|");
      	if(arr[0]=='0'){
      		if(parseInt($('#edit_price').val())==parseInt($('#total_item_price').val()))
      			$('#total_price_font').html($('#edit_price').val());
      		else
      			$('#total_price_font').html($('#edit_price').val()+"("+$('#total_item_price').val()+")");
      		$('#order_total_price').html(parseInt($('#edit_price').val())+parseInt($('#order_shipment').html()));
      		none('edit_price_div');
      		block('total_price_div');
      	}
      	else if(arr[0]=='1')
      		alert('error');
      	else
      		alert(mytext);

      },

       error:function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
       }
  	});
	});
	function order_info(order_id){
		$.ajax({
      url: 'ajax/order.php',
      //data: 'action=order_store&store_id='+store_id+'&order_id='+order_id,//$('#sentToBack').serialize() *150902
      data: 'action=order_info&order_id='+order_id,//$('#sentToBack').serialize()
      type:"POST",
      dataType:'JSON',

      success: function(myjson){
      	$('#order_id').html(myjson.order_id);
      	$('#creat_date').html(myjson.creat_date);
      	if(myjson["end_date"]!="0000-00-00 00:00:00")
      		$('#end_date').html(myjson.end_date);
      	$('#order_note').html(myjson.rec_note);
      	$('#pay_state').val(myjson.pay_state);
      	$('#pay_state_font').html(myjson.pay_state_font);
      	$('#item_state').val(myjson.item_state);
      	$('#item_state_font').html(myjson.item_state_font);
      	$('#total_item_price').val(myjson.total_price);
      	$('#edit_price').val(myjson.edit_price);
      	$('#order_check').val(myjson.order_check);
      	$('#order_shipment').html(myjson.order_shipment);
      	$('#order_total_price').html(myjson.total_price);
      	if(myjson.order_check != 0 ){
      		none('show_change_btn');
      		$('#order_state_btn').html('订单已成立');
      		$('.set_up').css({background:"#999",cursor:"no-drop"});
      	}
      	else{
      		block('show_change_btn');
      		$('#order_state_btn').html('成立订单');
      	}
      	var str = "";
      	str = "<tr class='greenTitle'><th>商品编号</th><th>商品名称</th><th>价格</th><th>数量</th><th>总价</th><th>图片</th></tr>";
      	for(var i = 0 ; i < myjson.item_info.length ; ++i){
      		str += "<tr><td>"+myjson.item_info[i].item_id+"</td>";
      		str += "<td>"+myjson.item_info[i].item_name+"</td>";
      		str += "<td>"+myjson.item_info[i].item_price+"</td>";
      		str += "<td>"+myjson.item_info[i].item_count+"</td>";
      		str += "<td>"+(myjson.item_info[i].item_price*myjson.item_info[i].item_count)+"</td>";
      		str += "<td><div class='miniPhoto_wrapper'><img src='update/item_s/"+myjson.item_info[i].item_photo+"'></td></tr>";
      	}
      	$('#order_item_table').html(str);
      	if(myjson.edit_price != myjson.total_item_price)
      		$('#total_price_font').html(myjson.edit_price+"("+myjson.total_item_price+")");
      	else
      		$('#total_price_font').html(myjson.edit_price);
      	none('order_div');
      	block('order_info_div');
      },

       error:function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
       }
  	});
	}
</script>