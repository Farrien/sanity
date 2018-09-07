sn.shop = {};

sn.shop.orders = localStorage;

let temp_bin = new Array();
let bin = sn.shop.orders.getItem('bin');
if (!bin) {
	sn.shop.orders.setItem('bin', JSON.stringify(temp_bin));
}


sn.shop.addToOrder = function(product_id) {
	let json_bin = sn.shop.orders.getItem('bin');
	let arr = JSON.parse(json_bin);
	arr.push(product_id);
	sn.shop.orders.setItem('bin', JSON.stringify(arr));
}

sn.shop.clearOrder = function() {
	sn.shop.orders.setItem('bin', JSON.stringify(temp_bin));
}

sn.shop.completeOrder = function() {
	mr.Query('../get/ShopBasket/performNewOrder', {items : sn.shop.orders.getItem('bin')}, function(response) {
	//	console.log(response);
		var r = JSON.parse(response);
		
		if (r.result == true) {
			sn.shop.clearOrder();
		}
	});
}

sn.shop.CreateCallbackRequest = function(product_id) {
	let crp = document.getElementById('callbackRequestPhone');
	let t = event.target;
	mr.Query('../get/CustomRequests/CallbackRequest', {product_id : product_id, client_phone : crp.value}, function(response) {
	//	console.log(response);
		let r = JSON.parse(response);
		if (r.result) {
			crp.disabled = true;
			t.disabled = true;
			t.innerText = 'Вы записаны';
		}
	});
}