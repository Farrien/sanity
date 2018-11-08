<div class="PageHeader"><?=$PageTitle?></div>
<div class="WhiteBlock VerticalSpaces">

	<div class="items-listing">

		<?foreach($news as $v) {?>

		<div class="listing-item">
			<a href="">
				<div class="item-link naturalize"><?=$v['title']?></div>
			</a>
		</div>

		<?}?>

	</div>
	
</div>