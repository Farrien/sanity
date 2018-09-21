<?php

$PageTitle = $lang['#page_title_catalog'];

require_once 'public/includes/shop.use.php';

$q = $pdo_db->query('SELECT * FROM subjects');
$raw = [];
while($item = $q->fetch(2)) {
	$item['subitems'] = [];
	$raw[$item['id']] = $item;
}

$CategoriesTree = [];
foreach($raw as $id=>&$item) {
	if (array_key_exists($item['parent_subject'], $raw)) $raw[$item['parent_subject']]['subitems'][$id] = &$item;
	else $CategoriesTree[$id] = &$item;
}

$q = $pdo_db->query('SELECT * FROM shop_goods ORDER BY added_time ASC, product_name ASC LIMIT ' . SHOP_MAX_SHOWN_ITEMS_PAGINATION);
$Products = [];
while ($f = $q->fetch(2)) {
	$f['cover_image'] = ($f['cover_image'] == '') ? 'ui/no-photo-big.png' : 'shop/' . $f['cover_image'];
	
	$f['unavailable'] = ($f['quantity'] < 1) ? true : false;
	
	$Products[] = $f;
}