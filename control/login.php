<?
	include_once("../include/dbinclude.php");
?>
<!DOCTYPE html>
<html lang="tw">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>宝玉石後台管理系統</title>

    <!-- Bootstrap Core CSS -->
    <link href="../include/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../include/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../include/css/admin_style.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../include/font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
		<script src="../include/js/jquery-1.11.0.js"></script>
		<script src="../include/js/plugins/metisMenu/metisMenu.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../include/js/bootstrap.min.js"></script>
		<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <!-- Custom Theme JavaScript -->
    <script src="../include/js/admin.js"></script>
    <script src="../include/js/ajax.js"></script>
</head>

<body>
	<div id="wrapper">
		<div><!-- id="page-wrapper"-->
			<div class="row">
				<div class="col-lg-6 col-lg-offset-3">
					<h1 class="page-header" align='center'>後台管理系统</h1>
					<p> </p>
					<form id='login_form' action='ajax/login.php' method="POST">
						<table width=100% class='table'>
							<tr>
								<td><label for='acc'>帐号︰</label></td>
								<td><input type='text' id='acc' name='acc' value='' class='form-control'></td>
							</tr>
							<tr>
								<td><label for='pwd'>密码︰</label></td>
								<td><input type='password' id='pwd' name='pwd' value='' class='form-control'></td>
							</tr>
							<tr>
								<td><label for='captcha'>验证码︰</label></td>
								<td><input type='text' id='captcha' name='captcha' value='' class='form-control'></td>
							</tr>
							<tr>
								<td colspan='2' align='center'>
									<input type="hidden" id="action" name="action" value="login" >
									<input type='button' id='login_btn' name='login_btn' value='登入' class='btn btn-primary'>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script>
		$('#login_btn').click(function(e){
			if(Dd('acc').value==''||Dd('pwd').value=='')
				return false;
			else
				Dd('login_form').submit();
		})
	</script>
</body>

</html>

