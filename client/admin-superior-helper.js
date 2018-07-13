mr.Dom(function() {
	
});

UfaEyesInterface.swapToManager = function(user_id) {
	mr.Query('../get/Admin/ChangeUserHireStatement', {target : user_id}, function(response) {
	//	console.log(response);
	});
	return false;
};

UfaEyesInterface.swapToWorker = function(user_id) {
	mr.Query('../get/Admin/ChangeUserToWorker', {target : user_id}, function(response) {
		console.log(response);
	});
	return false;
};

UfaEyesInterface.getListOfUsers = function(food, adds) {
	if (food.length < 3) return false;
	if (adds === undefined) {
		adds = {userGroup : null};
	}
	adds.strLogin = food;
	mr.Query('../get/Users/GetUsersList', adds, function(response) {
	//	console.log(response);
		var a = {els:[]};
		var r = JSON.parse(response);
		var users = r.result.users;
		for (var k in users) {
			let checkboxEl = {tag:'input',attr:{type:'checkbox',class:'checking',onclick:'UfaEyesInterface.swapToManager(' + users[k]['id'] + ')'}};
			if (users[k]['group'] == 1) checkboxEl.attr.checked = true;
			var preparedModel = {
				attr:'ui-ue-managers-table',
				inner:[
					{attr:{class:'_row',style:'width:auto'},inner:[checkboxEl]},
					{attr:{class:'_row',style:'width:10%'},inner:[{inner:users[k]['id']}]},
					{attr:'_row',inner:[{inner:users[k]['login']}]},
					{attr:'_row',inner:[{inner:users[k]['name']}]},
				]
			};
			a.els.push(preparedModel);
		}
		mr.Dom('#UsersListing').ClearSelf();
		mr.Dom('#UsersListing').CreateDOMbyRules(a);
	});
	return false;
};
