var g_sortType = 1,
	g_category = null;

sn.shop.SortBy = function(id) {
	g_sortType = id;
	mr.Dom('#sort_dropdown .Header').SetTxt(event.target.innerText);
	this.DrawProducts();
	return false;
}

sn.shop.SelectCategory = function(cat) {
	g_category = cat;
	this.DrawProducts();
	return false;
}

sn.shop.DrawProducts = function() {
	mr.Query('../get/ShopCatalog/GetProducts', {category : g_category, sort : g_sortType}, function(response) {
	//	console.log(response);
		let r = JSON.parse(response);
		if (r.result) {
			mr.Dom('.shop-shopping-goods').ClearSelf();
			let results = r.result.list;
			let a = {els:[]};
			for (var k in results) {
				var preparedModel = {
					attr:'shop-shipping-goods-item',
					inner:[{tag:'a',attr:{href:'/product/?id=' + results[k]['id']},inner:[]}]
				};
				if (results[k]['unavailable']) {
					preparedModel.inner[0].inner.push({attr:'product_unavaulable',inner:[{attr:'_desc',inner:[{inner:'Нет в наличии'}]}]});
				}
				preparedModel.inner[0].inner.push(
					{attr:{class:'product_cover',style:'background-image: url("../res/' + results[k]['cover_image'] + '");'},inner:[{inner:results[k]['inner']}]},
					{attr:'product_name',inner:[{inner:results[k]['product_name']}]},
					{attr:'product_price',inner:[{inner:results[k]['cost'] + ' ₽'}]}
				);
				a.els.push(preparedModel);
			}
			mr.Dom('.shop-shopping-goods').CreateDOMbyRules(a);
		}
	});
}

sn.shop.toggleCatVisibility = function(el) {
	el.parentNode.querySelector('.shop-sidebar-items').classList.toggle('hidden');
	el.classList.toggle('clicked');
}