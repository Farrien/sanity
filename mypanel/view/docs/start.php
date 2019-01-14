<div class="PageHeader"><?=$PageTitle?></div>
<div class="WhiteBlock VerticalSpaces">
	<div class="data-box-field">
		<a class="ui-mypanel-link" href="?act=docs/main/doc">Добавить документ</a>
	</div>
	<div class="field-space"></div>
	<div class="items-listing">
	
	<?if (count($docs)) {
		
		foreach($docs as $v) {
			$v['doc_name'] = $v['doc_name'] ?: 'Название отсутствует';?>
	
		<div class="listing-item">
			<a class="ui-mypanel-a" href="?act=docs/main/doc/<?=$v['id']?>">
				<div class="item-link naturalize"><?=$v['doc_name']?></div>
			</a>
		</div>
		
		<?}
		
	} else {?>
	
		<div class="empty-list">Пользователей не найдено</div>
	
	<?}?>
	
	</div>
</div>