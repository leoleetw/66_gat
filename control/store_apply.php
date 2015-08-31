<?
	include_once("../include/dbinclude.php");
	include_once("ajax/config.php");
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
		<link href="../include/css/bootstrap-switch.min.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="../include/font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
		<script src="../include/js/jquery-1.11.0.js"></script>
		<script src="../include/js/plugins/metisMenu/metisMenu.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../include/js/bootstrap.min.js"></script>
    <script src="../include/js/bootstrap-switch.min.js"></script>
		<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <!-- Custom Theme JavaScript -->
    <script src="../include/js/admin.js"></script>
    <script src="../include/js/ajax.js"></script>
</head>

<body>
	<div id="wrapper">
		<?php include_once('temp/nav.php');?>
		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<!--h1 class="page-header">首頁</h1-->
					<p> </p>
					<?  include_once('temp/store_apply.php');?>
				</div>
			</div>
		</div>
	</div>
	<?php include_once('temp/footer.php');?>
</body>

</html>

