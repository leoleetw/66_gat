<?
	include_once("include/dbinclude.php");
?>

<div id="score_div" class='col-lg-12'>
	<div class='row'>
		<div id="score_div" class='col-lg-5 col-lg-offset-1'>
			买入评价
			<img src="XXX.jpg"> 0
		</div>
		<div id="score_div" class='col-lg-5'>
			卖出评价
			<img src="XXX.jpg"> 0
		</div>
	</div>
	<ul class="nav nav-tabs" role="tablist">
	  <li role="presentation" class="active"><a href="#buy_score" aria-controls="buy_score" role="tab" data-toggle="tab"></a></li>
    <li role="presentation"><a href="#sell_score" aria-controls="sell_score" role="tab" data-toggle="tab"></a></li>
	</ul>
	<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="buy_score">
    	<div class='row'>
    		<div class='col-lg-1'>
    			<a id='buy_score_btn'>已评价</a>
    			<a id='buy_score_yet_btn'>未评价</a>

    		</div>
    		<div id='buy_score_div' class='col-lg-11'>
    			查询时间区间
    			<select id='buy_date_range'>
    				<option value='month'>一个月内</option>
    				<option value='year'>一个年内</option>
    				<option value='all'>全部</option>
    			</select>
    			<input type="hidden" id="buy_search" value="buy_score">
    			<table id='buy_score_table' class='table'>
    				<tr><th>评价</th><th>订单编号</th><th>开始/结束时间</th><th>卖家</th><th>评价意见</th><th>动作</th></tr>
		    	<?
		    		$last_month = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) );
		    		$sql = "select a.*,c.store_name , c.store_id from score_recode a
		    		inner join `order` b on a.order_id = b.order_id
		    		inner join store c on a.sell_user_id = c.user_id
		    		where b.pay_state > 0 AND b.item_state > 3 AND b.order_user_id = '".$_SESSION["user_id"]."' AND (a.for_buy_score is not NULL) AND (a.for_buy_date between '".date("Y-m-d")."' and '".$last_month."') order by a.limit_date DESC";
		    		$result = mysqli_query($sqli,$sql);
		    		while($row = mysqli_fetch_array($result)){
		    			if($row["for_buy_score"]=='0')
		    				echo "<tr><td><img src='xxx.jpg'></td>";
		    			else if($row["for_buy_score"]=='1')
		    				echo "<tr><td><img src='xxx.jpg'></td>";
		    			else if($row["for_buy_score"]=='2')
		    				echo "<tr><td><img src='xxx.jpg'></td>";
		    			echo "<td>".$row["order_id"]."</td><td>".$row["start_date"]."<br>".$row["end_date"]."</td><td>".$row["store_name"]."</td><td>".$row["for_buy_comment"]."</td><td>123</td></tr>";
		    		}
		    	?>
	    		</table>
	    	</div>
	    	<div id='for_sell_score_div' class='col-lg-11' style='display:none;'>
	    		<table id='for_sell_score_table' class='table'>
	    			<tr><th>订单编号</th><th>开始/结束时间</th><th>卖家</th><th>订单金额</th><th>评价限制时间</th></tr>
	    			<tr><td id='for_sell_score_order_id'></td><td id='for_sell_score_order_date'>开始/结束时间</td><td id='for_sell_score_store'>卖家</td><td id='for_sell_score_total_price'>订单金额</td><td id='for_sell_score_limit_date'>评价限制时间</td></tr>
	    		</table>
	    		<div class='row'>
	    			<div class='col-lg-2'>
	    				<input type='radio' id='for_sell_score0' name='for_sell_score' value='0'>
	    				<img src='XXX.jpg'>
	    			</div>
	    			<div class='col-lg-2'><input type='radio' id='for_sell_score1' name='for_sell_score' value='1' checked></div>
	    			<div class='col-lg-2'><input type='radio' id='for_sell_score2' name='for_sell_score' value='2'></div>
	    			<div class='col-lg-6'><textarea id='for_sell_comment' name='for_sell_comment' class='form-control'></textarea></div>
	    		</div>
	    		<button type='button' class='btn btn-primary' id='for_sell_score_btn' >储存</button>
	    	</div>
    	</div>
  	</div>
  	<div role="tabpanel" class="tab-pane" id="sell_score">
  	</div>
  </div>
</div>
<script>
	function show_for_sell_scroe(order_id){
		$('#for_sell_score_order_id').html(order_id);
		$('#for_sell_score_order_date').html($('#order_date'+order_id).html());
		$('#for_sell_score_store').html($('#store'+order_id).html());
		$('#for_sell_score_total_price').html($('#total_price'+order_id).html());
		$('#for_sell_score_limit_date').html($('#limit_date'+order_id).html());
		block('for_sell_score_div');
		none('buy_score_div');
	}
	$('#for_sell_score_btn').click(function(e){
		var for_sell_score = 1;
		for(var i = 0 ; i <=2 ; ++i)
			if(Dd('for_sell_score'+i).checked==true)
				for_sell_score = i;

		$.ajax({
      url: 'ajax/score.php',
      data: 'action=for_sell_score&order_id='+$('#for_sell_score_order_id').html()+'&for_sell_score='+for_sell_score+'&for_sell_comment='+$('#for_sell_comment').val(),
      type:"POST",
      dataType:'text',

      success: function(mytext){
      	var arr = new Array();
      	arr = mytext.split("|");
      	if(arr[0]=='0')
      		history.go(0);
      },

       error:function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
       }
  	});

	});
	$('#buy_score_btn').click(function(e){
		block('buy_score_div');
		none('for_sell_score_div');
		$('#buy_search').val('buy_score');
		$.ajax({
      url: 'ajax/score.php',
      data: 'action=buy_get_score&buy_search='+$('#buy_search').val()+'&buy_date_range=month',
      type:"POST",
      dataType:'JSON',

      success: function(myjson){
      	var str = "";
      	if(myjson.length == 0){
      		str = "<tr><th>评价</th><th>订单编号</th><th>开始/结束时间</th><th>卖家</th><th>评价意见</th><th>动作</th></tr>";
      		alert("查无资料");

      	}
      	else{

      		str = "<tr><th>评价</th><th>订单编号</th><th>开始/结束时间</th><th>卖家</th><th>评价意见</th><th>动作</th></tr>";
      		for(var i = 0 ; i < myjson.length ; ++i){
      			if(myjson[i].for_buy_score=='0')
	    				str += "<tr><td><img src='xxx.jpg'></td>";
	    			else if(myjson[i].for_buy_score=='1')
	    				str += "<tr><td><img src='xxx.jpg'></td>";
	    			else if(myjson[i].for_buy_score=='2')
	    				str += "<tr><td><img src='xxx.jpg'></td>";
	    			str += "<td>"+myjson[i].order_id+"</td><td>"+myjson[i].creat_date+"<br>"+myjson[i].end_date+"</td><td>"+myjson[i].store_name+"</td><td>"+myjson[i].for_buy_comment+"</td><td>123</td></tr>";
      		}

      	}
      	$('#buy_score_table').html(str);
      },

       error:function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
       }
  	});
	});
	$('#buy_date_range').change(function(e){
		block('buy_score_div');
		none('for_sell_score_div');
		$.ajax({
      url: 'ajax/score.php',
      data: 'action=buy_get_score&buy_search='+$('#buy_search').val()+'&buy_date_range='+$('#buy_date_range').val(),
      type:"POST",
      dataType:'JSON',

      success: function(myjson){
      	var str = "";
      	if($('#buy_search').val()=='buy_score_yet'){
      		if(myjson.length == 0){
	      		alert("查无资料");
	      		str = "<tr><th>订单编号</th><th>开始/结束时间</th><th>卖家</th><th>订单金额</th><th>评价限制时间</th></tr>";
	      	}
	      	else{
	      		var str = "";
	      		str = "<tr><th>订单编号</th><th>开始/结束时间</th><th>卖家</th><th>订单金额</th><th>评价限制时间</th></tr>";
	      		for(var i = 0 ; i < myjson.length ; ++i){
		    			var from = new Date(myjson[i].limit_date);
							var to = new Date();
							to.setDate(from.getDate() + 3);
							var limit_date = to.getFullYear() + '-' +(to.getMonth() + 1) + '-' + to.getDate();
		    			str += "<tr><td>"+myjson[i].order_id+"</td><td>"+myjson[i].creat_date+"<br>"+myjson[i].end_date+"</td><td>"+myjson[i].store_name+"</td><td>"+myjson[i].total_price+"</td><td>"+limit_date+"</td></tr>";
	      		}
	      	}
      	}
      	else if($('#buy_search').val()=='buy_score'){
	      	if(myjson.length == 0){
	      		str = "<tr><th>评价</th><th>订单编号</th><th>开始/结束时间</th><th>卖家</th><th>评价意见</th><th>动作</th></tr>";
	      		alert("查无资料");
	      	}
	      	else{
	      		str = "<tr><th>评价</th><th>订单编号</th><th>开始/结束时间</th><th>卖家</th><th>评价意见</th><th>动作</th></tr>";
	      		for(var i = 0 ; i < myjson.length ; ++i){
	      			if(myjson[i].for_buy_score=='0')
		    				str += "<tr><td><img src='xxx.jpg'></td>";
		    			else if(myjson[i].for_buy_score=='1')
		    				str += "<tr><td><img src='xxx.jpg'></td>";
		    			else if(myjson[i].for_buy_score=='2')
		    				str += "<tr><td><img src='xxx.jpg'></td>";
		    			str += "<td>"+myjson[i].order_id+"</td><td>"+myjson[i].creat_date+"<br>"+myjson[i].end_date+"</td><td>"+myjson[i].store_name+"</td><td>"+myjson[i].for_buy_comment+"</td><td>123</td></tr>";
	      		}
	      	}
	      }
      	$('#buy_score_table').html(str);
      },

       error:function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
       }
  	});
	});
	$('#buy_score_yet_btn').click(function(e){
		block('buy_score_div');
		none('for_sell_score_div');
		$('#buy_search').val('buy_score_yet');
		$('#buy_date_range').val('month');
		$.ajax({
      url: 'ajax/score.php',
      data: 'action=buy_get_score&buy_search='+$('#buy_search').val()+'&buy_date_range=month',
      type:"POST",
      dataType:'JSON',

      success: function(myjson){
      	var str = "";
      	var error = false;
      	if(myjson.length == 0){
      		alert("查无资料");
      		str = "<tr><th>订单编号</th><th>开始/结束时间</th><th>卖家</th><th>订单金额</th><th>评价限制时间</th></tr>";
      	}
      	else{
      		var str = "";
      		str = "<tr><th>订单编号</th><th>开始/结束时间</th><th>卖家</th><th>订单金额</th><th>评价限制时间</th></tr>";
      		for(var i = 0 ; i < myjson.length ; ++i){
      			var limit_date0 = new Date(myjson[i].limit_date);
						var today = new Date();
						limit_date0.setDate(limit_date0.getDate() + 3);
						if(today > limit_date0)
							error = true;
						var limit_date1 = limit_date0.getFullYear() + '-' +(limit_date0.getMonth() + 1) + '-' + limit_date0.getDate();

	    			if(error){
	    				str += "<tr><td>"+myjson[i].order_id+"</td><td>"+myjson[i].creat_date+"<br>"+myjson[i].end_date+"</td><td>"+myjson[i].store_name+"</td><td>"+myjson[i].total_price+"</td><td><font style='color:red;'>"+limit_date1+"</font></td></tr>";
	    			}
	    			else{
	    				str += "<tr><td><a onclick=show_for_sell_scroe('"+myjson[i].order_id+"');>"+myjson[i].order_id+"</a></td><td><font id='order_date"+myjson[i].order_id+"'>"+myjson[i].creat_date+"<br>"+myjson[i].end_date+"</font></td><td><font id='store"+myjson[i].order_id+"'>"+myjson[i].store_name+"</font></td><td><font id='total_price"+myjson[i].order_id+"'>"+myjson[i].total_price+"</font></td>";
	    				str += "<td><font id='limit_date"+myjson[i].order_id+"' style='color:blue;'>"+limit_date1+"</font></td></tr>";
	    			}
      		}
      	}
      	$('#buy_score_table').html(str);
      },

       error:function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
       }
  	});
	});
</script>