<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');
if (empty($USER['id'])) die('Access denied.');
if (empty($USER['privileges']) || $USER['privileges']!=3) die('Access denied.');

$PageTitle = 'Кабинет проверяющего'; # also used as page title

$sql = "SELECT id, topic, person_a, person_b, (SELECT name FROM people WHERE id=person_b) AS manager_name FROM hookups_managers WHERE inspector_id=? AND closed=0 ORDER BY added_time";
$o1 = $pdo_db->prepare($sql);
$o1->execute(array($USER['id']));

if (isset($_GET['hook'])) {
	$hookup_id = intval($_GET['hook']);
	$showChat = true;
	$sql = "SELECT COUNT(*) FROM hookups_managers WHERE id=? AND inspector_id=?";
	$o2 = $pdo_db->prepare($sql);
	$o2->execute(array($hookup_id, $USER['id']));
	
	$f2 = $o2->fetchColumn();
	if ($f2 == 1) {
		$showChat = true;
		$sql = "SELECT id, person_a, person_b, (SELECT name FROM people WHERE id=person_b) AS manager_name, topic FROM hookups_managers WHERE id={$hookup_id} AND closed=0";
		$o3 = $pdo_db->query($sql);
		$f3 = $o3->fetch(PDO::FETCH_ASSOC);
	} else {
		$showChat = false;
	}
}
?>
<script type="text/javascript">
	var _cLocation = 'inspector_panel';
	var _mon = {};
	_mon.Manager = {
		settings : {
			hook : <?=$hookup_id?>,
			key : '<?=hash_hmac('md5', $f3['person_a'] . '-' . $hookup_id, 'SweetHarmony')?>',
			yourInspector : <?=$f3['person_b'] ?: 0?>,
		}
	}
	
	var utiTime = <?=$globalTime?>;
</script>
<script type="text/javascript" src="../client/manager-helper.js"></script>
<div class="primary">
	<div class="clearFix">
		<?if ($showChatWindow) {?>
		<div class="floatContainer darkBackSkin _rounded">
			<div class="fl bs60 sidePads">
				<?if ($showChat) {?>
				<div class="sectionName _bottomSpace">
					<div class="h2">Чат с Менеджером <?=$f3['manager_name']?></div>
				</div>
				<div id="ChatWithInspector" class="ChatPositionWindow">
					<div class="ChatWindow">
						<div id="ChatBodyInspector" class="ChatBody">
							
						</div>
					</div>
					<div class="littleSpace">
						<div class="TextareaFullForm">
							<textarea class="xver adaptScreen messageTextarea" name="msg" rows="5"></textarea>
							<div class="_s2">
								<button class="xver" onclick="return UfaEyesInterface.sendMessageTo('inspector');">Отправить</button>
							</div>
						</div>
					</div>
				</div>
				<?} else {?>
				<div class="alignCenterText">
					Выберите задание, чтобы начать чат с менеджером.
				</div>
				<?}?>
			</div>
			<div class="fl bs40 sidePads">
				<div class="sectionName _bottomSpace">
					<div class="h2">Выполняемые задания</div>
				</div>
				<div class="SwitchButtonsBox">
					<?while ($f1 = $o1->fetch(PDO::FETCH_ASSOC)) {
					$manager = $f1['manager_name'] ?: 'Не назначен';
					?>
					<div class="OneBox<?if($hookup_id == $f1['id']) echo ' selected';?>">
						<a href="?hook=<?=$f1['id']?>">
							<div class="proposalName"><b>Заявка №<?=$f1['id']?></b> <?=$f1['topic']?></div>
							<div class="proposalContacts">Менеджер: <?=$manager?></div>
						</a>
					</div>
					<?}?>
				</div>
			</div>
		</div>
		<?}?>
		<div class="floatContainer">
			<div class="fl bs50 nicePads">
				<div class="sectionName _bottomSpace">
					<div class="h2">Список тематик</div>
				</div>
				<div class="ContentOverlay">
					<?$sql = 'SELECT id, subject_name FROM subjects ORDER BY subject_name';
					$sql = "SELECT id, subject_name FROM subjects WHERE id NOT IN (SELECT subject_id AS id FROM subjects_dependency WHERE owner_id=? AND active=1) ORDER BY subject_name";
					$o1 = $pdo_db->prepare($sql);
					$o1->execute(array($USER['id']));
					$icount = 1;
					while ($f1 = $o1->fetch(PDO::FETCH_ASSOC)) {?>
					<div class="proposalLineContainer">
						<div class="proposalInspectorReward _y" style="min-width: 42px; width: 42px;"><?=$icount?></div>
						<div class="proposalName" style="width:100%;"><?=$f1['subject_name']?></div>
						<div class="manageButtons" style="width: auto;">
							<button class="xsimple" onclick="UfaEyesInterface.TurnSubjectActivity(<?=$f1['id']?>, this, true);">Включить</button>
						</div>
					</div>
					<?$icount++;
					}?>
				</div>
			</div>
			<div class="fl bs50 nicePads">
				<div class="sectionName _bottomSpace">
					<div class="h2">Выбранные тематики</div>
				</div>
				<div class="ContentOverlay">
					<?$sql = "SELECT id, subject_id, (SELECT subject_name FROM subjects WHERE id=subject_id) AS subject_name FROM subjects_dependency WHERE owner_id=? AND active=1 ORDER BY subject_name";
					$o1 = $pdo_db->prepare($sql);
					$o1->execute(array($USER['id']));
					$icount = 0;
					while ($f1 = $o1->fetch(PDO::FETCH_ASSOC)) {
					$icount++;?>
					<div class="proposalLineContainer">
						<div class="proposalInspectorReward _y" style="min-width: 42px; width: 42px;"><?=$icount?></div>
						<div class="proposalName" style="width:100%;"><?=$f1['subject_name']?></div>
						<div class="manageButtons" style="width: auto;">
							<button class="xsimple" onclick="UfaEyesInterface.TurnSubjectActivity(<?=$f1['subject_id']?>, this, false);">Исключить</button>
						</div>
					</div>
					<?}?>
				</div>
			</div>
		</div>
		<div class="floatContainer">
			<div class="fl bs100">
				<div class="sectionName _bottomSpace">
					<div class="h2">Список заданий на проверку <span class="ui-helper-text" onmouseover="UEI.ShowTooltip('Вам показываются заявки по выбранным тематикам.', this);" onmouseout="UEI.DestroyTooltips();">?</span></div>
				</div>
				<div class="ContentOverlay forProposals">
					<div class="proposalLineContainer asHeader">
						<div class="proposalInspectorReward">Награда</div>
						<div class="proposalName _options" style="min-width: 200px;">Категория</div>
						<div class="proposalName _options" style="min-width: 180px;">Менеджер</div>
						<div class="proposalName" style="width: 100%;">Описание заявки</div>
						
					</div>
					<?$sql = 'SELECT t1.id, t1.hookup_id, t2.topic, t1.reward, (SELECT subject_name FROM subjects WHERE id=t1.subject_id) AS subject_name, (SELECT name FROM people WHERE id=t2.person_b) AS manager_name FROM inspector_quests t1, hookups_managers t2 WHERE (t1.inspector_id IS NULL OR t1.inspector_id=0) AND t2.id=t1.hookup_id AND t1.subject_id IN (SELECT subject_id FROM subjects_dependency WHERE owner_id=? AND active=1)';
					$o4 = $pdo_db->prepare($sql);
					$o4->execute(array(
						$USER['id']
					));
					while ($f4 = $o4->fetch(2)) {
					$manager = $f1['manager_name'] ? : 'Нет';
					#var_dump($f4);
					?>
					<div class="proposalLineContainer">
						<div class="proposalInspectorReward"><?=$f4['reward']?> ₽</div>
						<div class="proposalName _options" style="min-width: 200px;"><?=$f4['subject_name']?></div>
						<div class="proposalName _options" style="min-width: 180px;"><?=$f4['manager_name']?></div>
						<div class="proposalName" style="width: 100%;"><?=$f4['topic']?></div>
						<div class="manageButtons" style="width: auto;">
							<button class="xsimple" onclick="UfaEyesInterface.Inspector.chooseQuest(<?=$f4['id']?>);">Взять задание</button>
						</div>
					</div>
					<?}?>
				</div>
			</div>
		</div>
		<div class="floatContainer">
			<div class="fl bs50 nicePads">
				<div class="sectionName _bottomSpace">
					<div class="h2">Вывод средств</div>
				</div>
				<div class="ContentOverlay">
				</div>
			</div>
			<div class="fl bs50 nicePads">
				<div class="sectionName _bottomSpace">
					<div class="h2">Исполненные запросы</div>
				</div>
				<div class="ContentOverlay">
					<div class="proposalLineContainer asHeader">
						<div class="proposalInspectorReward">Завершено</div>
						<div class="proposalName">Описание заявки</div>
					</div>
					<?
					$sql = "SELECT id, topic, complete_date FROM hookups_managers WHERE inspector_id=? AND closed=1 ORDER BY added_time";
					$o1 = $pdo_db->prepare($sql);
					$o1->execute(array($USER['id']));
					while ($f1 = $o1->fetch(PDO::FETCH_ASSOC)) {?>
					<div class="proposalLineContainer">
						<div class="proposalInspectorReward _y"><?=prettyTime($f1['complete_date'])?></div>
						<div class="proposalName"><?=$f1['topic']?></div>
					</div>
					<?}?>
				</div>
			</div>
		</div>
	</div>
</div>