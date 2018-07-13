<?
namespace Sources;

Abstract Class BaseModel {
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
	
	public static function about() {
		echo __NAMESPACE__;
	}
}

?>