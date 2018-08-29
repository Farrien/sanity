<?
# Prevent access from direct calls
defined('SN_Start') or header('HTTP/1.1 404 Not Found');

//	//	28.08.2018//	Author: The Big D//	

echo "\n";
echo "\n";
echo $request->r('p');
echo "\n";
echo "\n";
echo $request->r('value');
echo "\n";
echo "\n";
echo $get->value;
echo "\n";
echo "\n";
echo $get->{'skazet-new'};
echo "\n";
echo "\n";
echo $request->isMethod('get');
echo "\n";
echo "\n";
echo $request->url();
echo "\n";
echo "\n";


return [];