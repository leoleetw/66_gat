<?
	include_once("include/dbinclude.php");
?>

<div id="order_div" class='col-lg-12 row'>
	<?
		$sql = "select a.* ,b.store_name from `order` a inner join store b on a.store_id = b.store_id
		where a.order_user_id = ".$_SESSION["user_id"]." AND (a.pay_state >= 1 AND a.item_state >= 4) order by a.creat_date desc";
		$result = mysqli_query($sqli,$sql);
	?>

	<?
		while($row = mysqli_fetch_array($result)){
	?>
			<table class="table orderTable">
				<tr><th>订单编号</th><th>开始/结束时间</th><th>卖家名稱</th><th>订单金额</th><th>订单状态</th></tr>
				<tr>
					<td><div onclick="show_order_info('<? echo $row["order_id"]; ?>');"><? echo $row["order_id"]; ?></div></td>
					<td>
						<?
							echo $row["creat_date"];
							if($row["end_date"]!="0000-00-00 00:00:00")
								echo "<br>".$row["end_date"];
						?>
					</td>
					<td><? echo $row["store_name"]; ?></td>
					<td>
						<?
								echo $row["total_price"];
						?>
					</td>
					<td><? echo order_state('buy',$row["pay_state"],$row["item_state"]);?></td>
				</tr>
			</table>
			<div id="order_info_div<? echo $row["order_id"]; ?>" style="display:none;">

			</div>
	<?
		}
	?>
</div>
<script>
	var clickNo = -1;
	function show_order_info(order_id){
		if(Dd('order_info_div'+order_id).style.display=='none'){
			$.ajax({
	      url: 'ajax/order.php',
	      data: 'action=order_info&order_id='+order_id,//$('#sentToBack').serialize()
	      type:"POST",
	      dataType:'JSON',

	      success: function(myjson){
	      	var str = "";
	      	str += "<div class='col-lg-8'><table class='table orderDetail'>";
	      	str += "<tr class='blueTitle'><th colspan='2'>商品清单</th><th>价格</th><th>数量</th><th>总价</th></tr>";
	      	for(var i = 0 ; i < myjson.item_info.length ; ++i){
	      		str += "<tr><td><div class='miniPhoto_wrapper'><img src='update/item_s/"+myjson.item_info[i].item_photo+"'></div></td>";
	      		str += "<td>"+myjson.item_info[i].item_name+"</td>";
	      		str += "<td>"+myjson.item_info[i].item_price+"</td>";
	      		str += "<td>"+myjson.item_info[i].item_count+"</td>";
	      		str += "<td>"+(myjson.item_info[i].item_price*myjson.item_info[i].item_count)+"</td></tr>";
	      	}
	      	str += "<tr><td class='blueTitle'>订单备注</td><td colspan='4'>"+myjson.rec_note+"</td></tr></table>";
	      	str += "</div><div class='col-lg-4'><table class='table orderDetail_table'><tr><th colspan='2' class='blueTitle'>购买资讯</th></tr>";
	      	str += "<tr><td colspan='2'>收件人︰"+myjson.rec_name+"<br>手机︰"+myjson.rec_mobile+"<br>收件地址︰"+myjson.rec_city_area+myjson.rec_city_name+myjson.rec_addr+"</td></tr>";
	      	str += "<tr><td class='blueTitle'>商品金额</td><td>";
	      	if(myjson.total_item_price != myjson.edit_price)
	      		str += myjson.edit_price+"（"+myjson.total_item_price+"）";
	      	else
	      		str += myjson.edit_price;
	      	str += "</td></tr><tr><td class='blueTitle'>运费</td><td>"+myjson.order_shipment+"</td></tr><tr><td class='blueTitle'>订单金额</td><td>"+myjson.total_price+"</td></tr></table></div>";
	      	$('#order_info_div'+myjson.order_id).html(str);
	      	$('#order_div>div').stop(true,true).slideUp('middle');
	      	$('#order_info_div'+myjson.order_id).stop(true,true).slideDown('middle');
	      },

	       error:function(xhr, ajaxOptions, thrownError){
	          alert(xhr.status);
	          alert(thrownError);
	       }
	  	});
	  }
	  else{
	  	$('#order_info_div'+order_id).stop(true,true).slideUp('middle');
	  }
	}
	function payinfo(order_id){
		window.open('payinfo.php?order_id='+order_id, '付款资讯', 'height=400,width=300,resizable=no,location=no');
	}
</script>