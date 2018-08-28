<?php
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

return [
	'error' => 'Ошибка',
	
	'#SN_Errors_TotalCount' => 'Количество ошибок'
];