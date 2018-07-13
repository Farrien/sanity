<?
use Helper\Userthings\Userthings;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$response = array();
	if (isset($_POST['shared_login'])) {
		$response['correct'] = false;
		$response['exist'] = false;
		$_POST['shared_login'] = preg_replace('/(\+7|\+8)/', '8', $_POST['shared_login'], 1);
		if (preg_match('/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/', $_POST['shared_login'])) $response['correct'] = true;
		if (Userthings::CheckLoginExisting($_POST['shared_login']) == true) $response['exist'] = true;
	}
	
	if (count($response) > 0) die(cyrJson(json_encode($response)));
}
?>