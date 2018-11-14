<div class="PageHeader"><?=$PageTitle?></div>
<div class="WhiteBlock VerticalSpaces">
	<div class="data-box-field">
		<a class="ui-mypanel-link" href="?act=news/main/info">Добавить новость</a>
	</div>
	<div class="field-space"></div>
	<div class="items-listing">
		
	<?if (count($news) < 1) {?>
		
		<div class="empty-list">Новостей не найдено</div>
		
	<?} else {
		foreach($news as $v) {?>

		<div class="listing-item">
			<a href="?act=news/main/info/<?=$v['id']?>">
				<div class="item-link naturalize"><?=$v['title']?></div>
			</a>
		</div>

		<?}
	}?>

	</div>
</div>