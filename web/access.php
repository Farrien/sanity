<?php
/*
*	Usage
*
*	If a user has no permission, class calls given anonymous function.

*	Rules triggers from top to bottom
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

Permission::exclude(0, '/account/', function() {
	return redirect('/login/');
});


Permission::allow(2, '/mypanel/', function() {
	return false;
});