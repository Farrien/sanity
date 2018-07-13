<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

use Helper\Tasks\Tasks;
use Helper\Users\Users;

$userSettings = Users::getPrivateSettings($USER['id']);

$PageTitle = 'Личный кабинет';

# show chat if user has any open hookups only
$q = $pdo_db->prepare('SELECT id FROM hookups_managers WHERE closed=0 AND person_a=?');
$q->execute(array($USER['id']));
$f = (bool) $q->fetch(2);
$showChatWindow = $f;

# Выполняемые задания
$CurrentTasks = [];
if ($showChatWindow) {
	$sql = 'SELECT id, topic, person_a, person_b, (SELECT name FROM people WHERE id=person_b) AS manager_name, added_time FROM hookups_managers WHERE person_a=? AND closed=0 ORDER BY added_time';
	$q = $pdo_db->prepare($sql);
	$q->execute(array($USER['id']));
	$months_shorts = [
		'Янв',
		'Фев',
		'Март',
		'Апр',
		'Май',
		'Июн',
		'Июл',
		'Авг',
		'Сен',
		'Окт',
		'Ноя',
		'Дек'
	];
	while ($f = $q->fetch(2)) {
		$f['created_day'] = prettyTime($f['added_time'], 'd');
		$f['created_month'] = $months_shorts[prettyTime($f['added_time'], 'n') - 1];
		$CurrentTasks[] = $f;
	}
}

if (!$userSettings['view_options']['hide_completed_quests']) {
	# show block if manager has any closed hookups only
	$CompletedHookups = $pdo_db->prepare('SELECT id, person_b, topic, complete_date FROM hookups_managers WHERE closed=1 AND person_a=?');
	$CompletedHookups->execute(array(
		$USER['id']
	));
	$hasCompletedHookups = (bool) $CompletedHookups->fetch(2);

	# Завершенные задания
	$CompletedHookupsArray = [];
	if ($hasCompletedHookups) {
		$q = $pdo_db->prepare('SELECT t1.id, t1.person_b, t2.name, t2.login, t1.topic, t1.added_time, t1.complete_date FROM hookups_managers t1, people t2 WHERE t1.closed=1 AND t1.person_a=? AND t2.id=t1.person_b');
		$q->execute(array($USER['id']));
		while ($f1 = $q->fetch(2)) {
			$CompletedHookupsArray[] = $f1;
		}
	}
}


$hookup_id = false;
if (isset($_GET['hook'])) {
	$hookup_id = (int) $_GET['hook'];
}

if ($hookup_id && !Tasks::TaskExists($hookup_id)) {
	$SN->AddErr();
	$SN->ExplaneLastError('Задание удалено или еще не создано.');
}