<div class="">
	<h3>购物车</h3>
</div>
<div>
	<?
		$cart = json_decode( $_COOKIE["cart"] );
	?>
	<ul class="nav nav-tabs" role="tablist">
	<?
		for($i = 0 ; $i < count($cart) ; ++$i){
			$sql = "select store_name from store where store_id = ".$cart[$i]->store_id;
			$result = mysqli_query($sqli,$sql);
			$row = mysqli_fetch_array($result);
	?>
		<li role="presentation" <? if($i == 0) { echo "class='active'";}?>><a href="#<? echo $cart[$i]->store_id;?>_tab" aria-controls="<? echo $cart[$i]->store_id;?>_tab" role="tab" data-toggle="tab"><? echo $row["store_name"]; ?></a></li>
	<?
		}
	?>
	</ul>
	<div class="tab-content">
		<?
			for($i = 0 ; $i < count($cart) ; ++$i){
		?>
		
		  <div role="tabpanel" class="tab-pane <? if($i == 0) { echo "active";}?>" id="<? echo $cart[$i]->store_id;?>_tab">
		  	<form id='cart_form<? echo $cart[$i]->store_id;?>' action='fillin_order.php' method="POST">
		  			<table id="cart_table" class='table'>
							<tr><th>商品</th><th>单价</th><th>数量</th><th>金额</th><th>操作</th></tr>
						<?
								$total_price = 0;
								for($item_count = 0 ; $item_count < count($cart[$i]->item) ; ++$item_count){
									$sql_cart = "select item_id , item_price , item_stock ,item_photo,item_name from item where item_id=".$cart[$i]->item[$item_count];
									$result_cart = mysqli_query($sqli,$sql_cart);
									$row_cart = mysqli_fetch_array($result_cart);
									$photo_img = explode("|",$row_cart["item_photo"]);
						?>
									<tr id="cart_tr<? echo $row_cart["item_id"]; ?>">
										<td><img src="update/item_s/<? echo $photo_img[0]; ?>" style="width:50px;"><? echo $row_cart["item_name"];?></td>
										<td id="item_price<? echo $row_cart["item_id"]; ?>"><? echo $row_cart["item_price"]; ?></td>
										<td>
											<input type="hidden" id="cart_item_stock<? echo $row_cart["item_id"]; ?>" value="<? echo $row_cart["item_stock"]; ?>">
											<div style="float:left" onclick="change_count('less',<? echo $row_cart["item_id"].",".$cart[$i]->store_id; ?>);">-</div><input type="text" id="cart_item_count<? echo $row_cart["item_id"]; ?>" name="cart_item_count<? echo $row_cart["item_id"]; ?>" class="form-control" style="width:90%;float:left" value="1" readonly><div style="float:left" onclick="change_count('add',<? echo $row_cart["item_id"].",".$cart[$i]->store_id; ?>);">+</div>
										</td>
										<td id="item_total_price<? echo $row_cart["item_id"]; ?>"><? echo $row_cart["item_price"]; ?></td>
										<td><a href="#" onclick="remove_cart(<? echo $row_cart["item_id"].",".$cart[$i]->store_id; ?>);">删除</a></td>
									</tr>
						<?		
									$total_price += intval($row_cart["item_price"]);
								}
						?>
								<tr>
									<input type="hidden" id="store_id" name="store_id" value="<? echo $cart[$i]->store_id;?>">
									<td><button type="button"  class="btn btn-default" onclick="clear_cart(<? echo $cart[$i]->store_id;?>);">清空購物車</button></td>
									<td colspan='3' style="text-align:right">合计︰<font id="total_price<? echo $cart[$i]->store_id;?>"><? echo $total_price; ?></font></td>
									<td><button type="button" class="btn btn-primary" onclick="Dd('cart_form<? echo $cart[$i]->store_id;?>').submit();">结帐</button></td></tr>
						</table>
				</form>
			</div>
		
		<? } ?>
	</div>
</div>
<script>
	function change_count(this_type , item_id ,store_id){
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
	function clear_cart(store_id){
		var cart = $.cookie('cart');
		cart = JSON.parse( cart );
		for(var i = 0 ; i < cart.length ; ++i)
			if(cart[i].store_id == store_id)
				cart.splice( i, 1 );
		cart = JSON.stringify( cart );
		$.cookie('cart',cart);
		history.go(0);
	}
	function remove_cart(item_id,store_id){
		
		var cart = $.cookie('cart');
		cart = JSON.parse( cart );
		var error = false;
		for(var i = 0 ; i < cart.length ; ++i)
			if(cart[i].store_id == store_id){
				if(cart[i].item.length == 1){
					cart.splice( i, 1 );
					error = true;
				}
				else{
					for(var n = 0 ; n < cart[i].item.length ; ++n){
						if(cart[i].item[n] == item_id){
							cart[i].item.splice( n, 1 );
						}
					}
				}
			}
		cart = JSON.stringify( cart );
		$.cookie('cart',cart);
		Dd("total_price"+store_id).innerHTML = parseInt(Dd("total_price"+store_id).innerHTML)-parseInt(Dd("item_total_price"+item_id).innerHTML);
		$('#cart_tr'+item_id).remove();
		if(error)
			history.go(0);
	}
</script>