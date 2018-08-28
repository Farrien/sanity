<?
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

//	//	28.08.2018//	Author: The Big D//	?>

<button onclick="cave()">PRESS</button>

<script>
function cave(){
	mr.Query('/apartments/', {request_type : 1, param_sections : [1,2,3], param_cost_range : [1000000, 4000000], param_area_range : [20, 55], param_floors_range : [1, 12], param_rooms_range : [1, 3]}, function(r) {
		console.log(r);
	});
}
</script>