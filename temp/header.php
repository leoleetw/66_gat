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
		        <a href='my_order.php' >我的帐号</a><a href='ajax/login.php?action=log_out'>登出</a>
		      <? } ?>
		    </section>
		  </div>
		</div>
	</div>
</div>

<script>
	function addtocart(item_id){
		var cart = $.cookie('cart');
		if(cart=='')
			cart += item_id;
		else
			cart += '|'+item_id;
		$.cookie('cart',cart);
	}
</script>