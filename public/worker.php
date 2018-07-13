<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');
if (empty($USER['id'])) die('Access denied.');
if (empty($USER['privileges']) || $USER['privileges']!=4) die('Access denied.');

$PageTitle = 'Кабинет исполнителя'; # also used as page title

$sql = "SELECT id, topic, person_a, person_b, (SELECT name FROM people WHERE id=person_b) AS manager_name FROM hookups_managers WHERE worker_id=? AND closed=0 ORDER BY added_time";
$o1 = $pdo_db->prepare($sql);
$o1->execute(array($USER['id']));

$hookup_id = 0;
$showChat = false;
$hash = 0;
$yourWorker = 0;
if (isset($_GET['hook'])) {
	$hookup_id = intval($_GET['hook']);
	$showChat = true;
	$sql = "SELECT COUNT(*) FROM hookups_managers WHERE id=? AND worker_id=?";
	$o2 = $pdo_db->prepare($sql);
	$o2->execute(array($hookup_id, $USER['id']));
	
	$f2 = $o2->fetchColumn();
	if ($f2 == 1) {
		$showChat = true;
		$sql = "SELECT id, person_a, person_b, (SELECT name FROM people WHERE id=person_b) AS manager_name, topic, closed FROM hookups_managers WHERE id={$hookup_id}";
		$o3 = $pdo_db->query($sql);
		$f3 = $o3->fetch(PDO::FETCH_ASSOC);
	} else {
		$showChat = false;
	}
	$hash = hash_hmac('md5', $f3['person_a'] . '-' . $hookup_id, 'SweetHarmony');
	$yourWorker = $f3['person_b'];
}
?>
<script type="text/javascript">
	var subjectsList = [<?$sql = 'SELECT subject_name FROM subjects ORDER BY subject_name ASC';
		$q = $pdo_db->query($sql);
		while ($f = $q->fetch(2)) {echo '\'' . $f['subject_name'] . '\',';}
		?>];
	var _cLocation = 'worker_panel';
	var _mon = {
		Worker : {
			settings : {
				hook : <?=$hookup_id?>,
				key : '<?=$hash?>',
				yourWorker : <?=$yourWorker?>, // actually this is manager id
			}
		}
	};
	_mon.Manager = {
		settings : {
			hook : <?=$hookup_id?>,
			key : '<?=$hash?>',
			yourWorker : <?=$yourWorker?>,
		}
	};
	
	var utiTime = <?=$globalTime?>;
</script>
<script type="text/javascript" src="../client/manager-helper.js"></script>
<div class="primary">
	<div>
		<div class="h1">Личный кабинет</div>
	</div>
	<div class="clearFix">
		<div class="floatContainer _borders _solid">
			<div class="fl bs60">
				<?if ($showChat) {?>
				<div class="sectionTitle">Чат с менеджером | <?=$f3['manager_name']?></div>
				<div id="ChatWithWorker" class="ChatPositionWindow">
					<div>
						<div class="ChatWindow _moreSpace">
							<div id="ChatBodyWorker" class="ChatBody">
								
							</div>
						</div>
						<div class="littleSpace">
							<div class="TextareaFullForm">
								<textarea class="xver adaptScreen messageTextarea" name="msg" rows="2"></textarea>
								<div class="_s2">
									<button class="xver" onclick="return UfaEyesInterface.sendMessageTo('worker');">Отправить</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?} else {?>
				<div class="alignCenterText" style="height: 517px;">
					Выберите задание, чтобы начать чат с менеджером.
				</div>
				<?}?>
			</div>
			<div class="fl bs40">
				<div class="sectionTitle">Выполняемые задания</div>
				<div class="SwitchButtonsBox ue_customized">
					<?while ($f1 = $o1->fetch(PDO::FETCH_ASSOC)) {
					?>
					<div class="OneBox<?if($hookup_id == $f1['id']) echo ' selected';?>">
						<a href="?hook=<?=$f1['id']?>">
							<div class=""><b>Заявка №<?=$f1['id']?></b></div>
							<div class="proposalName"><?=$f1['topic']?></div>
						</a>
					</div>
					<?}?>
				</div>
			</div>
		</div>
		<div class="floatContainer">
			<div class="fl bs50 nicePads">
				<div class="sectionName _bottomSpace">
					<div class="h2">Список тематик</div>
				</div>
				<div class="ContentOverlay">
					<?$sql = "SELECT id, subject_name FROM subjects ORDER BY subject_name";
					$sql = "SELECT id, subject_name FROM subjects WHERE id NOT IN (SELECT subject_id AS id FROM subjects_dependency WHERE owner_id=? AND active=1) ORDER BY subject_name";
					$o1 = $pdo_db->prepare($sql);
					$o1->execute(array($USER['id']));
					$icount = 1;
					while ($f1 = $o1->fetch(PDO::FETCH_ASSOC)) {?>
					<div class="proposalLineContainer">
						<div class="proposalInspectorReward _y" style="min-width: 42px; width: 42px;"><?=$icount?></div>
						<div class="proposalName" style="width:100%;"><?=$f1['subject_name']?></div>
						<div class="manageButtons" style="width: auto;">
							<button class="xsimple" onclick="UfaEyesInterface.TurnGategory(<?=$f1['id']?>, this, true);">Включить</button>
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
							<button class="xsimple" onclick="UfaEyesInterface.TurnGategory(<?=$f1['subject_id']?>, this, false);">Исключить</button>
						</div>
					</div>
					<?}?>
				</div>
			</div>
		</div>
		<div class="floatContainer">
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
					$sql = "SELECT id, topic, complete_date FROM hookups_managers WHERE worker_id=? AND closed=1 ORDER BY added_time";
					$o1 = $pdo_db->prepare($sql);
					$o1->execute(array($USER['id']));
					while ($f1 = $o1->fetch(PDO::FETCH_ASSOC)) {?>
					<div class="proposalLineContainer">
						<div class="proposalInspectorReward _y"><?=prettyTime($f1['complete_date'])?></div>
						<div class="proposalName"><?=$f1['topic']?></div>
					</div>
					<?}?>
				</div>
				<div class="littleSpace"></div>
				<div class="ContentOverlay">
					<div class="proposalLineContainer asHeader">
						<div class="proposalInspectorReward">Завершено</div>
						<div class="proposalName">Описание заявки</div>
					</div>
					<?
					$sql = "SELECT id, topic, complete_date FROM hookups_managers WHERE worker_id=? AND closed=1 ORDER BY added_time";
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
			<div class="fl bs50 nicePads">
				<div class="sectionName _bottomSpace">
					<div class="h2">Мои предложения</div>
				</div>
				<div class="ContentOverlay Solid" style="height: 408px;">
					<div class="fullLengthAds">
						<button class="xver adaptScreen" onclick="UfaEyesInterface.createNewWorkerAdForm();">Создать новое</button>
					</div>
					<?
					$sql = "SELECT id, worker_ad_desc, worker_cost, worker_ad_subject, (SELECT subject_name FROM subjects WHERE id=worker_ad_subject) AS subject_name FROM workers_ads WHERE worker_id=? ORDER BY added_time";
					$o1 = $pdo_db->prepare($sql);
					$o1->execute(array($USER['id']));
					while ($f1 = $o1->fetch(PDO::FETCH_ASSOC)) {?>
					<div class="fullLengthAds">
						<div class="AdCategory"><?=$f1['subject_name']?></div>
						<div class="clearFix">
							<div class="AdDescription"><?=makeShort($f1['worker_ad_desc'], 100)?></div>
							<div class="AdWorkerCost"><?=$f1['worker_cost']?> ₽/час</div>
						</div>
					</div>
					<?}?>
				</div>
			</div>
		</div>
	</div>
</div>