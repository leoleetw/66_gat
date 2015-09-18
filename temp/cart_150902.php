<div class="">
	<h3>购物车</h3>
</div>
<form id='cart_form' action='fillin_order.php' method="POST">
	<div class="">
		<table id="cart_table" class='table'>
			<tr><th>商品</th><th>单价</th><th>数量</th><th>金额</th><th>操作</th></tr>
		<?
			if($_COOKIE["cart"] == ""){
			}
			else{
				echo $_COOKIE["cart"];
				$cart = explode("|",$_COOKIE["cart"]);
				$total_price = 0;
				for($cart_count = 0 ; $cart_count < count($cart) ; ++$cart_count){
					$item = explode(",",$cart[$cart_count]);
					$sql_cart = "select item_id , item_price , item_stock ,item_photo,item_name from item where item_id=".$item[0];
					$result_cart = mysqli_query($sqli,$sql_cart);
					$row_cart = mysqli_fetch_array($result_cart);
					$photo_img = explode("|",$row_cart["item_photo"]);
		?>
					<tr id="cart_tr<? echo $row_cart["item_id"]; ?>">
						<td><img src="update/item_s/<? echo $photo_img[0]; ?>" style="width:50px;"><? echo $row_cart["item_name"];?></td>
						<td id="item_price<? echo $row_cart["item_id"]; ?>"><? echo $row_cart["item_price"]; ?></td>
						<td>
							<input type="hidden" id="cart_item_stock<? echo $row_cart["item_id"]; ?>" value="<? echo $row_cart["item_stock"]; ?>">
							<div style="float:left" onclick="change_count('less',<? echo $row_cart["item_id"]; ?>);">-</div><input type="text" id="cart_item_count<? echo $row_cart["item_id"]; ?>" name="cart_item_count<? echo $row_cart["item_id"]; ?>" class="form-control" style="width:90%;float:left" value="1" readonly><div style="float:left" onclick="change_count('add',<? echo $row_cart["item_id"]; ?>);">+</div>
						</td>
						<td id="item_total_price<? echo $row_cart["item_id"]; ?>"><? echo $row_cart["item_price"]; ?></td>
						<td><a href="#" onclick="remove_cart(<? echo $row_cart["item_id"]; ?>);">删除</a></td>
					</tr>
		<?		
					$total_price += intval($row_cart["item_price"]);
				}
		?>
				<tr>
					<td><button type="button"  class="btn btn-default" onclick="$.cookie('cart','');">清空購物車</button></td>
					<td colspan='3' style="text-align:right">合计︰<font id="total_price"><? echo $total_price; ?></font></td>
					<td><button type="button" class="btn btn-primary" onclick="Dd('cart_form').submit();">结帐</button></td></tr>
		<?
			}
		?>
		</table>
		
	</div>
</form>
<script>
	function change_count(this_type , item_id){
		if(this_type=='less'){
			if(parseInt(Dd("cart_item_count"+item_id).value) > 1){
				Dd("cart_item_count"+item_id).value = (parseInt(Dd("cart_item_count"+item_id).value)-1) ;
				Dd("item_total_price"+item_id).innerHTML = (parseInt(Dd("item_price"+item_id).innerHTML))*(parseInt(Dd("cart_item_count"+item_id).value));
				Dd("total_price").innerHTML = parseInt(Dd("total_price").innerHTML)-parseInt(Dd("item_price"+item_id).innerHTML);
			}
		}
		else if(this_type=='add'){
			if(parseInt(Dd("cart_item_count"+item_id).value) < parseInt(Dd("cart_item_stock"+item_id).value)){
				Dd("cart_item_count"+item_id).value = (parseInt(Dd("cart_item_count"+item_id).value)+1) ;
				Dd("item_total_price"+item_id).innerHTML = (parseInt(Dd("item_price"+item_id).innerHTML))*(parseInt(Dd("cart_item_count"+item_id).value));
				Dd("total_price").innerHTML = parseInt(Dd("total_price").innerHTML)+parseInt(Dd("item_price"+item_id).innerHTML);
			}
		}
	}
	
	function remove_cart(item_id){
		var cart = $.cookie('cart');
		var temp = cart.split("|");
		for(var i = temp.length - 1; i >= 0; i--){
	    if(temp[i] == item_id) {
	       temp.splice(i, 1);
	    }
		}
		$.cookie('cart',temp.join("|"));
		Dd("total_price").innerHTML = parseInt(Dd("total_price").innerHTML)-parseInt(Dd("item_total_price"+item_id).innerHTML);
		$('#cart_tr'+item_id).remove();
	}
</script>