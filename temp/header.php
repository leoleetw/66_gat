<?
	define(_page , "/66_gat/");
	if($_COOKIE["cart"]=="" || $_COOKIE["cart"]==null){
		setcookie("cart","");
	}
?>
<div class="col-lg-12">
	<div class="row">
		<div class="header">
		  <div id="header_bar"></div>
		  <div id="logo" class="logo" onclick="location.href='index'"><img src="include/images/logo.png"></div>
		  <div class="cart_wrapper">
		    <div class="cart" onclick="location.href='cart.php'"></div>
		    <section class="login_wrapper">
		      <? if($_SESSION["user_id"]==""){ ?>
		        <a id="login" href='login.php' >登入</a>
		        <a id="register" href='register.php'>注册</a>
		      <? }else{ ?>
		        <a href='my.php' >我的帐号</a><a href='ajax/login.php?action=log_out'>登出</a>
		      <? } ?>
		    </section>
		  </div>
		</div>
	</div>
</div>

<script>
	function addtocart(item_id,store_id){
		var cart = $.cookie('cart');
		var temp = new Array();
		if(isnull(cart)==''){
			cart = new Array();
			temp = [item_id];
			var obj = {
			    store_id : store_id,
			    item : temp
			};
			cart[0] = obj;
		}
		else{
			cart = JSON.parse( cart );
			var error = false;
			var temp_store_id = 0;
			for(var i = 0 ; i < cart.length ; ++ i ){
				if(store_id == cart[i].store_id){
					error = true;
					temp_store_id = i ;
				}
			}
			if(error){
				var item = cart[temp_store_id].item;
				item.push(item_id);
				cart[temp_store_id].item = item;
			}
			else{
				var temp_obj = {
					store_id : store_id,
			    item : [ item_id ]
				};
				cart[cart.length]=temp_obj;
			}
		}
		cart = JSON.stringify( cart );
		$.cookie('cart',cart);
	}
	/* 150902
	function addtocart(item_id){
		var cart = $.cookie('cart');
		if(cart=='' || cart==undefined)
			cart = item_id;
		else
			cart += '|'+item_id;
		$.cookie('cart',cart);
	}
	*/
</script>