<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');
if (empty($USER['id'])) die('Access denied.');
if (empty($USER['privileges']) || $USER['privileges']!=1) die('Access denied.');



$url = '//' . $_SERVER['HTTP_HOST'] . '/panel/?';
if (isset($_GET['a'])) {
	$act = $_GET['a'];
	$url .= '&a=' . $_GET['a'];
}

$showChat = $hookup_id ?: false;
if ($showChat) {
	$sql = 'SELECT COUNT(*) FROM hookups_managers WHERE id=? AND person_b=?';
	$o2 = $pdo_db->prepare($sql);
	$o2->execute(array($hookup_id, $USER['id']));
	
	$f2 = $o2->fetchColumn();
	if ($f2 == 1) {
		$showChat = true;
		$sql = 'SELECT id, person_a, person_b, (SELECT name FROM people WHERE id=person_b) AS manager_name, topic, closed FROM hookups_managers WHERE id=' . $hookup_id;
		$o3 = $pdo_db->query($sql);
		$f3 = $o3->fetch(PDO::FETCH_ASSOC);
	} else {
		$showChat = false;
	}
}

$sort = $_REQUEST['sort'];
if ($sort !== null) {
	$sortNum = array(
		'0' => 'id',
		'1' => 'worker_cost',
		'2' => 'addedTime'
	);
	$sortStr = array(
		'0' => 'По умолчанию',
		'1' => 'По цене',
		'2' => 'По дате'
	);
	if ($sortNum[$sort] === null) $sort = null;
	$url .= '&sort=' . $sort;
}
$currentSort = $sortStr[$sort] ?: 'По умолчанию';

$order = $_REQUEST['order'];
if ($order !== null) {
	$orderNum = array(
		'0' => 'DESC',
		'1' => 'ASC'
	);
	$orderStr = array(
		'0' => 'По убыванию',
		'1' => 'По возрастанию'
	);
	if ($orderNum[$order] === null) $order = null;
}
$currentSortOrder = $orderStr[$order] ?: 'По возрастанию';
?>
<script type="text/javascript">
	var _cLocation = 'manager_panel';
	var _mon = {};
	_mon.Manager = {
		settings : {
			hook : <?=$hookup_id?>,
			yourClient : <?=$f1['person_a']?>,
			yourInspector : <?=$f1['inspector_id'] ?: 0?>,
			yourWorker : <?=$f1['worker_id'] ?: 0?>,
			reason : '<?=$f1['topic']?>',
			key : '<?=hash_hmac('md5', $f1['person_a'] . '-' . $hookup_id, 'SweetHarmony')?>'
		}
	};
	
	var utiTime = <?=$globalTime?>;
</script>
<script type="text/javascript" src="../client/manager-helper.js"></script>
<div class="primary clearFix">
	<? if ($act == 'overview_worker' || $act == 1) { ?>
	<div class="clearFix">
		<div class="floatContainer">
			<div class="fl bs40 nicePads">
				<div>
					<div class="DropdownMenu style2">
						<div class="Header"><?=$currentSort?></div>
						<div class="Variables select-hide">
							<div class="Vars"><a href="<?=$url?>&sort=0">По умолчанию</a></div>
							<div class="Vars"><a href="<?=$url?>&sort=1">По цене</a></div>
							<div class="Vars"><a href="<?=$url?>&sort=2">По дате</a></div>
						</div>
					</div>
				</div>
				<div>
					<div class="DropdownMenu style2">
						<div class="Header"><?=$currentSortOrder?></div>
						<div class="Variables select-hide">
							<div class="Vars"><a href="<?=$url?>&order=0">По убыванию</a></div>
							<div class="Vars"><a href="<?=$url?>&order=1">По возрастанию</a></div>
						</div>
					</div>
				</div>
			</div>
			<div class="fl bs60 nicePads">
				<div class="ContentOverlay Solid" style="height: calc(100vh - 113px);">
				<?$sql = 'SELECT * FROM subjects ORDER BY subject_name';
				$o1 = $pdo_db->query($sql);
				while ($f1 = $o1->fetch(PDO::FETCH_ASSOC)) {?>
					<div>
						<div>
							<div class="SubjectHeader"><?=$f1['subject_name']?></div>
						</div>
						<div>
							<?$sql = 'SELECT wa.id, worker_id, worker_ad_desc, worker_cost, name, login, wa.added_time AS addedTime FROM workers_ads wa LEFT JOIN people p ON worker_id=p.id WHERE worker_ad_subject=' . $f1['id'];
							if ($sort !== null && $sort != '') $sql .= ' ORDER BY ' . $sortNum[$sort];
							if ($order !== null && $order != '') $sql .= ' ' . $orderNum[$order];
							$o2 = $pdo_db->query($sql);
							while ($f2 = $o2->fetch(PDO::FETCH_ASSOC)) {?>
							<div class="fullLengthAds">
								<div class="AdCategory"><?=$f2['name']?> | <?=$f2['login']?></div>
								<div class="clearFix">
									<div class="AdDescription"><?=makeShort($f2['worker_ad_desc'])?></div>
									<div class="AdWorkerCost"><?=$f2['worker_cost']?>₽/час</div>
								</div>
							</div>
							<?}?>
						</div>
					</div>
				<?}?>
				</div>
			</div>
		</div>
	</div>
	<? } elseif ($act === null || $act == 0 || $act == '') { ?>
	<div class="clearFix">
		<?if ($showChatWindow) {?>
		<div class="darkBackSkin _rounded">
			<div class="floatContainer">
				<div class="fl bs33 sidePads">
					<div class="sectionName _bottomSpace">
						<div class="h3 managerChatPanels">Клиент &rarr; <?=$f1['client_name']?></div>
					</div>
					<div class="ChatPositionWindow" style="width: 100%;">
						<div>
							<div class="ChatWindow">
								<div id="ChatBodyClient" class="ChatBody">
									
								</div>
							</div>
							<div class="littleSpace">
								<div class="TextareaFullForm">
									<textarea class="xver adaptScreen messageTextarea" name="msg" rows="5" id="messageText" placeholder="Напишите сообщение..."></textarea>
									<div class="_s2">
										<button class="xver" onclick="return UfaEyesInterface.manSendChat();">Отправить</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="fl bs33 sidePads">
					<?if ($WorkerIsPresent) {?>
					<div class="sectionName _bottomSpace">
						<div class="h3 managerChatPanels">Исполнитель &rarr; <?=$f1['worker_name']?></div>
					</div>
					<div id="ChatWithWorker" class="ChatPositionWindow" style="width: 100%;">
						<div>
							<div class="ChatWindow">
								<div id="ChatBodyWorker" class="ChatBody">
									
								</div>
							</div>
							<div class="littleSpace">
								<div class="TextareaFullForm">
									<textarea class="xver adaptScreen messageTextarea" name="msg" rows="5" id="messageText" placeholder="Напишите сообщение..."></textarea>
									<div class="_s2">
										<button class="xver" onclick="return UfaEyesInterface.sendMessageTo('worker');">Отправить</button>
									</div>
								</div>
							</div>
						</div>
						<div class="littleSpace">
							<div class="ui-control-outlined-button" style="margin-top: 4px;" onclick="UfaEyesInterface.fireWorkerPlaceFromTask();">Убрать исполнителя</div>
						</div>
					</div>
					<?} else {?>
					<div class="ui-viol-sizing">
						<div class="_u-typo-headline">Исполнитель</div>
						<div class="_u-typo-first">Выберите специалиста, подходящего под запросы клиента.</div>
						<div class="_u-action-btn">
							<div class="ui-control-outlined-button" onclick="return UfaEyesInterface.chooseWorker();">Назначить исполнителя</div>
						</div>
					</div>
					<?}?>
				</div>
				<div class="fl bs33 sidePads">
					<?if ($InspectorIsPresent) {?>
					<div class="sectionName _bottomSpace">
						<div class="h3 managerChatPanels">Ревизор &rarr; <?=$f1['inspector_name']?></div>
					</div>
					<div id="ChatWithInspector" class="ChatPositionWindow" style="width: 100%;">
						<div>
							<div class="ChatWindow">
								<div id="ChatBodyInspector" class="ChatBody">
									
								</div>
							</div>
							<div class="littleSpace">
								<div class="TextareaFullForm">
									<textarea class="xver adaptScreen messageTextarea" name="msg" rows="5" id="messageText" placeholder="Напишите сообщение..."></textarea>
									<div class="_s2">
										<button class="xver" onclick="return UfaEyesInterface.sendMessageTo('inspector');">Отправить</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?} elseif ($InspectorsQuestIsPresent) {?>
					<div id="InspectorViolWindow" class="ui-viol-sizing">
						<div class="_u-typo-headline"><?=$InspectorsQuestData['reward']?>₽</div>
						<div class="_u-typo-first">Задание для ревизоров создано.<br>Ожидайте пока кто-нибудь не возьмется <nobr>за ее выполнение</nobr>.</div>
					</div>
					<?} else {?>
					<div id="InspectorViolWindow" class="ui-viol-sizing">
						<div class="_u-typo-headline">Ревизор</div>
						<div class="_u-typo-first">Если требуется проверка качества работы исполнителя, создайте задание для ревизоров, указав <nobr>награду и категорию</nobr>.</div>
						<div class="_u-action-btn">
							<div class="ui-control-outlined-button" onclick="mr.Dom('#InspectorViolWindow').Visibility(false); mr.Dom('#InspectorSettingReward').Object.style.display = 'flex';">Указать награду</div>
						</div>
					</div>
					<div id="InspectorSettingReward" class="ui-viol-sizing" style="display: none;">
						<div class="_u-typo-first">Ревизоры увидят это предложение в своем личном кабинете.</div>
						<form>
							<div class="littleSpace">
								<input class="xver ue_input" type="text" name="money" placeholder="Сумма">
							</div>
							<div class="littleSpace">
								<div class="SelectForm ue">
									<select name="subject">
										<option value="0">Категория</option>
										<?foreach ($CategoriesList as $id=>$category) {
										echo '<option value="' . $id . '">' . $category . '</option>';
										}?>
									</select>
								</div>
							</div>
							<input type="hidden" name="task_id" value="<?=$hookup_id?>">
						</form>
						<div class="_u-action-btn">
							<div class="ui-control-outlined-button" onclick="UfaEyesInterface.createInspectorReward();">Создать</div>
						</div>
					</div>
					<?}?>
				</div>
			</div>
		</div>
		<div class="ui-manager-chat-panel">
			<div class="ui-control-btn-box sms" onclick="return UfaEyesInterface.notifyPersonA(this);">
				<span>Оповестить по SMS</span>
			</div>
			<div class="ui-control-btn-box leave" onclick="return UfaEyesInterface.leaveTask();">
				<span>Покинуть</span>
			</div>
			<div class="ui-control-btn-box checked" onclick="return UfaEyesInterface.completeTask(<?=$hookup_id?>);">
				<span>Завершить заявку</span>
			</div>
		</div>
		<?}?>
		<div class="floatContainer _borders _solid">
			<div class="fl bs50">
				<div class="sectionTitle">Текущие заявки</div>
				<div class="SwitchButtonsBox ue_customized">
					<?$sql = "SELECT id, person_a, topic, added_time FROM hookups_managers WHERE person_b=? AND closed=0";
					$sql = "SELECT hooks.id, hooks.person_a, hooks.topic, hooks.added_time, p1.login, p1.name FROM hookups_managers AS hooks, people AS p1 WHERE p1.id=hooks.person_a AND hooks.person_b=? AND hooks.closed=0";
					$o2 = $pdo_db->prepare($sql);
					$o2->execute(array($USER['id']));
					while ($f2 = $o2->fetch(PDO::FETCH_ASSOC)) {
					?>
					<div class="OneBox<?if($hookup_id == $f2['id']) echo ' selected';?>">
						<a href="?hook=<?=$f2['id']?>">
							<div class=""><b>Заявка №<?=$f2['id']?></b></div>
							<div class="proposalName">Тел: <?=$f2['login']?> | Имя: <?=$f2['name']?></div>
							<div class="proposalName"><?=$f2['topic']?></div>
						</a>
					</div>
					<? } ?>
				</div>
			</div>
			<div class="fl bs50">
				<div class="sectionTitle">Ожидающие заявки</div>
				<div class="ContentOverlay Solid" style="height: 400px;">
					<?$sql = "SELECT id, person_a, topic, (SELECT name FROM people WHERE id=person_a) AS name, (SELECT login FROM people WHERE id=person_a) AS tel FROM hookups_managers WHERE person_b=0 AND closed=0 ORDER BY added_time";
					$o2 = $pdo_db->prepare($sql);
					$o2->execute(array($USER['id']));
					while ($f2 = $o2->fetch(PDO::FETCH_ASSOC)) {
					?>
					<div class="fullLengthAds">
						<div class="AdCategory">#<?=$f2['id']?> | Тел: <?=$f2['tel']?> | Имя: <?=$f2['name']?></div>
						<div class="clearFix">
							<div class="AdDescription"><?=makeShort($f2['topic'])?></div>
							<div class="AdWorkerCost">#<?=$f2['id']?></div>
						</div>
						<div class="ButtonsList">
							<div>
								<button class="xsimple" onclick="UfaEyesInterface.showTaskInfo(<?=$f2['id']?>);">Посмотреть заявку</button>
							</div>
							<div>
								<button class="xsimple" onclick="UfaEyesInterface.logIntoTask(<?=$f2['id']?>);">Взять заявку</button>
							</div>
						</div>
					</div>
					<? } ?>
				</div>
			</div>
		</div>
	</div>
	<? } ?>
</div>