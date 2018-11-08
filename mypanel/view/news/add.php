<div class="PageHeader"><?=$PageTitle?></div>
<div class="WhiteBlock VerticalSpaces">
	<form id="form-news-add">
	<?foreach ($input_rows as $v) {
		if ($v['type'] == 'textarea') {?>
		
		<div class="data-box-field">
			<textarea class="xver" rows="5" name="row_<?=$v['name']?>" placeholder="<?=$v['desc']?>"></textarea>
		</div>
		
		<?} else {?>
		
		<div class="data-box-field">
			<div class="input-placeholder"><?=$v['desc']?></div>
			<input type="text" name="row_<?=$v['name']?>" placeholder="<?=$v['desc']?>">
		</div>
		
		<?}
	}?>
	</form>
	<div class="field-space"></div>
	<div class="data-box-field">
		<a class="ui-mypanel-link" href="#" onclick="return local_action_1();">Опубликовать</a>
	</div>
</div>

<script>
function local_action_1() {
	mr.SendForm('?act=news/main/post', '#form-news-add', function(r) {
	//	console.log(r);
		location.href = '?act=news/main';
	});
	return false;
}
</script>