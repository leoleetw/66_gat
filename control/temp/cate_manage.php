<font style='color:red'>分类不得删除 只能隐藏 以及更改名称 请注意</font>
<!--翡翠
和闐玉
有機寶石(珍珠 珊瑚)
彩寶
鑽石-->
<div id='cate_div'>
	<div id='cate_div1' class="col-lg-6" style='display:block'>		
		<input type='hidden' id='parent_id1' name='parent_id1' value='0' >
		<table id='cate_table1' class='table'>
			<tr><th>分类编号</th><th>分类名称</th><th>状态</th><th>动作</th></tr>
			<? 
				$sql = "select * from category where parent_id = 0 AND rank = 1 order by cate_id";
				$result = mysqli_query($sqli,$sql);
				while($row = mysqli_fetch_array($result)){
			?>
				<tr>
					<td><? echo $row["cate_id"]; ?></td>
					<td onclick="rename_focus(<? echo $row["cate_id"]; ?>);">
						<div id="cate_name_div<? echo $row["cate_id"]; ?>"><? echo $row["cate_name"]; ?></div>
						<div><input type='text' id="cate_name_input<? echo $row["cate_id"]; ?>" class='form-control' style='display:none' value='<? echo $row["cate_name"]; ?>' onblur="rename(<? echo $row["cate_id"]; ?>)"></div>
					</td>
					<td>
						<?
							$img_show = "";
							if($row["is_show"]==0)
								$img_show = "../include/images/control/ok.png";
							else
								$img_show = "../include/images/control/no.png";
						?>
						<img id="cate_state_img<? echo $row["cate_id"]; ?>" src="<? echo $img_show; ?>" onclick="change_cate_state(<? echo $row["cate_id"]; ?>)" style="width:50px;">
					</td>
					<td>
						<input type='button' id='' onclick="show_cate(<? echo $row["cate_id"]; ?> , 1)" class='btn btn-error' value='编辑子项目'>
					</td>
				</tr>
			<? } ?>
		</table>
		<input type="button" id="back_btn1" name="back_btn1" value="回上层" onclick="back_cate(1);" class="btn" style="display:none">
		<input type='button' id='add_btn1' name='add_btn1' onclick="cahgne_add_config(1);" class='btn btn-warning' value='新增项目' data-toggle="modal" data-target="#add_Modal"  data-backdrop="static" data-keyboard=false>
	</div>
</div>
<form id='add_form'>
	<div class="modal fade" id="add_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<h1 align='center'>新增分类</h1>
	      </div>
	      <div class="modal-body">
	      	<input type='hidden' id='parent_id' name='parent_id' value=''>
	      	<input type='hidden' id='rank' name='rank' value=''>
	      	<font id='add_from'></font>
	      	<label>分类名称︰</label>
	      	<input type='text' class='form-control' id='add_name' name='add_name' >
	      </div>
	      <div class="modal-footer">
	      	<input type='hidden' id='action' name='action' value='add'>
	        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	        <button type="button" class="btn btn-primary" id='add_cate_btn'>确定</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>
<script>
  //ajax 变动分类显示
  function change_cate_state(cate_id){
  	$.ajax({
	      url: 'ajax/category.php',
	      data: 'action=change_state&cate_id='+cate_id,
	      type:"POST",
	      dataType:'text',
	
	      success: function(mytext){
	      	var arr = new Array();
	      	arr = mytext.split("|");
	      	if(arr[0]=='0'){
	      		var img_url = "";
	      		if(arr[2]=='0')
	      			img_url = "../include/images/control/ok.png";
	      		else
	      			img_url = "../include/images/control/no.png";
	      		Dd("cate_state_img"+arr[1]).src = img_url;
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
  
  //變更名稱
  function rename(cate_id){
  	if(Dd("cate_name_input"+cate_id).value.trim() == ""){
  		alert("分类名称不得为空");
  		Dd("cate_name_input"+cate_id).value = Dd("cate_name_div"+cate_id).innerHTML;
  	}
  	else{
  		$.ajax({
	      url: 'ajax/category.php',
	      data: 'action=rename&cate_id='+cate_id+'&new_name='+Dd("cate_name_input"+cate_id).value,
	      type:"POST",
	      dataType:'text',
	
	      success: function(mytext){
	      	var arr = new Array();
	      	arr = mytext.split("|");
	      	if(arr[0]=='0'){
	      		Dd("cate_name_input"+arr[1]).value = arr[2];
	      		Dd("cate_name_div"+arr[1]).innerHTML = arr[2];
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
  	none("cate_name_input"+cate_id);
  	block("cate_name_div"+cate_id);
  }
  //显示变更名称
  function rename_focus(cate_id){
  	none("cate_name_div"+cate_id);
  	block("cate_name_input"+cate_id);
  	var temp_val = Dd("cate_name_input"+cate_id).value;
  	Dd("cate_name_input"+cate_id).focus();
  	Dd("cate_name_input"+cate_id).value = "";
  	Dd("cate_name_input"+cate_id).value = temp_val;
  }
  
  //创造下一层
  function creat_div(rank){
  	var new_rank = rank+1;
  	var back_btn  = document.createElement("input");
  	back_btn.setAttribute("type", "button");
  	back_btn.setAttribute("id", "back_btn"+new_rank);
  	back_btn.setAttribute("value", "回上层");
  	back_btn.setAttribute("onclick", "back_cate("+new_rank+");");
  	back_btn.setAttribute("class", "btn");
  	back_btn.setAttribute("style", "display:none");
  	var div = document.createElement("div");
		div.setAttribute("id", "cate_div"+new_rank);
		div.setAttribute("class", "col-lg-6");
		div.setAttribute("style", "display:block");
		var parent_id = document.createElement("input");
		parent_id.setAttribute("id", "parent_id"+new_rank);
		parent_id.setAttribute("name", "parent_id"+new_rank);
		parent_id.setAttribute("type", "hidden");
		parent_id.setAttribute("value", "");
		var table = document.createElement("table");
		table.setAttribute("id", "cate_table"+new_rank);
		table.setAttribute("class", "table");
		table.innerHTML = "<tr><th>分类编号</th><th>分类名称</th><th>状态</th></tr>";
		var add = document.createElement("input");
		add.setAttribute("type", "button");
		add.setAttribute("id", "add_btn"+new_rank);
		add.setAttribute("name", "add_btn"+new_rank);
		add.setAttribute("onclick", "cahgne_add_config("+new_rank+");");
		add.setAttribute("class", "btn btn-warning");
		add.setAttribute("value", "新增项目");
		add.setAttribute("data-toggle", "modal");
		add.setAttribute("data-target", "#add_Modal");
		add.setAttribute("data-backdrop", "static");
		add.setAttribute("data-keyboard", "false");
		$( "#cate_div" ).append( div );
		
		$( div ).append( parent_id );
		$( div ).append( table );
		$( div ).append( back_btn );
		$( div ).append( add );
  }
  
  //返回上层
  function back_cate(rank){
  	if(rank > 1){
	  	none("cate_div"+(rank+1));
	  	block("cate_div"+(rank-1));
	  	none("back_btn"+rank);
	  	if(rank > 2)
		  	block("back_btn"+(rank-1));
	  }
  }
  
  //显示下层
  function show_cate(cate_id , rank){
  	var new_rank = rank + 1 ;
  	var str = "";
		if(!$("#cate_div"+new_rank).length){
			creat_div(rank);
		}
		Dd('parent_id'+new_rank).value = cate_id ;
		$.ajax({
      url: 'ajax/category.php',
      data: 'action=gat_cate&cate_id='+cate_id+'&rank='+new_rank,
      type:"POST",
      dataType:'json',

      success: function(arr){
      	var img_url = "";
      	str = "<tr><th colspan='3'>"+arr.cate_name+"</th></tr><tr><th>分类编号</th><th>分类名称</th><th>状态</th></tr>";
      	for(var i = 0 ; i < arr.cate.length ; ++i){
      		if(arr.cate[i].is_show =='0')
      			img_url = "../include/images/control/ok.png";
      		else
      			img_url = "../include/images/control/no.png";
      		str += "<tr><td>"+arr.cate[i].cate_id+"</td>";
      		str += "<td onclick=rename_focus("+arr.cate[i].cate_id+");><div id='cate_name_div"+arr.cate[i].cate_id+"'>"+arr.cate[i].cate_name+"</div>";
      		str += "<div><input type='text' id='cate_name_input"+arr.cate[i].cate_id+"' class='form-control' style='display:none' value='"+ arr.cate[i].cate_name +"' onblur=rename(" + arr.cate[i].cate_id + ")></div></td>";
      		str += "<td><img id='cate_state_img"+arr.cate[i].cate_id+"' src='"+img_url+"' onclick=change_cate_state("+arr.cate[i].cate_id+") style='width:50px;'></td></tr>";
      	}
      	Dd('cate_table'+new_rank).innerHTML = str;
      },

       error:function(xhr, ajaxOptions, thrownError){ 
          alert(xhr.status); 
          alert(thrownError); 
       }
  	});
  	if($("#cate_div"+(rank-1)).length){
	  		none('cate_div'+(rank-1));
	  		block('cate_div'+new_rank);
	  		if(rank != 1 )
	  			block("back_btn"+rank);
	  }
  }
  
	function cahgne_add_config(rank){
		Dd('parent_id').value = Dd('parent_id'+rank).value;
		Dd('rank').value = rank;
	}
	$('#add_cate_btn').click(function(e){
		if(Dd('add_name').value.trim() == '' ){
			alert('新增项目不得为空白');
		}
		else{
			$.ajax({
	      url: 'ajax/category.php',
	      data: $('#add_form').serialize(),//
	      type:"POST",
	      dataType:'text',
	
	      success: function(mytext){
	      	  var arr = new Array();
	      	  arr = mytext.split("|");
	      	  if(arr[0]=='0'){
	      	  	if(Dd("rank").value!='1'){
	      	  		$("#cate_table"+arr[1]).append( "<tr>" +
                            "<td>" + arr[2] + "</td>" +
                            "<td onclick=rename_focus("+arr[2]+");>" + "<div id='cate_name_div"+arr[2]+"'>"+ arr[3] +"</div>" +
                            "<div><input type='text' id='cate_name_input"+arr[2]+"' class='form-control' style='display:none' value='"+ arr[3] +"' onblur=rename(" + arr[2] + ")></div></td>" +
                            "<td>" + "<img id='cate_state_img"+arr[2]+"' src='../include/images/control/ok.png' onclick=change_cate_state("+arr[2]+") style='width:50px;'>" + "</td>" +
                            "</tr>" );
	      	  	}
	      	  	else{
	      	  	$("#cate_table"+arr[1]).append( "<tr>" +
                            "<td>" + arr[2] + "</td>" +
                            "<td onclick=rename_focus("+arr[2]+");>" + "<div id='cate_name_div"+arr[2]+"'>"+ arr[3] +"</div>" +
                            "<div><input type='text' id='cate_name_input"+arr[2]+"' class='form-control' style='display:none' value='"+ arr[3] +"' onblur=rename(" + arr[2] + ")></div></td>" +
                            "<td>" + "<img id='cate_state_img"+arr[2]+"' src='../include/images/control/ok.png' onclick=change_cate_state("+arr[2]+") style='width:50px;'>" + "</td>" +
                            "<td>" + "<input type='button' id='' onclick=show_cate("+arr[2]+","+arr[1]+") class='btn btn-error' value='编辑子项目'>" + "</td>" +
                            "</tr>" );
              }
              $('#add_Modal').modal('hide');
	      	  }
	      	  else if(arr[0]=='1'){
	      	  }
	      	  else
	      	  	alert(mytext);
	      },
	
	       error:function(xhr, ajaxOptions, thrownError){ 
	          alert(xhr.status); 
	          alert(thrownError); 
	       }
	  	});
	  }
	})
</script>