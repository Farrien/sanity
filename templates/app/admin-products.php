<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');?>

<div class="admin-shop-products">
	<div class="admin-shop-product">
		<div class="flexContainer" style="font-weight: 500;">
			<div class="fl bs10"></div>
			<div class="fl bs40">Название</div>
			<div class="fl bs20">Категория</div>
			<div class="fl bs10">Количество</div>
			<div class="fl bs10">Цена</div>
			<div class="fl bs10"></div>
		</div>
	</div>
	<?foreach ($Products AS $v) {?>
	<div class="admin-shop-product">
		<div class="flexContainer">
			<div class="fl bs10">
				<div class="admin-shop-product-preview" style="background-image: url('/res/<?=$v['cover_image']?>');"></div>
			</div>
			<div class="fl bs40"><?=$v['product_name']?></div>
			<div class="fl bs20"><?=$v['category_name']?></div>
			<div class="fl bs10"><?=$v['quantity']?></div>
			<div class="fl bs10"><?=$v['cost']?> ₽</div>
			<div class="fl bs10"><a class="link" href="?act=editproduct&id=<?=$v['id']?>" class="">Изменить</a></div>
		</div>
	</div>
	<?}?>
</div>