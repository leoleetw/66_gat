<?
	include_once("include/dbinclude.php");
	include_once("temp/my_header.php");
?>
<div>
	<table><tr><th>商品</th><th>价格</th><th>商店</th><th>操作</th></tr>
	<?
		$sql = "select a.* , b.* , c.store_name from collect a 
		left join item b on a.item_id = b.item_id 
		left join store c on a.store_id = c.store_id 
		where a.user_id = '".$_SESSION["user_id"]."'";
		$result = mysqli_query($sqli,$sql);
		while($row = mysqli_fetch_array($result)){
			$item_img = explode("|",$row["item_photo"]);
	?>
		<tr id='collect<? echo $row["item_id"]; ?>'><td><img src="update/item_s/<? echo $item_img[0]; ?>"><? echo $row["item_name"]; ?></td><td><? echo $row["item_price"]; ?></td><td><? echo $row["store_name"]; ?></td><td><a href="#" onclick="remove_collect(<? echo $row["item_id"];?>);" >删除</a></td></tr>
	<?	}	?>
	</table>
</div>
<script>
	function remove_collect(item_id){
		$.ajax({
      url: 'ajax/item.php',
      data: 'action=remove_collect&item_id='+item_id,
      type:"POST",
      dataType:'text',

      success: function(mytext){
      	var arr = new Array();
      	arr = mytext.split("|");
      	if(arr[0]=='0'){
					$('#collect'+arr[1]).remove();
      	}
      	else if(arr[0]=='1'){
      		alert('error');
      	}
      	else{
      		alert(mytext);
      	}
      },

       error:function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
       }
  	});
	}
</script>