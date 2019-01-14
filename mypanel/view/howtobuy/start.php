<div class="PageHeader"><?=$PageTitle?></div>
<div class="WhiteBlock VerticalSpaces">
	<div class="data-box-field">
		<a class="ui-mypanel-link" href="?act=howtobuy/main/info">Добавить новый банк</a>
	</div>
	<div class="field-space"></div>
	<div class="banks-listing">
		
	<?if (count($items) < 1) {?>
		
		<div class="empty-list">Ничего не найдено</div>
		
	<?} else {
		foreach($items as $v) {?>

		<a href="?act=howtobuy/main/info/<?=$v['id']?>" class="ui-mypanel-a">
			<div class="bank-item">
				<div class="bank-cover" style="background-image: url('<?=$v['image_path']?>');"></div>
			</div>
		</a>

		<?}
	}?>

	</div>
</div>