<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

$InspectorsTotalRewards = 0;
$ITR_forMonth = 0;
$ITR_forWeek = 0;
$ITR_forDay = 0;
$RewardsArray = [];
$ct = $_SERVER['REQUEST_TIME'];
$q = $pdo_db->query('SELECT id, reward, added_time FROM inspector_quests WHERE closed=0');
while ($f = $q->fetch(2)) {
	$InspectorsTotalRewards += $f['reward'];
	if (($ct - 86400) <= $f['added_time']) $ITR_forDay += $f['reward'];
	if (($ct - 604800) <= $f['added_time']) $ITR_forWeek += $f['reward'];
	if (($ct - 2628000) <= $f['added_time']) $ITR_forMonth += $f['reward'];
}
?>

<div class="h4">Потрачено на вознаграждение ревизоров</div>
<div>За все время - <?=$InspectorsTotalRewards?></div>
<div>За последний месяц - <?=$ITR_forMonth?></div>
<div>За последнюю неделю - <?=$ITR_forWeek?></div>
<div>За последний день - <?=$ITR_forDay?></div>