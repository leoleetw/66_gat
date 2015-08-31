<? include_once('include/dbinclude.php');?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>宝玉石</title>
<link href="include/css/bootstrap.min.css" rel="stylesheet">

<!-- jQuery Version 2.1.4 -->
<script src="include/js/jquery-2.1.4.min.js"></script>
<script src="include/js/plugins/cookie/jquery.cookie.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="include/js/bootstrap.min.js"></script>
<script type="text/javascript" src="include/js/ajax.js"></script>
<script src="http://www.google.com/jsapi"></script>
<!-- jQuery Image Scale Carousel CSS & JS -->
<link href="include/css/style.css" rel="stylesheet">
</head>
<body>
<header>
	<section>
  		<? include_once("temp/header.php"); ?>
  	</section>
</header>
<div id="main">
	<section>
		<? include_once("temp/brand_list.php"); ?>
	</section>
</div>
<footer>
  	<? include_once("temp/footer.php"); ?>
</footer>
<? Message(); ?>
<script>
</script>
</body>
