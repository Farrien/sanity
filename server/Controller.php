<?
namespace Controller;

Abstract Class BaseController {
	protected $C_QUERY;
	protected $DB;
	protected $CurrentUserID;
	protected $StartTime;

	function __construct($arg1, $arg2) {
		$this->C_QUERY = $arg1;
		$this->DB = $arg2;
	#	$this->StartTime = time();
		$this->StartTime = $_SERVER['REQUEST_TIME'];
		
		global $USER;
		$this->CurrentUserID = $USER['id'];
	}
}
?>