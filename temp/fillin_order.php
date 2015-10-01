<?
	if($_SESSION["user_id"]==""){
		$_SESSION["errnumber"]=1;
		$_SESSION["msg"]="请先登入帐号，在进行购买动作！！";
		header("Location: login.php");
	}
?>
<div class="">
	<h3>购物车</h3>
</div>
<form id='order_form' action='ajax/order.php' method="POST">
	<div class="">
		<h4>确认商品</h4>
		<table id="cart_table" class='table'>
			<tr><th>商品</th><th>单价</th><th>数量(商品库存)</th><th>金额</th></tr>
		<?
				$stock_error = false;
				$state_error = false;
				$cart_indexof = -1;
				$cart = json_decode( $_COOKIE["cart"] );
				for($i = 0 ; $i < count($cart) ; ++$i){
					if($cart[$i]->store_id == $_POST['store_id'])
						$cart_indexof = $i;
				}
				
				$total_price = 0;
				for($cart_count = 0 ; $cart_count < count($cart[$cart_indexof]->item) ; ++$cart_count){
					$sql_cart = "select item_id , item_price , item_stock ,item_photo,item_name , item_state from item where item_id=".$cart[$cart_indexof]->item[$cart_count];
					$result_cart = mysqli_query($sqli,$sql_cart);
					$row_cart = mysqli_fetch_array($result_cart);
					if($row_cart["item_state"] != '1'){
						$state_error = true;
						if(count($cart[$cart_indexof]->item)==1)
							unset($cart[$cart_indexof]);
						else
							unset($cart[$cart_indexof]->item[$cart_count]);
						continue;
						/* cookie 删除商品动作
						
						*/
					}
					$photo_img = explode("|",$row_cart["item_photo"]);
		?>
					<tr id="cart_tr<? echo $row_cart["item_id"]; ?>">
						<td><img src="update/item_s/<? echo $photo_img[0]; ?>" style="width:50px;"><? echo $row_cart["item_name"];?></td>
						<td id="item_price<? echo $row_cart["item_id"]; ?>"><? echo $row_cart["item_price"]; ?></td>
						<td>
							<input type="hidden" id="cart_item_count<? echo $row_cart["item_id"]; ?>" name="cart_item_count<? echo $row_cart["item_id"]; ?>" value="<? echo $_POST["cart_item_count".$row_cart["item_id"]]; ?>">
							<?
								if(intval($row_cart["item_stock"]) < intval($_POST["cart_item_count".$row_cart["item_id"]])){
									$stock_error = true;
							?>
								<div><? echo $_POST["cart_item_count".$row_cart["item_id"]]; ?>（<font style="color:red;"><? echo $row_cart["item_stock"]; ?></font>）</div>
							<?
								}else{
							?>
								<div><? echo $_POST["cart_item_count".$row_cart["item_id"]]; ?>（<? echo $row_cart["item_stock"]; ?>）</div>
							<?
								}
							?>
						</td>
						<td id="item_total_price<? echo $row_cart["item_id"]; ?>"><? echo ($row_cart["item_price"]*intval($_POST["cart_item_count".$row_cart["item_id"]])); ?></td>
					</tr>
		<?		
					$total_price += $row_cart["item_price"]*intval($_POST["cart_item_count".$row_cart["item_id"]]);
				}
		?>
				<tr>
					<input type="hidden" id="store_id" name="store_id" value="<? echo $_POST['store_id']; ?>">
					<td colspan='4' style="text-align:right">合计︰<font id="total_price"><? echo $total_price; ?></font><input type="hidden" id="total_price" name="total_price" value="<? echo $total_price; ?>"></td>
					</tr>
		</table>
		
	</div>
	<div>
		<?
			$sql = "select city_code ,user_name , user_addr ,mobile from user where user_id =".$_SESSION["user_id"];
			$result = mysqli_query($sqli,$sql);
			$row = mysqli_fetch_array($result);
		?>
		<h4>送货资讯</h4>
		<table width="100%">
			<tr>
				<td>姓名</td>
				<td><input type="text" id="rec_name" name="rec_name" value="<? echo $row["user_name"];?>" class="form-control"></td>
			</tr>
			<tr>
				<td>手机</td>
				<td><input type="text" id="rec_mobile" name="rec_mobile" value="<? echo $row["mobile"];?>" class="form-control"></td>
			</tr>
			<tr>
				<td>地址</td>
				<td>
					<select id='rec_city_area' name='rec_city_area' class='form-control' style='width:20%;float:left;'>
						<option value=''>请选择</option>
						<?
							$sql_city = "select * from city where city_rank = 1 order by city_id";
							$result_city = mysqli_query($sqli,$sql_city);
							while($row_city = mysqli_fetch_array($result_city)){
								echo "<option value='".$row_city["city_id"]."' ";
								if($row["city_code"]!='0'){
									$city_area = substr($row["city_code"] , 0 ,3).'000';
									if(intval($city_area) == intval($row_city["city_id"]))
										echo "selected";
								}
								echo ">".$row_city["city_name"]."</option>";
							}
						?>
					</select>
					<select id='rec_city_code' name='rec_city_code' class='form-control' style='width:20%;float:left;'>
						<?	if($row["city_code"]=='0'){	?>
						<option value=''>请选择</option>
						<? }else{ 
								$search_city = substr($row["city_code"] , 0 ,3);
								$sql_city = "select * from city where city_rank = 2 and city_id like '".$search_city."%' order by city_id";
								$result_city = mysqli_query($sqli,$sql_city);
								while($row_city = mysqli_fetch_array($result_city)){
									echo "<option value='".$row_city["city_id"]."' ";
									if($row["city_code"] == $row_city["city_id"])
										echo "selected";
									echo ">".$row_city["city_name"]."</option>";
								}
							}
						?>
					</select>
					<input type="text" class="form-control" id="rec_addr" name="rec_addr" value='<? echo $row['user_addr'];?>' style='width:60%;'>
				</td>
			</tr>
			<tr>
				<td>备注</td>
				<td><textarea id="rec_note" name="rec_note" value="" class="form-control"></textarea></td>
			</tr>
			<tr>
				<td colspan='2'>
					<input type="hidden" id="action" name="action" value="creat_order">
					<button type="button" class='btn btn-primary' onclick='history.go(-1)'>回购物车</button>
					<button type="button" class='btn btn-primary' id='rec_btn'>下一步</button>
				</td>
			</tr>
		</table>
	</div>
	<?
		$_COOKIE["cart"] = json_encode($cart);
	?>
</form>
<script>
	$('#rec_city_area').change(function(e){ //变更城市
		if($('#city_area').val()!=""){
			$.ajax({
		      url: 'ajax/city.php',
		      data: "action=get_city_code&city_area="+$('#rec_city_area').val(),//$('#sentToBack').serialize()
		      type:"POST",
		      dataType:'JSON',

		      success: function(myjson){
		      	var str = "";
		      	for(var i = 0 ; i < myjson.length ; ++i){
		      		str += "<option value='"+myjson[i].city_id+"'>"+myjson[i].city_name+"</option>";
		      	}
		      	$('#rec_city_code').html(str);
		      },

		      error:function(xhr, ajaxOptions, thrownError){
					alert(xhr.status);
					alert(thrownError);
				}
			});
		}
		
	})
	$('#rec_btn').click(function(e){
		if($('#rec_name').val().trim()==''){
			$('#rec_name').focus();
			alert('送货姓名请填写');
		}
		else if($('#rec_mobile').val().trim()==''){
			$('#rec_mobile').focus();
			alert('送货电话请填写');
		}
		else if($('#rec_addr').val().trim()==''){
			$('#rec_addr').focus();
			alert('送货地址请填写');
		}
		else{
			$('#order_form').submit();
		}
	});
	$( document ).ready(function() {
		<? 
			if($stock_error == true){
				echo "alert('亲，你有商品已被人标走了，将跳转你的页面回购物车');";
				echo "location.href='cart.php';";
			}
			else if($state_error == true){
				echo "alert('亲，你有商品已被卖家下架了，将跳转你的页面回购物车');";
				echo "location.href='cart.php';";
			}
		?>
	});
</script>