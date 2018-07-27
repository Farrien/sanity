<?
class ShopManagementClass Extends BaseController {
	// permissions - who can change?
	private $taskEditPerms = array(
		2 => true
	);
	private $userPerms;
	
	public function __proto() {
		global $USER;
		$this->userPerms = $USER['privileges'];
		if ($this->taskEditPerms[$this->userPerms]) return true;
		return false;
	}
	
	public function ChangeProductInfo() {
		$productID = (int) $this->C_QUERY['product_id'];
		$newName = prepareString($this->C_QUERY['product_name']);
		$newQuantity = (int) $this->C_QUERY['product_quantity'];
		$newCategory = (int) $this->C_QUERY['product_category'];
		$newCost = prepareString($this->C_QUERY['product_cost']);
		
		if (empty($productID) || empty($newName) || empty($newQuantity) || empty($newCategory) || empty($newCost)) return false;
		
		$q = $this->DB->prepare('UPDATE shop_goods SET product_name=?, quantity=?, category_id=?, cost=?, updated_time=? WHERE id=?');
		$q->execute(array(
			$newName,
			$newQuantity,
			$newCategory,
			$newCost,
			$_SERVER['REQUEST_TIME'],
			$productID
		));
		return true;
	}
	
}
?>