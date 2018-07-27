sn.shop = {};



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