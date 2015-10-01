<?
	include_once("include/dbinclude.php");
	include_once("temp/my_header.php");
?>
<div class="col-lg-12">
		<div class="row">
		<?
			$sql = "select a.* , b.* , c.store_name from collect a
			left join item b on a.item_id = b.item_id
			left join store c on a.store_id = c.store_id
			where a.user_id = '".$_SESSION["user_id"]."'";
			$result = mysqli_query($sqli,$sql);
			$rs_cn = mysqli_num_rows($result);
			$i = 1;
			while($row = mysqli_fetch_array($result)){
				$item_img = explode("|",$row["item_photo"]);
				if(($i%4) == 1 && $i != 1)
					echo "<div class='row'>";
		?>
				<div id='collect<? echo $row["item_id"]; ?>' class="col-lg-3">
					<div id='collect<? echo $row["item_id"]; ?>'>
					 	<div class="collect_wrapper">
						    <a href="item_info.php?item_id=<? echo $row["item_id"]; ?>" class="thumbnail">
						      <div class="imgOverflow collect_split"><img src="update/item_s/<? echo $item_img[0];?>"></div>
						    </a>
						    <div class="caption">
							  	<p><h4><? echo $row["item_name"]; ?></h4></p>
								<p><font class="collect_storeName"><? echo $row["store_name"]; ?></font></p>
								<img src="include/images/price.png"><h4><font class="item_price"><? echo $row["item_price"]; ?></font></h4>
					      	</div>
						</div>
					</div>
						<?
							$cart = explode("|",$_COOKIE["cart"]);
							if(in_array($row["item_id"], $cart)){
						?>
								<button type="button" onclick="addtocart(<? echo $row["item_id"].",".$row["store_id"]; ?>);" class="btn btn-primary" disabled >存在於购物车</button>
						<?
							}else{
						?>
						<div class="btnHover">
								<a onclick="addtocart(<? echo $row["item_id"].",".$row["store_id"]; ?>);" class="shopBtn" ></a>
						<? } ?>
								<a onclick="remove_collect(<? echo $row["item_id"];?>);" class="deleteBtn_blue" ></a>
						</div>
				</div>
		<?
				if(($i%4) == 0 || $i == $rs_cn)
					echo "</div>";
				$i++;
			}
		?>
			<button type="button" onclick="remove_collect_all();" class="btn btn-danger" >删除全部</button>
		</div>
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
	function remove_collect_all(){
		$.ajax({
      url: 'ajax/item.php',
      data: 'action=remove_collect_all',
      type:"POST",
      dataType:'text',

      success: function(mytext){
      	var arr = new Array();
      	arr = mytext.split("|");
      	if(arr[0]=='0'){
					history.go(0);
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