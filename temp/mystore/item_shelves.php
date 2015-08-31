<?
	include_once("include/dbinclude.php");
?>

<div id="shelves_item_div" class='col-lg-10'>
	<?
		if($_GET["new_page"]=="")
			$this_page = 1;
		else
			$this_page = intval($_GET["new_page"]);
		$sql = "select a.* from item a 
			inner join store b on a.store_id = b.store_id 
		 where b.user_id=".$_SESSION["user_id"]." and a.item_state = 1";
		$rs_count = mysqli_num_rows(mysqli_query($sqli,$sql));
		$total_page = ceil($rs_count/12);
		$result = mysqli_query($sqli,$sql." limit ".(($this_page-1)*12).",12");
	?>
		<table class="table">
			<tr><th>商品编号</th><th>商品名称</th><th>价格</th><th>数量</th><th>图片</th><th>修改</th></tr>
	<?
		while($row = mysqli_fetch_array($result)){
			$photo_img = explode("|",$row["item_photo"]);
	?>
			<tr id="item_tr<? echo $row["item_id"]; ?>">
				<td><? echo $row["item_id"]; ?></td>
				<td><? echo $row["item_name"]; ?></td>
				<td><? echo $row["item_price"]; ?></td>
				<td><? echo $row["item_stock"]; ?></td>
				<td><img src="update/item_s/<? echo $photo_img[0]."?".date("His"); ?>" style="max-width:100px;max-height:100px;"></td>
				<td>
					<button type="button" class="btn btn-primary" onclick="location.href='mystore_item?action=edit&item_id=<? echo $row["item_id"]; ?>'" >编辑详情</button>
					<button type="button" class="btn btn-primary" onclick="out_shelves(<? echo $row["item_id"]; ?>);" >下架</button>
					<button type="button" class="btn btn-primary" onclick="" >删除</button>
				</td>
			</tr>
	<? 
		} 
	?>
		</table>
</div>

<script>
	function out_shelves(item_id){
		$.ajax({
      url: 'ajax/item.php',
      data: 'action=out_shelves&item_id='+item_id,//$('#sentToBack').serialize()
      type:"POST",
      dataType:'text',

      success: function(mytext){
      	var temp = mytext.split("|");
      	if(temp[0]=="0"){
      		$('#item_tr'+temp[1]).remove();
      	}
      	else{
      		alert("发生未知错误");
      		history.go(0);
      	}
      },

       error:function(xhr, ajaxOptions, thrownError){ 
          alert(xhr.status); 
          alert(thrownError); 
       }
  	});
	}
</script>