<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

if (!$perm) RedirectToHome();

$PageTitle = 'Мои заказы';

$q = $pdo_db->prepare('SELECT id FROM shop_orders WHERE client_id=?');
$q->execute([$USER['id']]);
$f = (bool) $q->fetch(2);
$hasOrders = $f;

# Выполняемые задания
$myOrders = [];
if ($hasOrders) {
	$sql = 'SELECT o.added_time, ps.count, COUNT(ps.count) AS goods_count, SUM(p.cost*ps.count) AS cost_sum
		FROM shop_order_product_dependency AS ps
		INNER JOIN shop_orders AS o ON ps.order_id = o.id
		INNER JOIN shop_goods AS p ON ps.product_id = p.id
		GROUP BY o.id';
	$q = $pdo_db->prepare($sql);
	$q->execute([$USER['id']]);
	while ($f = $q->fetch(2)) {
		$f['added_time'] = prettyTime($f['added_time']);
		$myOrders[] = $f;
	}
}