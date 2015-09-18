<?
	include_once("include/dbinclude.php");
	$sql = "select * from score where user_id = ".$_SESSION["user_id"];
	$result1 = mysqli_query($sqli,$sql);
	$total_count = mysqli_num_rows($result1);
	if($total_count == 0){
		$row["buy_good_count"] = 0;
		$row["buy_bad_count"] = 0;
		$row["sell_good_count"] = 0;
		$row["sell_bad_count"] = 0;

	}
	else{
		$result = mysqli_query($sqli,$sql);
		$row = mysqli_fetch_array($result);
	}
?>

<div id="score_div" class='col-lg-11 col-lg-offset-1 recodeWrapper'>
	<!--div class='row'>
		<div id="score_div" class='col-lg-5 col-lg-offset-1'>
			买评价	<img src="XXX.jpg"> <? echo $row["buy_good_count"]; ?> <img src="XXX.jpg"> <? echo $row["buy_bad_count"]; ?>
		</div>
		<div id="score_div" class='col-lg-5'>
			卖出评价	<img src="XXX.jpg"> <? echo $row["sell_good_count"]; ?> <img src="XXX.jpg"> <? echo $row["sell_bad_count"]; ?>
		</div>
	</div-->
	<ul class="nav nav-tabs row" role="tablist">
	  <li role="presentation" class="active">
	  	<a href="#buy_score" aria-controls="buy_score" role="tab" data-toggle="tab">
	  		<p><h3 style="display:inline">购买</h3><h5 style="display:inline">评价</h5></p>
	  		<p>
	  			<span class="score-box"><img src="include/images/active_good.png"><? echo $row["buy_good_count"]; ?></span>
	  			<img src="include/images/active_bad.png"><? echo $row["buy_bad_count"]; ?>
	  		</p>
		</a>
		</li>
	    <li role="presentation">
	    	<a href="#sell_score" aria-controls="sell_score" role="tab" data-toggle="tab">
	    		<p><h3 style="display:inline">卖出</h3><h5 style="display:inline">评价</h5></p>
	    		<p>
	    			<span class="score-box"><img src="include/images/active_good.png"> <? echo $row["sell_good_count"]; ?></span>
	    			<img src="include/images/active_bad.png"> <? echo $row["sell_bad_count"]; ?>
	    		</p>
	    	</a>
	    </li>
	</ul>




	<div class="tab-content score_content">

		<!--买家评价-->
    <div role="tabpanel" class="tab-pane active" id="buy_score">
    	<div class='row'>
    		<div class="score_btn_area">
				<a id='buy_score_btn'>收到的评价</a>
				<a id='buy_score_yet_btn'>对卖家评价</a>
			</div>
    		<div id='buy_score_div'>
    			&nbsp;&nbsp;&nbsp;&nbsp;查询：
    			<select id='buy_date_range'>
    				<option value='month'>一个月内</option>
    				<option value='year'>一年内</option>
    				<option value='all'>全部</option>
    			</select>
    			<input type="hidden" id="buy_search" value="buy_score">
    			<table id='buy_score_table' class='table get_score'>
    				<tr><th>评价</th><th>订单编号</th><th>开始/结束时间</th><th>卖家</th><th>评价意见</th></tr>
		    	<?
		    		$last_month = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) );
		    		$sql = "select a.*,c.store_name , c.store_id , b.creat_date , b.end_date from score_recode a
		    		inner join `order` b on a.order_id = b.order_id
		    		inner join store c on a.sell_user_id = c.user_id
		    		where b.pay_state > 0 AND b.item_state > 3 AND a.buy_user_id = '".$_SESSION["user_id"]."'  AND (a.limit_date between '".$last_month."' and '".date("Y-m-d")."') order by a.limit_date DESC";
		    		$result = mysqli_query($sqli,$sql);
		    		while($row = mysqli_fetch_array($result)){
		    			if($row["for_buy_score"]==NULL)
		    				echo "<tr><td><font style='color:red'>待评价</font></td>";
		    			else{
			    			if($row["for_buy_score"]=='0')
			    				echo "<tr><td><img src='include/images/score01.png'></td>";
			    			else if($row["for_buy_score"]=='1')
			    				echo "<tr><td><img src='include/images/score0.png'></td>";
			    			else if($row["for_buy_score"]=='2')
			    				echo "<tr><td><img src='include/images/score-1.png'></td>";
		    			}
		    			echo "<td>".$row["order_id"]."</td><td>".$row["creat_date"]."<br>".$row["end_date"]."</td><td>".$row["store_name"]."</td><td>".$row["for_buy_comment"]."</td></tr>";
		    		}
		    	?>
	    		</table>
	    	</div>
	    	<div id='for_sell_score_div' style='display:none;'>
	    		<div class='row'>
	    			<input type='hidden' id="for_sell_score_order_id" name="for_sell_score_order_id" value="">
	    			<div class="give_score_box">
		    			<span>
		    				<input type='radio' id='for_sell_score0' name='for_sell_score' value='0' class="score_radio good_radio" checked>
		    				<label for="for_sell_score0">+1</label>
		    			</span>
		    			<span>
		    				<input type='radio' id='for_sell_score1' name='for_sell_score' value='1' class="score_radio general_radio">
		    				<label for="for_sell_score1">+0</label>
		    			</span>
		    			<span>
		    				<input type='radio' id='for_sell_score2' name='for_sell_score' value='2' class="score_radio bad_radio">
		    				<label for="for_sell_score2">-1</label>
		    			</span>
		    		</div>
	    			<textarea id='for_sell_comment' name='for_sell_comment' class='form-control score_remark' placeholder="留言："></textarea>
	    			<button type='button' class='btn btn-primary score_save' id='for_sell_score_btn' ></button>
	    		</div>
    		</div>
  		</div>
  	</div>
  	<!--卖家评价-->
  	<div role="tabpanel" class="tab-pane" id="sell_score">
  		<div class='row'>
    		<div class="score_btn_area">
    			<a id='sell_score_btn'>收到的评价</a>
    			<a id='sell_score_yet_btn'>对买家评价</a>
    		</div>
    		<div id='sell_score_div'>
    			&nbsp;&nbsp;&nbsp;&nbsp;查询：
    			<select id='sell_date_range'>
    				<option value='month'>一个月内</option>
    				<option value='year'>一年内</option>
    				<option value='all'>全部</option>
    			</select>
    			<input type="hidden" id="sell_search" value="sell_score">
    			<table id='sell_score_table' class='table get_score'>
    				<tr><th>评价</th><th>订单编号</th><th>开始/结束时间</th><th>买家</th><th>评价意见</th></tr>
		    	<?
		    		$last_month = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) );
		    		$sql = "select a.*,c.user_nick , b.creat_date , b.end_date from score_recode a
		    		inner join `order` b on a.order_id = b.order_id
		    		inner join user c on a.buy_user_id = c.user_id
		    		where b.pay_state > 0 AND b.item_state > 3 AND a.sell_user_id = '".$_SESSION["user_id"]."'  AND (a.limit_date between '".$last_month."' and '".date("Y-m-d")."') order by a.limit_date DESC";
		    		$result = mysqli_query($sqli,$sql);
		    		while($row = mysqli_fetch_array($result)){
		    			if($row["for_sell_score"]==NULL)
		    				echo "<tr><td><font style='color:red'>未评价</font></td>";
		    			else{
			    			if($row["for_sell_score"]=='0')
			    				echo "<tr><td><img src='include/images/score01.png'></td>";
			    			else if($row["for_sell_score"]=='1')
			    				echo "<tr><td><img src='include/images/score0.png'></td>";
			    			else if($row["for_sell_score"]=='2')
			    				echo "<tr><td><img src='include/images/score-1.png'></td>";
		    			}
		    			echo "<td>".$row["order_id"]."</td><td>".$row["creat_date"]."<br>".$row["end_date"]."</td><td>".$row["user_nick"]."</td><td>".$row["for_sell_comment"]."</td></tr>";
		    		}
		    	?>
	    		</table>
	    	</div>
	    	<div id='for_buy_score_div' style='display:none;'>
	    		<div class='row'>
	    			<input type='hidden' id="for_buy_score_order_id" name="for_buy_score_order_id" value="">
	    			<div class="give_score_box">
	    				<span>
	    					<input type='radio' id='for_buy_score0' name='for_buy_score' value='0' class="score_radio good_radio" checked>
	    					<label for="for_buy_score0">+1</label>
	    				</span>
	    				<span>
	    					<input type='radio' id='for_buy_score1' name='for_buy_score' value='1' class="score_radio general_radio">
	    					<label for="for_buy_score1">+0</label>
	    				</span>
	    				<span>
	    					<input type='radio' id='for_buy_score2' name='for_buy_score' value='2' class="score_radio bad_radio">
	    					<label for="for_buy_score2">-1</label>
	    				</span>
	    			</div>
		    		<textarea id='for_buy_comment' name='for_buy_comment' class='form-control score_remark' placeholder="留言："></textarea>
	    			<button type='button' class='btn btn-primary score_save' id='for_buy_score_btn' ></button>
	    		</div>
    		</div>
  		</div>
  	</div>
</div>
<script>
	//--buyer--//
	function show_for_sell_scroe(order_id){
		$('#for_sell_score_order_id').val(order_id);
		/*
		$('#for_sell_score_order_date').html($('#order_date'+order_id).html());
		$('#for_sell_score_store').html($('#store'+order_id).html());
		$('#for_sell_score_total_price').html($('#total_price'+order_id).html());
		$('#for_sell_score_limit_date').html($('#limit_date'+order_id).html());
		*/
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
      data: 'action=for_sell_score&order_id='+$('#for_sell_score_order_id').val()+'&for_sell_score='+for_sell_score+'&for_sell_comment='+$('#for_sell_comment').val(),
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
		$('#buy_date_range').val('month');
		$.ajax({
      url: 'ajax/score.php',
      data: 'action=buy_get_score&buy_search='+$('#buy_search').val()+'&buy_date_range=month',
      type:"POST",
      dataType:'JSON',

      success: function(myjson){
      	var str = "";
      	if(myjson.length == 0){
      		str = "<tr><th>评价</th><th>订单编号</th><th>开始/结束时间</th><th>卖家</th><th>评价意见</th></tr>";

      	}
      	else{

      		str = "<tr><th>评价</th><th>订单编号</th><th>开始/结束时间</th><th>卖家</th><th>评价意见</th></tr>";
      		for(var i = 0 ; i < myjson.length ; ++i){
      			if(myjson[i].for_buy_score==null)
      				str += "<tr><td><font style='color:red'>未评价</font></td>";
      			else{
	      			if(myjson[i].for_buy_score=='0')
		    				str += "<tr><td><img src='include/images/score01.png'></td>";
		    			else if(myjson[i].for_buy_score=='1')
		    				str += "<tr><td><img src='include/images/score0.png'></td>";
		    			else if(myjson[i].for_buy_score=='2')
		    				str += "<tr><td><img src='include/images/score-1.png'></td>";
	    			}
	    			str += "<td>"+myjson[i].order_id+"</td><td>"+myjson[i].creat_date+"<br>"+myjson[i].end_date+"</td><td>"+myjson[i].store_name+"</td><td>"+myjson[i].for_buy_comment+"</td></tr>";
      		}

      	}
      	$('#buy_score_table').html(str);
      	$('#buy_score_table').attr('class','table get_score');
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
	      		str = "<tr><th>订单编号</th><th>开始/结束时间</th><th>卖家</th><th>订单金额</th><th>评价限制时间</th><th>动作</th></tr>";
	      	}
	      	else{
	      		var str = "";
	      		str = "<tr><th>订单编号</th><th>开始/结束时间</th><th>卖家</th><th>订单金额</th><th>评价限制时间</th><th>动作</th></tr>";
	      		for(var i = 0 ; i < myjson.length ; ++i){
	      			var limit_date0 = new Date(myjson[i].limit_date);
							limit_date0.setDate(limit_date0.getDate() + 7);
							var limit_date1 = limit_date0.getFullYear() + '-' +(limit_date0.getMonth() + 1) + '-' + limit_date0.getDate();
	    				str += "<tr><td>"+myjson[i].order_id+"</td><td><font id='order_date"+myjson[i].order_id+"'>"+myjson[i].creat_date+"<br>"+myjson[i].end_date+"</font></td><td><font id='store"+myjson[i].order_id+"'>"+myjson[i].store_name+"</font></td><td><font id='total_price"+myjson[i].order_id+"'>"+myjson[i].total_price+"</font></td>";
	    				str += "<td><font id='limit_date"+myjson[i].order_id+"' style='color:blue;'>"+limit_date1+"</font></td><td><button type='button' class='btn btn-primary' onclick=show_for_sell_scroe('"+myjson[i].order_id+"');>我要评价</button></td></tr>";
	      		}
	      	}
	      	$('#buy_score_table').attr('class','table give_score');
      	}
      	else if($('#buy_search').val()=='buy_score'){
	      	if(myjson.length == 0){
	      		str = "<tr><th>评价</th><th>订单编号</th><th>开始/结束时间</th><th>卖家</th><th>评价意见</th></tr>";
	      	}
	      	else{
	      		str = "<tr><th>评价</th><th>订单编号</th><th>开始/结束时间</th><th>卖家</th><th>评价意见</th></tr>";
	      		for(var i = 0 ; i < myjson.length ; ++i){
	      			if(myjson[i].for_buy_score==null)
	      				str += "<tr><td><font style='color:red'>未评价</font></td>";
	      			else{
		      			if(myjson[i].for_buy_score=='0')
			    				str += "<tr><td><img src='include/images/score01.png'></td>";
			    			else if(myjson[i].for_buy_score=='1')
			    				str += "<tr><td><img src='include/images/score0.png'></td>";
			    			else if(myjson[i].for_buy_score=='2')
			    				str += "<tr><td><img src='include/images/score-1.png'></td>";
		    			}
		    			str += "<td>"+myjson[i].order_id+"</td><td>"+myjson[i].creat_date+"<br>"+myjson[i].end_date+"</td><td>"+myjson[i].store_name+"</td><td>"+myjson[i].for_buy_comment+"</td></tr>";
	      		}
	      	}
	      	$('#buy_score_table').attr('class','table get_score');
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
      		str = "<tr><th>订单编号</th><th>开始/结束时间</th><th>卖家</th><th>订单金额</th><th>评价限制时间</th><th>动作</th></tr>";
      	}
      	else{
      		var str = "";
      		str = "<tr><th>订单编号</th><th>开始/结束时间</th><th>卖家</th><th>订单金额</th><th>评价限制时间</th><th>动作</th></tr>";
      		for(var i = 0 ; i < myjson.length ; ++i){
      			var limit_date0 = new Date(myjson[i].limit_date);
						limit_date0.setDate(limit_date0.getDate() + 7);
						var limit_date1 = limit_date0.getFullYear() + '-' +(limit_date0.getMonth() + 1) + '-' + limit_date0.getDate();
    				str += "<tr><td>"+myjson[i].order_id+"</td><td><font id='order_date"+myjson[i].order_id+"'>"+myjson[i].creat_date+"<br>"+myjson[i].end_date+"</font></td><td><font id='store"+myjson[i].order_id+"'>"+myjson[i].store_name+"</font></td><td><font id='total_price"+myjson[i].order_id+"'>"+myjson[i].total_price+"</font></td>";
    				str += "<td><font id='limit_date"+myjson[i].order_id+"' style='color:blue;'>"+limit_date1+"</font></td><td><button type='button' class='btn btn-primary' onclick=show_for_sell_scroe('"+myjson[i].order_id+"');>我要评价</button></td></tr>";

      		}
      	}
      	$('#buy_score_table').html(str);
      	$('#buy_score_table').attr('class','table give_score');
      },

       error:function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
       }
  	});
	});

	//--seller--//
	function show_for_buy_scroe(order_id){
		$('#for_buy_score_order_id').val(order_id);
		/*
		$('#for_buy_score_order_date').html($('#order_date'+order_id).html());
		$('#for_buy_score_store').html($('#store'+order_id).html());
		$('#for_buy_score_total_price').html($('#total_price'+order_id).html());
		$('#for_buy_score_limit_date').html($('#limit_date'+order_id).html());
		*/
		block('for_buy_score_div');
		none('sell_score_div');
	}
	$('#for_buy_score_btn').click(function(e){
		var for_buy_score = 1;
		for(var i = 0 ; i <=2 ; ++i)
			if(Dd('for_buy_score'+i).checked==true)
				for_buy_score = i;

		$.ajax({
      url: 'ajax/score.php',
      data: 'action=for_buy_score&order_id='+$('#for_buy_score_order_id').val()+'&for_buy_score='+for_buy_score+'&for_buy_comment='+$('#for_buy_comment').val(),
      type:"POST",
      dataType:'text',

      success: function(mytext){
      	var arr = new Array();
      	arr = mytext.split("|");
      	if(arr[0]=='0')
      		history.go(0);
      	else
      		alert(mytext);
      },

       error:function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
       }
  	});

	});
	$('#sell_score_btn').click(function(e){
		block('sell_score_div');
		none('for_buy_score_div');
		$('#sell_search').val('sell_score');
		$('#sell_date_range').val('month');
		$.ajax({
      url: 'ajax/score.php',
      data: 'action=sell_get_score&sell_search='+$('#sell_search').val()+'&sell_date_range=month',
      type:"POST",
      dataType:'JSON',

      success: function(myjson){
      	var str = "";
      	if(myjson.length == 0){
      		str = "<tr><th>评价</th><th>订单编号</th><th>开始/结束时间</th><th>买家</th><th>评价意见</th></tr>";

      	}
      	else{

      		str = "<tr><th>评价</th><th>订单编号</th><th>开始/结束时间</th><th>买家</th><th>评价意见</th></tr>";
      		for(var i = 0 ; i < myjson.length ; ++i){
      			if(myjson[i].for_sell_score==null)
      				str += "<tr><td><font style='color:red'>未评价</font></td>";
      			else{
	      			if(myjson[i].for_sell_score=='0')
		    				str += "<tr><td><img src='include/images/score01.png'></td>";
		    			else if(myjson[i].for_sell_score=='1')
		    				str += "<tr><td><img src='include/images/score0.png'></td>";
		    			else if(myjson[i].for_sell_score=='2')
		    				str += "<tr><td><img src='include/images/score-1.png'></td>";
	    			}
	    			str += "<td>"+myjson[i].order_id+"</td><td>"+myjson[i].creat_date+"<br>"+myjson[i].end_date+"</td><td>"+myjson[i].user_nick+"</td><td>"+myjson[i].for_sell_comment+"</td></tr>";
      		}

      	}
      	$('#sell_score_table').html(str);
      	$('#sell_score_table').attr('class','table get_score');
      },

       error:function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
       }
  	});
	});
	$('#sell_date_range').change(function(e){
		block('sell_score_div');
		none('for_buy_score_div');
		$.ajax({
      url: 'ajax/score.php',
      data: 'action=sell_get_score&sell_search='+$('#sell_search').val()+'&sell_date_range='+$('#sell_date_range').val(),
      type:"POST",
      dataType:'JSON',

      success: function(myjson){
      	var str = "";
      	if($('#sell_search').val()=='sell_score_yet'){
      		if(myjson.length == 0){
	      		str = "<tr><th>订单编号</th><th>开始/结束时间</th><th>买家</th><th>订单金额</th><th>评价限制时间</th><th>我要评价</th></tr>";
	      	}
	      	else{
	      		var str = "";
	      		str = "<tr><th>订单编号</th><th>开始/结束时间</th><th>买家</th><th>订单金额</th><th>评价限制时间</th><th>我要评价</th></tr>";
	      		for(var i = 0 ; i < myjson.length ; ++i){
	      			var limit_date0 = new Date(myjson[i].limit_date);
							limit_date0.setDate(limit_date0.getDate() + 7);
							var limit_date1 = limit_date0.getFullYear() + '-' +(limit_date0.getMonth() + 1) + '-' + limit_date0.getDate();
	    				str += "<tr><td>"+myjson[i].order_id+"</td><td><font id='order_date"+myjson[i].order_id+"'>"+myjson[i].creat_date+"<br>"+myjson[i].end_date+"</font></td><td><font>"+myjson[i].user_nick+"</font></td><td><font id='total_price"+myjson[i].order_id+"'>"+myjson[i].total_price+"</font></td>";
	    				str += "<td><font id='limit_date"+myjson[i].order_id+"' style='color:blue;'>"+limit_date1+"</font></td><td><button type='button' class='btn btn-primary' onclick=show_for_buy_scroe('"+myjson[i].order_id+"');>我要评价</button></td></tr>";
	    			}
	      	}
	      	$('#sell_score_table').attr('class','table give_score');
      	}
      	else if($('#sell_search').val()=='sell_score'){
	      	if(myjson.length == 0){
	      		str = "<tr><th>评价</th><th>订单编号</th><th>开始/结束时间</th><th>买家</th><th>评价意见</th></tr>";
	      	}
	      	else{
	      		str = "<tr><th>评价</th><th>订单编号</th><th>开始/结束时间</th><th>买家</th><th>评价意见</th></tr>";
	      		for(var i = 0 ; i < myjson.length ; ++i){
	      			if(myjson[i].for_sell_score==null)
	      				str += "<tr><td><font style='color:red'>未评价</font></td>";
	      			else{
		      			if(myjson[i].for_sell_score=='0')
			    				str += "<tr><td><img src='include/images/score01.png'></td>";
			    			else if(myjson[i].for_sell_score=='1')
			    				str += "<tr><td><img src='include/images/score0.png'></td>";
			    			else if(myjson[i].for_sell_score=='2')
			    				str += "<tr><td><img src='include/images/score-1.png'></td>";
		    			}
		    			str += "<td>"+myjson[i].order_id+"</td><td>"+myjson[i].creat_date+"<br>"+myjson[i].end_date+"</td><td>"+myjson[i].user_nick+"</td><td>"+myjson[i].for_sell_comment+"</td></tr>";
	      		}
	      	}
	      }
      	$('#sell_score_table').html(str);
      	$('#sell_score_table').attr('class','table get_score');
      },

       error:function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
       }
  	});
	});
	$('#sell_score_yet_btn').click(function(e){
		block('sell_score_div');
		none('for_buy_score_div');
		$('#sell_search').val('sell_score_yet');
		$('#sell_date_range').val('month');
		$.ajax({
      url: 'ajax/score.php',
      data: 'action=sell_get_score&sell_search='+$('#sell_search').val()+'&sell_date_range=month',
      type:"POST",
      dataType:'JSON',

      success: function(myjson){
      	var str = "";
      	var error = false;
      	if(myjson.length == 0){
      		str = "<tr><th>订单编号</th><th>开始/结束时间</th><th>买家</th><th>订单金额</th><th>评价限制时间</th><th>动作</th></tr>";
      	}
      	else{
      		var str = "";
      		str = "<tr><th>订单编号</th><th>开始/结束时间</th><th>买家</th><th>订单金额</th><th>评价限制时间</th><th>动作</th></tr>";
      		for(var i = 0 ; i < myjson.length ; ++i){
      			var limit_date0 = new Date(myjson[i].limit_date);
						limit_date0.setDate(limit_date0.getDate() + 7);
						var limit_date1 = limit_date0.getFullYear() + '-' +(limit_date0.getMonth() + 1) + '-' + limit_date0.getDate();
    				str += "<tr><td>"+myjson[i].order_id+"</td><td><font id='order_date"+myjson[i].order_id+"'>"+myjson[i].creat_date+"<br>"+myjson[i].end_date+"</font></td><td><font>"+myjson[i].user_nick+"</font></td><td><font id='total_price"+myjson[i].order_id+"'>"+myjson[i].total_price+"</font></td>";
    				str += "<td><font id='limit_date"+myjson[i].order_id+"' style='color:blue;'>"+limit_date1+"</font></td><td><button type='button' class='btn btn-primary' onclick=show_for_buy_scroe('"+myjson[i].order_id+"');>我要评价</button></td></tr>";

      		}
      	}
      	$('#sell_score_table').html(str);
      	$('#sell_score_table').attr('class','table give_score');
      },

       error:function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
       }
  	});
	});
</script>