<div class="PageHeader"><?=$PageTitle?></div>
<div class="WhiteBlock VerticalSpaces">
	<div class="items-listing">
	
	<?if (count($users)) {
		foreach($users as $v) {?>
	
		<div class="listing-item">
			<div class="any-id-item user-item">
				<div class="user-photo" style="background-image: url('<?=$v['photo']?>');"></div>
				<div class="">
					<div>ID <?=$v['id']?></div>
					<div><?=$v['login']?></div>
				</div>
				<div><?=$v['name']?></div>
				<div><?=$v['when_joined']?></div>
				<div></div>
			</div>
		</div>
	
		<?}
	} else {?>
	
		<div class="empty-list">Пользователей не найдено</div>
	
	<?}?>
	
	</div>
</div>