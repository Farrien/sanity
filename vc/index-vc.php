<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

$PageTitle = 'Главная';

$q = $pdo_db->query('SELECT * FROM subjects ORDER BY parent_subject');
$Categories = [];
/*
while ($f = $q->fetch(2)) {
	$Categories[] = $f;
}
*/

	$q = $pdo_db->query('SELECT * FROM subjects');
	$raw = array(); 
	while($item = $q->fetch(2)) {
		$item['subitems'] = array();
		$raw[$item['id']] = $item;
	}

	$CategoriesTree = array(); 
	foreach($raw as $id=>&$item) {
		if(array_key_exists($item['parent_subject'], $raw))
			$raw[$item['parent_subject']]['subitems'][$id] = &$item;
		else
			$CategoriesTree[$id] = &$item;
	}


function ShowCategories( &$tree, $sub = false ) {
	if ($sub) echo '<div class="shop-sidebar-items hidden">';
	else echo '<div class="shop-sidebar-items">';
	
	foreach($tree AS &$v) {
		echo '<div class="shop-sidebar-item">';
		echo '<div class="shop-sidebar-item-name" onclick="sn.shop.SelectCategory(' . $v['id'] . ');">' . $v['subject_name'] . '</div>';
		if(!empty($v['subitems'])) {
			echo '<div class="shop-sidebar-plus" onclick="sn.shop.toggleCatVisibility(this);">+</div>';
			ShowCategories($v['subitems'], true);
		}
		echo '</div>';
	}
	echo '</div>';
}

$q = $pdo_db->query('SELECT * FROM shop_goods ORDER BY added_time ASC, product_name ASC LIMIT ' . SHOP_MAX_SHOWN_ITEMS_PAGINATION);
$Products = [];
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