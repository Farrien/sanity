<div class="PageHeader"><?=$PageTitle?></div>
<div class="WhiteBlock VerticalSpaces">
	<form id="form-add">
	
		<?foreach ($input_rows as $v) {?>
		
		<div class="data-box-field">
			<div class="input-placeholder"><?=$v['desc']?></div>
			<input type="text" name="row_<?=$v['name']?>" value="<?=$v['value']?>">
		</div>
		
		<?}?>
	
		<div class="data-box-choose-file">
			<div id="flag-thumb-preview"><?=$file_name?></div>
			<div class="FileForm" p-action="setPreview('#flag-thumb-preview', this);" p-text="Выбрать документ" p-name="row_file" p-accept="application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document"></div>
		</div>
	
	</form>
	<div class="field-space"></div>
	
	<?if ($update_state) {?>
	
	<div class="data-box-field">
		<a class="ui-mypanel-link red-sense" href="#" onclick="return local_action_2();">Удалить</a>
	</div>
	
	<?} else {?>
	
	<div class="data-box-field">
		<a class="ui-mypanel-link" href="#" onclick="return local_action_1();">Отправить</a>
	</div>
	
	<?}?>
</div>

<script>
<?if ($update_state) {?>

function local_action_2() {
	mr.Query('?act=docs/main/remove/<?=$docs_id?>', {}, function(r) {
	//	console.log(r);
		location.href = '?act=docs/main';
	});
	return false;
}

<?} else {?>

function local_action_1() {
	mr.SendForm('?act=docs/main/post', '#form-add', function(r) {
	//	console.log(r);
		location.href = '?act=docs/main';
	});
	return false;
}

<?}?>

function setPreview(preview_container, input) {
	console.log(input.files[0].name);
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function(e) {
			mr.Dom(preview_container).SetTxt(input.files[0].name);
		}
		
		reader.readAsDataURL(input.files[0]);
	}
}
</script>