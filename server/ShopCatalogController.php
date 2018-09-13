<?

class ShopCatalogClass Extends BaseController {
	
	
	public function GetProducts() {
		$sort = 0;
		if (isset($this->C_QUERY['sort'])) {
			$sort = (int) prepareString($this->C_QUERY['sort']);
			if ($sort < 0 || $sort > 3) {
				$sort = 0;
			}
		}
		$sort_rows = array(
			0 => 'added_time DESC',
			1 => 'added_time ASC',
			2 => 'cost ASC',
			3 => 'cost DESC'
		);
		
		if (isset($this->C_QUERY['category'])) {
			$cat = (int) prepareString($this->C_QUERY['category']);
		}
		
		if (isset($this->C_QUERY['context']) && $this->C_QUERY['context'] != '' && mb_strlen($this->C_QUERY['context']) > 2) {
			$context = (string) prepareString($this->C_QUERY['context']);
		}
		
		function getCategoryDepends($cat_id, &$arr) {
			global $pdo_db;
			$q = $pdo_db->prepare('SELECT id FROM subjects WHERE parent_subject=?');
			$q->execute(array($cat_id));
			$q1 = $pdo_db->prepare('SELECT id FROM subjects WHERE parent_subject=?');
			$arr[] = $cat_id;
			while ($f = $q->fetch(2)) {
				getCategoryDepends($f['id'], $arr);
			}
		}
		
		$conditionCategory = '';
		if ($cat) {
			$CategoryDepends = [];
			getCategoryDepends($cat, $CategoryDepends);
			$conditionCategory = ' AND (category_id=' . $cat;
			foreach ($CategoryDepends AS $v) {
				$conditionCategory .= ' OR category_id=' . $v;
			}
			$conditionCategory .= ')';
		}
		
		$conditionSearch = '';
		if ($context) {
			$conditionSearch = ' AND product_name LIKE "%' . $context . '%"';
		}
		
		$Products = [];
		$sql = 'SELECT id, cover_image, quantity, product_name, cost FROM shop_goods WHERE id!=0 ' . $conditionCategory . $conditionSearch . ' ORDER BY ' . $sort_rows[$sort] . ', product_name ASC';
		$q = $this->DB->prepare($sql);
		$q->execute();
		while ($f = $q->fetch(2)) {
			if ($f['cover_image'] == '') {
				$f['cover_image'] = 'ui/no-photo-big.png';
			} else {
				$f['cover_image'] = 'shop/' . $f['cover_image'];
			}
			if ($f['quantity'] < 1) {
				$f['unavailable'] = true;
			}
			$Products[] = $f;
		}
		
		$j['list'] = $Products;
	#	$j['query'] = $sql;
		if (count($Products) > 0) return $j;
	#	return $j['query'];
		return false;
	}
}