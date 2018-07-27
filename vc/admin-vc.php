<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

$PageTitle = 'Панель администратора';

$OutputContent = '';
if (empty($USER['id']) || empty($USER['privileges'])) {
	$SN->AddErr();
	$SN->ExplaneLastError('Не авторизован');
}
if ($USER['privileges'] != 2) {
	$SN->AddErr();
	$SN->ExplaneLastError('Недостаточно прав для доступа к этой странице');
}

if (!$SN->GetErrors()) {
	$OutputContent = 'admin-main-panel';
	$fAct = prepareString($_GET['act']);
	if (isset($fAct)) {
		if ($fAct == 'products') {
			$PageTitle = 'Товары';
			$OutputContent = 'admin-products';
			$Products = [];
			$q = $pdo_db->query('SELECT *, (SELECT subject_name FROM subjects WHERE id=category_id) AS category_name FROM shop_goods ORDER BY product_name');
			while ($f = $q->fetch(2)) {
				if ($f['cover_image'] == '') {
					$f['cover_image'] = 'ui/no-photo.png';
				} else {
					$f['cover_image'] = 'shop/' . $f['cover_image'];
				}
				if ($f['quantity'] < 1) {
					$f['quantity'] = 'Нет в наличии';
				}
				$Products[] = $f;
			}
		} elseif ($fAct == 'editproduct') {
			$PageTitle = 'Изменение товара';
			$OutputContent = 'admin-product-edit';
			
			
			$productID = (int) $_GET['id'];
			$q = $pdo_db->prepare('SELECT *, (SELECT subject_name FROM subjects WHERE id=category_id) AS category_name FROM shop_goods WHERE id=?');
			$q->execute(array($productID));
			$Product = $q->fetch(2);
			
			$Categories = [];
			$q = $pdo_db->query('SELECT * FROM subjects ORDER BY parent_subject ASC, subject_name DESC');
			while ($f = $q->fetch(2)) {
				$Categories[] = $f;
			}
		} else {
			$SN->AddErr();
			$SN->ExplaneLastError('Нет такой страницы');
		}
	} else {
	}
}