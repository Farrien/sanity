<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

use Helper\Tasks\Tasks;

$PageTitle = 'Кабинет менеджера';

# show chat if manager has any open hookups only
$showChatWindow = false;

$hookup_id = 0;
if (isset($_GET['hook'])) {
	$hookup_id = (int) $_GET['hook'];
	$sql = "SELECT id, person_a, person_b, worker_id, inspector_id, (SELECT name FROM people WHERE id=worker_id) AS worker_name, (SELECT name FROM people WHERE id=person_a) AS client_name, (SELECT login FROM people WHERE id=person_a) AS client_tel, (SELECT name FROM people WHERE id=inspector_id) AS inspector_name, (SELECT name FROM people WHERE id=person_b) AS manager_name, topic, added_time FROM hookups_managers WHERE id=?";
	$o1 = $pdo_db->prepare($sql);
	$o1->execute(array($hookup_id));
	$f1 = $o1->fetch(PDO::FETCH_ASSOC);
	$showChatWindow = true;
}

if ($hookup_id && !Tasks::TaskExists($hookup_id)) {
	$SN->AddErr();
	$SN->ExplaneLastError('Задание удалено или еще не создано.');
}

$WorkerIsPresent = $f1['worker_id'] ? true : false;
$InspectorIsPresent = $f1['inspector_id'] ? true : false;

if (!$InspectorIsPresent) {
	$sql = 'SELECT * FROM inspector_quests WHERE hookup_id=? AND closed=0'; #AND inspector_id=NULL
	$q = $pdo_db->prepare($sql);
	$q->execute(array(
		$hookup_id
	));
	$InspectorsQuestData = $q->fetch(2);
	$InspectorsQuestIsPresent = $InspectorsQuestData ? true : false;
}

$CategoriesList = [];
$q = $pdo_db->query('SELECT id, subject_name FROM subjects ORDER BY subject_name');
while ($f = $q->fetch(2)) {
	$CategoriesList[$f['id']] = $f['subject_name'];
}
$q = NULL;