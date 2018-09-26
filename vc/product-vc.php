<?php

use SN\Management as SN;
use Helper\Users;

if ($request->hasAugments()) {
	$augs = $request->augments();
	$_GET['id'] = $augs->{0};
}

$productID = (int) $_GET['id'];
$q = DB::PDO()->prepare('SELECT product_name, quantity, category_id, cost, cover_image, added_time FROM shop_goods WHERE id=?');
$q->execute(array($productID));
$Product = $q->fetch(2);

if ($Product) {
	$PageTitle = $lang['#page_title_shop_product_prefix'] . $Product['product_name'];
	
	if ($Product['cover_image'] === '') {
		$Product['cover_image'] = 'ui/no-photo-big-alt.png';
	} else {
		$Product['cover_image'] = 'shop/' . $Product['cover_image'];
	}
	
	$Breadcrumb = [];
	buildCategoryBreadCrumb($Product['category_id'], $Breadcrumb);
	
	if (SHOP_SHOW_RELATED_PRODUCTS) {
		$RelatedProducts = [];
		$q = DB::PDO()->query('SELECT id, product_name, cost, cover_image FROM shop_goods WHERE id!=' . $productID . ' ORDER BY RAND() LIMIT 4');
		while ($f = $q->fetch(2)) {
			if ($f['cover_image'] === '') {
				$f['cover_image'] = 'ui/no-photo-big-alt.png';
			} else {
				$f['cover_image'] = 'shop/' . $f['cover_image'];
			}
			$RelatedProducts[] = $f;
		}
	}
	
	$ProductDesc = [];
	$q = DB::PDO()->query('SELECT title, description FROM shop_product_description WHERE product_id=' . $productID);
	while ($f = $q->fetch(2)) {
		$f['description'] = nl2br(prepareString($f['description']));
		$ProductDesc[] = $f;
	}
	
	$Review = [];
	$q = DB::PDO()->query('SELECT owner_id, review, added_time FROM shop_product_reviews WHERE product_id=' . $productID);
	while ($f = $q->fetch(2)) {
		$f['description'] = nl2br(prepareString($f['review']));
		if (is_null($f['owner_id'])) {
			$f['reviewer'] = $lang['user_deleted'];
		} else {
			$f['reviewer'] = Helper\Users::getName($f['owner_id']);
		}
		$Review[] = $f;
	}
} else {
	SN::NewErr();
	SN::ExplainLast($lang['missing_product']);
}

function buildCategoryBreadCrumb($cat_id, &$arr) {
	$_fn = __FUNCTION__;
	if (!is_null($cat_id)) {
		$breadcrumb = [];
		$q = DB::PDO()->query('SELECT subject_name, parent_subject FROM subjects WHERE id=' . $cat_id);
		$f = $q->fetch(2);
		if ($f['parent_subject']) $_fn($f['parent_subject'], $arr);
		$arr[] = $f;
	}
	return false;
}