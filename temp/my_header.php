<?
	include_once("include/dbinclude.php");
?>
<div>
	<?
		$sql = "select a.* , b.store_id as store , c.sa_id as store_apply , c.sa_state from user a 
		left join store b on b.user_id = a.user_id 
		left join store_apply c on c.user_id = a.user_id 
		where a.user_id = ".$_SESSION["user_id"];
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
	?>
	<!--a href="attest.php">资料认证申请</a-->
	<a href='#'>订单查询</a>
	<a href="my_collect.php">我的收藏</a>
	<a href='#'>帐户纪录</a>
	<a href='my_setting.php'>帐户设定</a>
	<?	if($row["store"]==null&&$row["user_attest"]!=7){ ?>
		<button type="button" class="btn btn-default" disabled="disabled" >店家资格申请(需完成全部认证)</button>
	<? }else if($row["store"]==null&&$row["user_attest"]==7&&$row["store_apply"]==null){ ?>
		<input type="button" data-toggle="modal" data-target="#apply_store_Modal"  data-backdrop="static" data-keyboard=false class="btn btn-default" value="店家资格申请">
	<? }else if($row["store"]==null&&$row["user_attest"]==7&&$row["store_apply"]!=null&&$row["sa_state"]==0){ ?>
		<button type="button" class="btn btn-default" disabled="disabled">店家资格审核中</button>
	<? }else if($row["store"]==null&&$row["user_attest"]==7&&$row["store_apply"]!=null&&$row["sa_state"]==2){ ?>
		<input type="button" data-toggle="modal" data-target="#apply_store_Modal"  data-backdrop="static" data-keyboard=false class="btn btn-default" value="店家资格申请(上次申请被拒)">
	<? }else{ ?>
		<a href='mystore.php'>我的店家</a>
	<? } ?>
</div>
<form id='apply_store_form' action='ajax/mystore.php' method="post" enctype="multipart/form-data">
	<div class="modal fade" id="apply_store_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<h1 align='center'>店家申请</h1>
	      </div>
	      <div class="modal-body">
	      	<font style="color:red">若有实体店面证明或代理商证明请上传，或待之後上传</font>
	      	<input type="hidden" id="apply_store_count" name="apply_store_count" value="1">
	      	<div id="apply_store_img_div">
	      		<input type="file" id="apply_store_file1" name="apply_store_file[]" accept="image/*">
	      	</div>
	      	<img src="include/images/add.jpg" onclick="add_apply_store_img();">
	      </div>
	      <div class="modal-footer">
	      	<input type="hidden" id="action" name="action" value="apply_store">
	        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	        <button type="submit" class="btn btn-primary" id='add_brand_btn'>确定</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>
<script>
	function add_apply_store_img(){
		var new_name = (parseInt(Dd('apply_store_count').value)+1);
		var input  = document.createElement("input");
  	input.setAttribute("type", "file");
  	input.setAttribute("id", "apply_store_file"+new_name);
  	input.setAttribute("name", "apply_store_file[]");
  	input.setAttribute("accept", "image/*");
  	$( "#apply_store_img_div" ).append( input );
  	Dd('apply_store_count').value = new_name;
	}
</script>