<div class="col-lg-6 col-lg-offset-3" id='art_list_div'>
	<button type='button' id='add_btn' class='btn btn-warning' >新增</button>
	<table class='table'>
		<thead><tr><th>英文标题(不得重复)</th><th>中文标题</th><th>动作</th></tr></thead>
		<tbody>
		<?
			$sql = "select * from article order by art_id DESC;";
			$result = mysqli_query($sqli,$sql);
			while($row = mysqli_fetch_array($result)){

		?>
		<tr>
			<td id='art_title_en<? echo $row["art_id"];?>'><? echo $row["art_title_en"];?></td>
			<td id='art_title_cn<? echo $row["art_id"];?>'><? echo $row["art_title_cn"];?></td>
			<td>
				<input type='hidden' id='art_content<? echo $row["art_id"];?>' value='<? echo $row["art_content"];?>'>
				<button id='' class='btn btn-primary' onclick="show_art(<? echo $row["art_id"]; ?>);">编辑</button>
			</td>
		</tr>
		<? } ?>
		</tbody>
	</table>
</div>
<div class="col-lg-6 col-lg-offset-3" style='display:none;' id='art_div'>
	<form id='art_form' action='ajax/article.php' method="post">
		<input type='hidden' id='art_id' name='art_id' value=''>
		<table class='table'>
			<tr>
				<td>
					英文标题
				</td>
				<td>
					<input type='text' class='form-control' id='art_title_en' name='art_title_en' value=''>
				</td>
			</tr>
			<tr>
				<td>
					中文标题
				</td>
				<td>
					<input type='text' class='form-control' id='art_title_cn' name='art_title_cn' value=''>
				</td>
			</tr>
			<tr>
				<td>
					内文
				</td>
				<td>
					<textarea id='art_content' name='art_content' class='textarea form-control' style='width:100%;height:700px;'></textarea>
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					<input type='hidden' id='action' name='action' value='add'>
					<button type='button' class='btn btn-primary' id='back_btn' >回上一页</button>
					<button type='button' class='btn btn-primary' id='save_btn' >储存</button>
				</td>
			</tr>
		</table>
	</form>
</div>
<script>
	$('#save_btn').click(function(e){
		if($('#art_title_en').val().trim() == '')
			alert('必填栏位不得为空1');
		else if($('#art_title_cn').val().trim() == '')
			alert('必填栏位不得为空2');
		else
			Dd('art_form').submit();
	});
	$('#back_btn').click(function(e){
		$('#action').val('add');
		$('#art_id').val('');
		Dd('art_form').reset();
		none('art_div');
		block('art_list_div');
	});
	$('#add_btn').click(function(e){
		none('art_list_div');
		block('art_div');
	});
	function show_art(art_id){
		$('#action').val('edit');
		$('#art_id').val(art_id);
		$('#art_title_en').val($('#art_title_en'+art_id).html());
		$('#art_title_cn').val($('#art_title_cn'+art_id).html());
		tinyMCE.get('art_content').setContent($('#art_content'+art_id).val());
		//$('#art_content').val(); tinymce
		none('art_list_div');
		block('art_div');
	}
	tinymce.init({
		mode : "specific_textareas",
    editor_selector : "textarea",
    language:"zh_CN",
    //selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
	});
</script>