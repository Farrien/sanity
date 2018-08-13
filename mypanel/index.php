<?
const SN_Start = true;

require_once $_SERVER['DOCUMENT_ROOT'] . '/base.php';
$SN = new SN_Management;

$SN->ext('settings');
$SN->ext('database');
$SN->ext('util');

$ScreenTitle = APP_NAME;

if (empty($_REQUEST['act'])) $_REQUEST['act'] = 'start/dashboard';

# $RequestOptions ---> $RO
$RO = [];
$RO['ACT'] = trim(prepareString($_REQUEST['act']), '/\\');
$a1 = explode('/', $RO['ACT']);
$RO['SECTION'] = ucfirst($a1[0]);
$RO['SCRIPT']= ucfirst($a1[1]);
$RO['ACTION']= $a1[2] ?: 'start';

Abstract class MyPanelController {
	protected $data = [];
	protected $request = [];
	public $pageTitle = 'Default title';
	protected $output = 'index';
	protected $model;
	function __construct($req) {
		$this->request = $req;
	}
	
	public function data() {
		return $this->data;
	}
	
	public function view() {
		return $this->output;
	}
	
	protected function Model($model_name) {
		$modelSOURCE	= __DIR__ . '/model/' . $model_name . '.php';
		if (file_exists($modelSOURCE)) {
			$a = explode('/', $model_name);
			require_once $modelSOURCE;
			$m = $a[0] . $a[1] . 'Model';
			$this->model = new $m();
		}
	}
	
	protected function SetTitle($str = 'Missing title') {
		$this->pageTitle = $str;
	}
	
	protected function SetOutput($view_name) {
		$this->output = $view_name;
	}
	
	protected function Relocate($target) {
		header('Location: ../mypanel/?act=' . $target);
	}
	
	public function getTitle() {
		return $this->pageTitle;
	}
}

Abstract class MyPanelModel {
	protected $pdo;
	function __construct() {
		global $pdo_db;
		$this->pdo = $pdo_db;
	}
}

$conSOURCE_		= __DIR__ . '/controller/' . $RO['SECTION'] . '/' . $RO['SCRIPT'] . '.php';

if (file_exists($conSOURCE_)) {
	require_once $conSOURCE_;
	$classname = $RO['SECTION'] . $RO['SCRIPT'] . 'Controller';
	$METHOD = $RO['ACTION'];
	$CONTROLLER = new $classname($_REQUEST, $pdo_db);
	if (is_callable(array($CONTROLLER, $METHOD))) {
		$CONTROLLER->$METHOD($_REQUEST);
		$ConIsPresent = true;
		$useController = true;
	}
	$PageTitle = $CONTROLLER->getTitle();
} else {
	header('Location: ../mypanel/?act=start/dashboard');
	die();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>
<!DOCTYPE html>
<html>
<head>
<?include $_SERVER['DOCUMENT_ROOT'] . '/templates/SanityHeaderLayout.php';?>
</head>
<body <?echo $uniqueBGStyle ? 'class="grey"' : ''?>>
<div class="">
	<div class="uip-WindowSpace">
		<div class="uip-TopPart">
			<div class="uip-ScreenName"><?=$ScreenTitle?></div>
		</div>
		<?if ($useController) {
			$extractedVariablesCount = extract($CONTROLLER->data(), EXTR_OVERWRITE);
			$view = $_SERVER['DOCUMENT_ROOT'] . '/mypanel/view/' . $RO['SECTION'] . '/' . $CONTROLLER->view() . '.php';
			include $view;
		}?>
	</div>
</div>
</body>
</html>
<?}?>