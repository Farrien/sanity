<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');
if (empty($USER['id'])) die('Access denied.');
if ($USER['privileges']!=0) die('Access denied.');

$PageTitle = 'Личный кабинет'; # also used as page title


$hookup_id = false;
if (isset($_GET['hook'])) $hookup_id = intval($_GET['hook']);
$showChat = $hookup_id ? true : false;
if ($showChat) {
	$sql = "SELECT COUNT(*) FROM hookups_managers WHERE id=? AND person_a=? AND closed=0";
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
}

use Helper\Wallet\Wallet;
use Helper\Users\Users;
use Helper\Tasks\Tasks;

if (!empty($USER['id']) && isset($USER['id'])) $userData = array(
	'login' => Users::getLogin($USER['id']),
	'name' => Users::getName($USER['id']),
);
?>
<script type="text/javascript">
	var _cLocation = 'client_panel';
	var _mon = {
		Client : {
			settings : {
				hook : <?=$hookup_id ?: 0?>,
				key : '<?=hash_hmac('md5', $f3['person_a'] . '-' . $hookup_id, 'SweetHarmony')?>',
				haha : '<?=hash_hmac('md5', '81234567890', 'SweetHarmony')?>',
			}
		}
	};
	var _iIde = <?=$USER['id']?>;
</script>
<script type="text/javascript" src="../client/client-helper.js"></script>
<div class="primary">
	<div class="clearFix">
		<?if ($showChatWindow) {?>
		<div class="floatContainer _borders _solid" style="position: relative;">
			<div class="fl bs70 <?if(!$showChat) echo 'deks_only'?>">
				<?if ($showChat) {?>
				<div class="sectionTitle">Чат с менеджером</div>
				<div id="ChatWithManager" class="ChatPositionWindow">
					<div>
						<div class="ChatWindow _moreSpace">
							<div id="ChatBody" class="ChatBody">
								
							</div>
						</div>
						<div class="littleSpace">
							<div class="TextareaFullForm">
								<textarea class="xver adaptScreen messageTextarea" name="msg" rows="2" onkeypress="return UfaEyesInterface.sendMessageForce();"></textarea>
								<div class="_s2 darker">
									<button class="xver" onclick="return UfaEyesInterface.sendMessage();">Отправить</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?} else {?>
				<div class="deks_only">
					<div class="alignCenterText" style="height: 517px;">Выберите задание, чтобы начать чат с менеджером.</div>
				</div>
				<?}?>
			</div>
			<div class="fl bs30">
				<div class="sectionTitle">Выполняемые задания</div>
				<div class="NotesBox">
					<?foreach ($CurrentTasks as $v) {?>
					<a href="?hook=<?=$v['id']?>" <?if ($hookup_id == $v['id']) echo 'onclick="return false;"';?>>
						<div class="Notes-New">
							<div class="Notes-Body">
								<div class="Notes-el-date">
									<div class="_d"><?=$v['created_day']?></div>
									<div class="_m"><?=$v['created_month']?></div>
								</div>
								<div class="Notes-Head">
									<div class="_title"><?=$v['topic']?></div>
									<div class="_desc">№<?=$v['id']?> / <?=time_elapsed('@' . $v['added_time'])?></div>
								</div>
							</div>
						</div>
					</a>
					<?}?>
				</div>
				<!--
				<div class="ui-sidebar-stucking">
					<button class="xver" onclick="location.href='/';">Создать задание</button>
				</div>
				-->
			</div>
		</div>
		<div class="delimitter-space"></div>
		<?}?>
		<div class="flexContainer _borders _solid">
			<div class="fl bs70" style="position: relative;">
				<div class="sectionTitle">Новое задание</div>
				<div class="WhitePaper noShadow" id="TaskCreationForm" style="margin: 0;">
					<div class="ChatPositionWindow _mainPage" style="width: 100%;">
						<form id="mainPageMessenger" action="" method="POST">
							<input type="hidden" id="tel" name="tel" value="<?=$userData['login']?>">
							<input type="hidden" id="name" name="name" value="<?=$userData['name']?>">
							<div class="littleSpace">
								<input class="xver adaptScreen ue_input" type="text" id="zapros" name="zapros" autocomplete="off" placeholder="В какой области нужна помощь">
							</div>
							<div class="littleSpace">
								<div class="TextareaFullForm">
									<textarea class="xver adaptScreen messageTextarea" name="msg" rows="5" placeholder="Попробуйте как можно детальнее описать то, что Вам нужно." id="messageText"></textarea>
									<div class="_s2 darker">
										<button class="xver" onclick="return UfaEyesInterface.startChat();">Создать задание</button>
									</div>
								</div>
							</div>
						</form>
						<div class="descriptionLabel">
							Нажимая «Создать задание», вы соглашаетесь с правилами сервиса «UfaEyes».
						</div>
						<div class="descriptionLabel">
							После создания задания, менеджер обработает ее и свяжется с Вами.
						</div>
					</div>
				</div>
				<div class="WhitePaper noShadow fadeIn stuckToParent" style="display: none" id="TaskCompleteNotification">
					<div class="HeaderCheckedBody">
						<div class="HeaderChecked">
							Ваша заявка была принята.
						</div>
					</div>
					<div class="LoadContainer">
					</div>
				</div>
			</div>
			<div class="fl bs30">
				<div class="sectionTitle">Ваша последняя заявка</div>
				<?if (!empty($USER['id']) && $USER['privileges'] == 0) {
				$o1 = $pdo_db->query('SELECT t1.id, t1.topic, t1.added_time, t1.complete_date, (SELECT msg_inner FROM messages WHERE receiver_hookup=t1.id ORDER BY added_time DESC LIMIT 1) AS lastMessageText FROM hookups_managers AS t1 WHERE t1.person_a=' . $USER['id'] . ' ORDER BY added_time DESC LIMIT 1');
				$f1 = $o1->fetch(PDO::FETCH_ASSOC);
				if ($f1) {
				$taskStatus = Tasks::getStatus($f1['id']);
				$i_taskStatus = Tasks::getStatusID($f1['id'])?>
				<div class="WhitePaper noShadow">
					<div class="VerticalSpace">
						<div class="ui-paper-sets-row">
							<div class="ui-paper-set-name"><b>Тема</b></div>
							<div class="ui-paper-set-options">
								<div class="ui-set-constant"><?=$f1['topic']?></div>
							</div>
						</div>
						<div class="ui-paper-sets-row">
							<div class="ui-paper-set-name"><b>Статус</b></div>
							<div class="ui-paper-set-options">
								<div class="ui-set-constant"><?=$taskStatus?></div>
							</div>
						</div>
						<div class="ui-paper-sets-row">
							<div class="ui-paper-set-name"><b>Последнее сообщение</b></div>
							<div class="ui-paper-set-options">
								<div class="ui-set-constant"><?=makeShort($f1['lastMessageText'])?></div>
							</div>
						</div>
						<div class="ui-paper-sets-row">
							<div class="ui-paper-set-name"><b>Создано</b></div>
							<div class="ui-paper-set-options">
								<div class="ui-set-constant"><?=time_elapsed('@' . $f1['added_time'])?></div>
							</div>
						</div>
						<?if ($i_taskStatus == 5) {?>
						<div class="ui-paper-sets-row">
							<div class="ui-paper-set-name"><b>Завершено</b></div>
							<div class="ui-paper-set-options">
								<div class="ui-set-constant"><?=time_elapsed('@' . $f1['complete_date'])?></div>
							</div>
						</div>
						<?}?>
					</div>
					<?if ($i_taskStatus != 5) {?>
					<div>
						<div class="littleSpace">
							<a href="?hook=<?=$f1['id']?>"><button class="xver outline">Перейти</button></a>
						</div>
					</div>
					<?}?>
				</div>
				<?}
				}?>
			</div>
		</div>
		<?if ($hasCompletedHookups) {?>
		<div class="delimitter-space"></div>
		<div class="floatContainer _borders _solid">
			<div class="fl bs100">
				<div class="sectionTitle">Завершенные задания</div>
				<div class="SwitchButtonsBox ue_customized noclick">
					<?foreach ($CompletedHookupsArray as $v) {
					?>
					<div class="OneBox">
						<div class="ui-ob-flex addPads">
							<div class="ui-ob-row-full"><div class="hookup_num"><?=$v['id']?></div> <?=$v['topic']?></div>
							<div class="ui-ob-row-full"><?=$v['name']?> (<?=$v['login']?>)</div>
							<div class="ui-ob-row-full">Создано <?=prettyTime($v['added_time'])?></div>
							<div class="ui-ob-row-full">Завершено <?=time_elapsed('@' . $v['complete_date'])?></div>
						</div>
					</div>
					<?}?>
				</div>
				<!--
				<div class="ui-sidebar-stucking">
					<button class="xver" onclick="location.href='/';">Создать задание</button>
				</div>
				-->
			</div>
		</div>
		<?}?>
	</div>
</div>