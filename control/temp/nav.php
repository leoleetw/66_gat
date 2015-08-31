<?
	include_once('ajax/config.php');
?>
<!--span class="navbar-header"><a class="navbar-brand" href="index.php"></a></span-->
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

    <div class="navbar-header">
    </div>
    <ul class="nav navbar-top-links navbar-right">
        <li>
						<a href="../index.php"><i class="fa fa-home fa-fw"></i> 首頁</a>
        </li>

        <!--li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="viewuser.php"><i class="fa fa-user fa-fw"></i>個人資料</a>
                </li>
                <li><a href="#" onclick="$('#pwd_model').modal('show');"><i class="fa fa-gear fa-fw"></i> 修改密碼</a>
                </li>
                <li class="divider"></li>
                <li><a href="#" onclick="logout();"><i class="fa fa-sign-out fa-fw"></i> 登出</a>
                </li>
            </ul>
        </li-->
    </ul>
      <div align="center">
				  <table width='100%'>
						<tr>
							<td width='10%'>
							</td>
						</tr>
					</table>
			</div>
		<div class="navbar-default sidebar" role="navigation">
      <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
          <li>
						<?php if($_SERVER['PHP_SELF']==_page."index.php"){ ?>
							<a class="active" href="index.php"><i class="fa fa-dashboard fa-fw"></i> 首頁</a>
						<?php }
						else{ ?>
							<a href="index.php"><i class="fa fa-home fa-fw"></i> 回首頁</a>
						<?php } ?>
          </li>
          
		
          
          <?php if($_SERVER['PHP_SELF']==_page."cate_manage.php" || $_SERVER['PHP_SELF']==_page."brand_manage.php"){ ?>
            <li class="active">
          <?php }else{ ?>
          	<li>
          <?php } ?>
	            <a href="#"><i class="fa fa-search fa-fw"></i> 网站管理<span class="fa arrow"></span></a>
	            <ul class="nav nav-second-level">
	            	<?php 
	            		if($_SERVER['PHP_SELF']==_page."cate_manage.php"){ 
	            	?>
	                <li>
	                    <a class="active" href="cate_manage.php"><i class="fa fa-users fa-fw"></i>分类管理</a>
	                </li>
	              <?php }
	              			else{ ?>
	              	<li>
	                    <a href="cate_manage.php"><i class="fa fa-users fa-fw"></i>分类管理</a>
	                </li>
	               <?php } ?>
	               
	               <?php 
	            		if($_SERVER['PHP_SELF']==_page."brand_manage.php"){ 
	            	?>
	                <li>
	                    <a class="active" href="brand_manage.php"><i class="fa fa-users fa-fw"></i>品牌管理</a>
	                </li>
	              <?php }
	              			else{ ?>
	              	<li>
	                    <a href="brand_manage.php"><i class="fa fa-users fa-fw"></i>品牌管理</a>
	                </li>
	               <?php } ?>
	            </ul>
            </li>
          
          
          <?php if($_SERVER['PHP_SELF']==_page."store_apply.php" ||$_SERVER['PHP_SELF']==_page."attest_manage.php" ||$_SERVER['PHP_SELF']==_page."change_pwd.php"){ ?>
            <li class="active">
          <?php }else{ ?>
          	<li>
          <?php } ?>
	            <a href="#"><i class="fa fa-search fa-fw"></i> 会员管理<span class="fa arrow"></span></a>
	            <ul class="nav nav-second-level">
	            	<?php 
	            		if($_SERVER['PHP_SELF']==_page."attest_manage.php"){ 
	            	?>
	                <li>
	                    <a class="active" href="attest_manage.php"><i class="fa fa-users fa-fw"></i>会员验证管理</a>
	                </li>
	              <?php }
	              			else{ ?>
	              	<li>
	                    <a href="attest_manage.php"><i class="fa fa-users fa-fw"></i>会员验证管理</a>
	                </li>
	               <?php } ?>
	            	
	            	<?php 
	            		if($_SERVER['PHP_SELF']==_page."store_apply.php"){ 
	            	?>
	                <li>
	                    <a class="active" href="store_apply.php"><i class="fa fa-users fa-fw"></i>店家资格申请</a>
	                </li>
	              <?php }
	              			else{ ?>
	              	<li>
	                    <a href="store_apply.php"><i class="fa fa-users fa-fw"></i>店家资格申请</a>
	                </li>
	               <?php } ?>
	               
	               <?php 
	            		if($_SERVER['PHP_SELF']==_page."change_pwd.php"){ 
	            	?>
	                <li>
	                    <a class="active" href="change_pwd.php"><i class="fa fa-users fa-fw"></i>会员密码变更</a>
	                </li>
	              <?php }
	              			else{ ?>
	              	<li>
	                    <a href="change_pwd.php"><i class="fa fa-users fa-fw"></i>会员密码变更</a>
	                </li>
	               <?php } ?>
	            </ul>
	          </li>
	          
	          <li>
							<?php if($_SERVER['PHP_SELF']==_page."item_manage.php"){ ?>
								<a class="active" href="item_manage.php"><i class="fa fa-dashboard fa-fw"></i> 商品管理</a>
							<?php }
							else{ ?>
								<a href="item_manage.php"><i class="fa fa-home fa-fw"></i> 商品管理</a>
							<?php } ?>
	          </li>
        </ul>
      </div>
    </div>
</nav>