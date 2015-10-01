<section>
	<div id="footer" style="clear:both">
	    <div class="goTop"></div>
	    <div class="footer_main">
	    	<ul>
	    		<h4>关于我们<br/>About Us</h4>
	    		<li><a href="article.php?action=about">关于我们</a></li>
	    		<li><a href="article.php">常见问题</a></li>
	    	</ul>
	    	<ul>
	    		<h4>购物相关<br/>Shopping Guide</h4>
	    		<li><a href="article.php">购物说明</a></li>
	    		<li><a href="article.php">付款说明</a></li>
	    		<li><a href="article.php">运送说明</a></li>
	    	</ul>
	    	<ul>
	    		<h4>会员相关<br/>Member</h4>
	    		<? if($_SESSION["user_id"]==""){ ?>
	    		<li><a href="login.php">登入会员</a></li>
	    		<li><a href="register.php">注册会员</a></li>
	    		<?	}else{	?>
	    		<li><a href="my.php">我的帐号</a></li>
	    		<li><a href="mystore.php">我的店家</a></li>
	    		<?	}	?>
	    	</ul>
	    	<ul>
	    		<h4>联络我们<br/>Contact Us</h4>
	    		<li>客服电话:xx-xxx-xx</li>
	    		<li>客服信箱:xx-xxx-xx@mail</li>
	    	</ul>
		</div>
   		<div class="footer_bottom">
   			<!--<div id="people">總來訪人數:</div>-->
    		<a href="http://www.tjbyslt.com/" target="_blank">天津市宝玉石流通行业协会 © 2015</a>
    	</div>
	</div>
</section>
<script>
	$(".goTop").click(function(){
			$('html,body').animate({scrollTop:'0px'},200);
	});
</script>
