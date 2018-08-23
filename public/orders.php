<?# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');?>

<div class="breadcrumb-container">
	<div class="Breadcrumbs"><?=$PageTitle?></div>
</div>

<?if ($hasOrders) {?>
	<div>
		<?foreach ($myOrders AS $v) {?>
		<div>
			<div><?=$v['id']?></div>
			<div>Товаров в заказе: <?=$v['goods_count']?></div>
			<div><?=$v['shipping_city']?></div>
			<div><?=$v['cost_sum']?> ₽</div>
		</div>
		<?}?>
	</div>
<?} else {?>
	<p>Вы не совершали никаких заказов.</p>
<?}?>