<?php

/*
|
|--------------------------------------------------------------------------
| Usage
|
| If user has no permission, class calls given anonymous function.
|
|--------------------------------------------------------------------------
|

Permission::allow([1, 2]);

Permission::exclude(1, '/page/', function() {
	return redirect('/');
});

#	rules triggers from top to bottom
*/

Permission::allow(0, '/login/', function() {
	return redirect('/');
});

Permission::exclude(0, '/logout/', function() {
	return redirect('/');
});

Permission::exclude(0, '/orders/', function() {
	return redirect('/');
});

Permission::exclude([0, 2], '/account/', function() {
	return redirect('/');
});


Permission::allow(2, '/mypanel/', function() {
	return false;
});