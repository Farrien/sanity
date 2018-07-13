<?
$sanityACT = $_REQUEST['r'];

const SN_Start = true;

require_once './base.php';
$SN = new SN_Management;
$SN->ext('settings');
$SN->ext('database');
$SN->ext('util');

# Exceptions for non-logged users
if ($sanityACT == 'CustomRequests/PerformerRequest' || $sanityACT == 'Userdata/Signup' || $sanityACT == 'Userdata/Signin' || $sanityACT == 'Userdata/Restore' || $sanityACT == 'ChatMessages/StartDiscussion' || $sanityACT == 'ChatMessages/GetMessageHistory'  || $sanityACT == 'ChatMessages/SendMessage' ) {
	
} else {
	$SN->ext('permission-control');
}

error_reporting(E_ALL);

$SN->helper('Userthings');
$SN->helper('Data');
$SN->helper('Tasks');
$SN->helper('Users');
$SN->helper('Wallet');

require_once './server/model/ModelSource.php';

class Rout {
	private $R_ACT = null;
	private $R_CONTROLLER = null;
	private $R_METHOD = null;
	private $DEBUG_MODE = false;
	private $R_CLASS = null;
	private $DB = null;
	
	function __construct($arg1, $arg2, $arg3 = false) {
		if ($arg3==true && is_bool($arg3)) $this->EnableDebug();
		if (gettype($arg2)=='object') {
			$this->DB = $arg2;
		}
		$this->SetAct($arg1);
		$this->EnableController();
		$this->CheckMethod();
	}
	
	public function SetAct($arg1) {
		$this->R_ACT = $arg1;
		$arg1 = trim($arg1, '/\\');
		$a1 = explode('/', $arg1);
		$this->R_CONTROLLER = $a1[0];
		$this->R_METHOD = $a1[1];
	}
	
	public function Send($request = '') {
		if (method_exists($this->R_CLASS, '__proto')) {
			if ($this->R_CLASS->__proto() === false) return false;
			
		}
		return $this->R_CLASS->{$this->R_METHOD}($request);
	}
	
	private function EnableController() {
		$s1 = 'server/'.$this->R_CONTROLLER.'Controller.php';
	if ($this->DEBUG_MODE) echo "Controller's path: {$_SERVER['HTTP_HOST']}/{$s1}", "<br />\n";
		
		
		if (is_file($s1)) {
			if ($this->DEBUG_MODE) echo "$this->R_CONTROLLER controller have been enabled.", "<br />\n";
		} else {
			if ($this->DEBUG_MODE) echo "$this->R_CONTROLLER controller have not been enabled.", "<br />\n";
			exit();
		}
		
		if (is_readable($s1) == false) {
			if ($this->DEBUG_MODE) echo "$this->R_CONTROLLER controller is not executable.", "<br />\n";
			exit();
		}
		
		require $s1;
		
		$c1 = $this->R_CONTROLLER.'Class';
		global $_REQUEST;
		unset($_REQUEST['r']);
		$this->R_CLASS = new $c1($_REQUEST, $this->DB);
	}
	
	private function CheckMethod() {
		if (is_callable(array($this->R_CLASS, $this->R_METHOD)) == false) {
			if ($this->DEBUG_MODE) {
				echo "Unable to call {$this->R_METHOD} from controller.", "<br />\n";
			} else {
				print_r(cyrJson(json_encode(array('result'=>false,'error'=>"Unable to call {$this->R_METHOD} from that controller."))));
			}
			exit();
        }
	}
	
	public function EnableDebug() {
		$this->DEBUG_MODE = true;
	}
	
	public function PrintDump() {
		echo "R_ACT => {$this->R_ACT}", "<br />\n";
		echo "R_CONTROLLER => {$this->R_CONTROLLER}", "<br />\n";
		echo "R_METHOD => {$this->R_METHOD}", "<br />\n";
	}
}

Abstract Class BaseController {
	protected $C_QUERY;
	protected $DB;
	protected $CurrentUserID;
	protected $StartTime;
	protected $enabledModels = array();

	function __construct($arg1, $arg2) {
		$this->C_QUERY = $arg1;
		$this->DB = $arg2;
	#	$this->StartTime = time();
		$this->StartTime = $_SERVER['REQUEST_TIME'];
		
		global $USER;
		$this->CurrentUserID = $USER['id'];
	}
	
	function enable($model) {
		if (isset($this->enabledModels[$model])) return;
		require_once __DIR__ . '/server/model/' . $model . '.php';
		$class = $model . '\Model';
		$this->enabledModels[$model] = true;
	#	new $class;
	}
}

$Router = new Rout($sanityACT, $pdo_db, false);
$Result = $Router->Send();
if ($Result) {
	print_r(cyrJson(json_encode(array("result"=>$Result))));
	exit();
}
print_r(json_encode(array("result"=>false)));
exit();
?>