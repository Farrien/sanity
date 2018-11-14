<div class="PageHeader"><?=$PageTitle?></div>
<div class="WhiteBlock VerticalSpaces">
	<form id="form-news-add">
	<?foreach ($input_rows as $v) {
		if ($v['type'] == 'textarea') {?>
		
		<div class="data-box-field">
			<textarea class="xver" rows="5" name="row_<?=$v['name']?>" placeholder="<?=$v['desc']?>"><?=$v['value']?></textarea>
		</div>
		
		<?} else {?>
		
		<div class="data-box-field">
			<div class="input-placeholder"><?=$v['desc']?></div>
			<input type="text" name="row_<?=$v['name']?>" placeholder="<?=$v['desc']?>" value="<?=$v['value']?>">
		</div>
		
		<?}
	}?>
	</form>
	<div class="field-space"></div>
	<div class="data-box-field">
		<a class="ui-mypanel-link" href="#" onclick="return local_action_1();">Опубликовать</a>
	</div>
	
	<?if ($update_state) {?>
	
	<div class="data-box-field">
		<a class="ui-mypanel-link red-sense" href="#" onclick="return local_action_2();">Удалить</a>
	</div>
	
	<?}?>
</div>

<script>
<?if ($update_state) {?>

function local_action_1() {
	mr.SendForm('?act=news/main/update/<?=$news_id?>', '#form-news-add', function(r) {
	//	console.log(r);
		location.href = '?act=news/main';
	});
	return false;
}

function local_action_2() {
	mr.Query('?act=news/main/remove/<?=$news_id?>', {}, function(r) {
	//	console.log(r);
		location.href = '?act=news/main';
	});
	return false;
}

<?} else {?>

function local_action_1() {
	mr.SendForm('?act=news/main/post', '#form-news-add', function(r) {
	//	console.log(r);
		location.href = '?act=news/main';
	});
	return false;
}

<?}?>
</script>