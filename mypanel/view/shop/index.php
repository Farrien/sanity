<?# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');?>

<div class="PageHeader"><?=$PageTitle?></div>

<div class="WhiteBlock VerticalSpaces">
	<?foreach ($products AS $v) {?>
	<div class="data-box-product-info">
		<a href="?act=shop/products/form&product_id=<?=$v['id']?>">
			<div class="product-info-title"><?=$v['articul']?> <?=$v['product_name']?></div>
			<div class="product-info-numbers">
				<div class="product-info-quantity"><?=$v['quantity']?></div>
				<div class="product-info-cost"><?=$v['cost']?> ₽</div>
			</div>
		</a>
	</div>
	<?}?>
	<div class="field-space"></div>

	<div class="data-box-field">
		<a class="ui-mypanel-link" href="?act=shop/products/form">Добавить товар</a>
	</div>

	<div class="field-space"></div>
</div>