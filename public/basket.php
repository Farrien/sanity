<?# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');?>

<div class="breadcrumb-container">
	<div class="Breadcrumbs"><?=$PageTitle?></div>
</div>

<div id="basket_items" class="shop-basket-list">

</div>

<div class="shop-basket-control-buttons">
	<button class="xver" id="basket-complete-btn" onclick="registerOrder();" disabled>Оформить</button>
	<button class="xver white" onclick="removeBasket()">Очистить</button>
</div>

<script>
mr.Query('../get/ShopBasket/ConvertProducts', {items : sn.shop.orders.getItem('bin')}, function(response) {
	var r = JSON.parse(response);
	var a = {els:[]};
	if (r.result.length > 0) {
		document.getElementById('basket-complete-btn').disabled = false;
	}
	for (var k in r.result) {
		let preparedModel = {
			attr:'shop-basket-item',
			inner:[
				{attr:'product-title', inner:[{inner:r.result[k].product_name}]},
				{attr:'product-single-cost', inner:[{inner:r.result[k].cost + ' ₽'}]},
				{attr:'product-count', inner:[{inner:String(r.result[k].count + ' шт')}]},
				{attr:'product-total-cost', inner:[{inner:String(r.result[k].total_cost + ' ₽')}]},
			]
		}
		a.els.push(preparedModel);
	};
	mr.Dom('#basket_items').CreateDOMbyRules(a);
});

function registerOrder() {
	sn.shop.completeOrder();
	location.href = '/orders/';
}

function removeBasket() {
	sn.shop.clearOrder();
	location.reload();
}
</script>