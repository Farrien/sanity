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
	$fAct = $_GET['act'];
	if (isset($fAct)) {
		if ($fAct == 'managers') {
			$PageTitle = 'Управление менеджерами';
			$OutputContent = 'admin-manager-control';
		} elseif ($fAct == 'workers') {
			$PageTitle = 'Управление исполнителями';
			$OutputContent = 'admin-worker-control';
		} elseif ($fAct == 'stocks') {
			$PageTitle = 'Мини-бухгалтерия';
			$OutputContent = 'admin-stocks';
		} elseif ($fAct == 'performers') {
			$PageTitle = 'Анкеты исполнителей';
			$OutputContent = 'admin-performers';
			$q = $pdo_db->query('SELECT * FROM `#custom_table_performers_requests` ORDER BY performer_name, performer_phone');
			while ($f = $q->fetch(2)) {
				$performerFormList[] = $f;
			}
		} else {
			$SN->AddErr();
			$SN->ExplaneLastError('Нет такой страницы');
		}
	} else {
		$managerTasks = [];
		$sql = 'SELECT id, login, name, (SELECT COUNT(*) FROM hookups_managers WHERE person_b=p.id AND closed=0) AS tasksCount FROM people p WHERE permissionGroup=1 ORDER BY tasksCount DESC';
		$q = $pdo_db->query($sql);
		while ($f = $q->fetch(2)) {
			if ($f['tasksCount'] == 0) $f['flag1'] = 'empty';
			$managerTasks[] = $f;
		}
	}
}