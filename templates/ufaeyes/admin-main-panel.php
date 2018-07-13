<script type="text/javascript">
	var _cLocation = 'admin_panel';
</script>
<script type="text/javascript" src="../client/manager-helper.js"></script>
<div class="primary clearFix">
	<div class="clearFix">
		<div class="floatContainer">
			<div class="fl bs30 nicePads">
				<div class="sectionName _bottomSpace">
					<div class="h2 hold-abs">Менеджеры <a class="rightBoardButton" href="?act=managers">изменить</a></div>
				</div>
				<div class="ContentOverlay SiteStaffOverlay">
					<div class="SiteStaffList">
						<?$ql = $pdo_db->query('SELECT id, name, (SELECT COUNT(*) FROM hookups_managers WHERE person_b=p.id AND closed=0) AS tasksCount FROM people p WHERE permissionGroup=1');
						while ($fl = $ql->fetch(2)) {
						?>
						<div class="item">
							<div class="r StaffId"><?=$fl['id']?></div>
							<div class="r"><?=$fl['name']?></div>
						</div>
						<?}?>
					</div>
				</div>
			</div>
			<div class="fl bs30 nicePads">
				<div class="sectionName _bottomSpace">
					<div class="h2 hold-abs">Исполнители <a class="rightBoardButton" href="?act=workers">изменить</a></div>
				</div>
				<div class="ContentOverlay SiteStaffOverlay">
					<div class="SiteStaffList">
						<?$ql = $pdo_db->query('SELECT id, name, (SELECT COUNT(*) FROM hookups_managers WHERE worker_id=p.id AND closed=0) AS tasksCount FROM people p WHERE permissionGroup=4');
						while ($fl = $ql->fetch(2)) {
						?>
						<div class="item clickable" onclick="UfaEyesInterface.showWorkerInfoInAdminPanel(<?=$fl['id']?>)">
							<div class="r StaffId"><?=$fl['id']?></div>
							<div class="r"><?=$fl['name']?></div>
						</div>
						<?}?>
					</div>
				</div>
			</div>
			<div class="fl bs30 nicePads">
				<div class="sectionName _bottomSpace">
					<div class="h2">Проверяющие</div>
				</div>
				<div class="ContentOverlay SiteStaffOverlay">
					<div class="SiteStaffList">
						<?$ql = $pdo_db->query('SELECT id, name, (SELECT COUNT(*) FROM hookups_managers WHERE inspector_id=p.id AND closed=0) AS tasksCount FROM people p WHERE permissionGroup=3');
						while ($fl = $ql->fetch(2)) {
						?>
						<div class="item clickable" onclick="UfaEyesInterface.showInspectorInfoInAdminPanel(<?=$fl['id']?>)">
							<div class="r StaffId"><?=$fl['id']?></div>
							<div class="r"><?=$fl['name']?></div>
						</div>
						<?}?>
					</div>
				</div>
			</div>
		</div>
		<div class="floatContainer" id="workerCardContainer" style="display: none;">
			<div class="fl bs100 nicePads">
				<div class="sectionName _bottomSpace">
					<div class="h4">Карточка исполнителя</div>
				</div>
				<div class="ContentOverlay">
					<div class="BlockContainerHeader">
						<div id="" class="__name Name">Имя</div>
					</div>
					<div class="floatContainer" style="padding: 8pt;">
						<div class="fl bs30 sidePads">
							<div>
								<div style="font-size: 14px;">Телефон:</div>
								<div class="__ph" style="font-size: 16px; padding-right: 16pt;">-</div>
							</div>
							<div>
								<div style="font-size: 14px;">Компания:</div>
								<div class="__comp" style="font-size: 16px; padding-right: 16pt;">-</div>
							</div>
						</div>
						<div class="fl bs30 sidePads">
							<div class="__subs_list Tagging clearFix">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="floatContainer" id="inspectorCardContainer" style="display: none;">
			<div class="fl bs100 nicePads">
				<div class="sectionName _bottomSpace">
					<div class="h4">Карточка проверяющего</div>
				</div>
				<div class="ContentOverlay">
					<div class="BlockContainerHeader">
						<div class="__name Name">Имя</div>
					</div>
					<div class="floatContainer" style="padding: 8pt;">
						<div class="fl bs30 sidePads">
							<div>
								<div style="font-size: 14px;">Телефон:</div>
								<div class="__ph" style="font-size: 16px; padding-right: 16pt;">-</div>
							</div>
							<div>
								<div style="font-size: 14px;">Баланс:</div>
								<div class="__comp" style="font-size: 16px; padding-right: 16pt;">-</div>
							</div>
						</div>
						<div class="fl bs30 sidePads">
							<div class="__currentTasksList clearFix">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="floatContainer">
			<div class="fl bs100 nicePads">
				<div class="sectionName _bottomSpace">
					<div class="h2">Новые заявки <span class="ui-helper-text" onmouseover="UEI.ShowTooltip('Это те заявки, которые еще не обработаны менеджерами.', this);" onmouseout="UEI.DestroyTooltips();">?</span></div>
				</div>
				<div class="ContentOverlay">
					<div class="proposalLineContainer asHeader">
						<div class="proposalInspectorReward _date">Создано</div>
						<div class="proposalName" style="flex: 4;">Описание заявки</div>
						<div class="proposalName" style="flex: 1;">Заказчик</div>
						<div class="proposalName" style="flex: 1;"></div>
					</div>
					<?
					$sql = "SELECT id, topic, added_time, (SELECT name FROM people WHERE id=person_a) as client_name FROM hookups_managers WHERE person_b=0 AND closed=0 ORDER BY added_time DESC";
					$o1 = $pdo_db->prepare($sql);
					$o1->execute(array($USER['id']));
					while ($f1 = $o1->fetch(PDO::FETCH_ASSOC)) {?>
					<div class="proposalLineContainer">
						<div class="proposalInspectorReward _y _date"><?=prettyTime($f1['added_time'], 'H:i d.m.y')?></div>
						<div class="proposalName" style="flex: 4;"><?=$f1['topic']?></div>
						<div class="proposalName" style="flex: 1;"><?=$f1['client_name']?></div>
						<div class="manageButtons" style="flex: 1;">
							<button class="xsimple" onclick="UfaEyesInterface.showTaskInfo(<?=$f1['id']?>);">Посмотреть заявку</button>
						</div>
					</div>
					<?}?>
				</div>
			</div>
		</div>
		<div class="floatContainer">
			<div class="fl bs50 nicePads">
				<div class="sectionName _bottomSpace">
					<div class="h2">Статистика и заявки менеджеров</div>
				</div>
				<div class="ContentOverlay nicePads" style="height: 400px;">
					<?foreach ($managerTasks as $v) {?>
					<div class="Spoiler inList">
						<div class="SpoilerHead">
							<div class="SpoilerIcon" style="background-image: url('../res/ui/no-photo-lighter-alt.png');"></div>
							<div class="SpoilerTitle">
								<div class="h1"><?=$v['name']?></div>
								<div class="h2"><?=$v['login']?></div>
							</div>
							<div class="ue-spoiler-taskcount <?=$v['flag1']?>"><?=$v['tasksCount']?></div>
						</div>
						<div class="hiddenRes">
							<?$sql = 'SELECT id, person_a, topic, (SELECT name FROM people WHERE id=person_a) AS name, (SELECT login FROM people WHERE id=person_a) AS tel FROM hookups_managers WHERE person_b=' . $v['id'] . ' AND closed=0 ORDER BY added_time';
							$o2 = $pdo_db->query($sql);
							if ($o2 && $o2->rowCount()) {?>
							<div class="TasksList">
								<?while ($f2 = $o2->fetch(PDO::FETCH_ASSOC)) {?>
								<div class="TaskInfoCard">
									<div class="TaskInfoOptions">
										<div class="InfoOptHeadline"><?=makeShort($f2['topic'], 30)?></div>
										<div class="InfoOptAdditional"><?=$f2['name']?><br><?=$f2['tel']?></div>
									</div>
									<div class="ButtonsList">
										<button class="whiteBlue" onclick="UfaEyesInterface.showTaskInfo(<?=$f2['id']?>);">Посмотреть</button>
									</div>
								</div>
								<?}?>
							</div>
							<?}?>
						</div>
					</div>
					<? } ?>
				</div>
			</div>
			<div class="fl bs50 nicePads">
				<div class="sectionName _bottomSpace">
					<div class="h2">Статистика Исполнителей</div>
				</div>
				<div class="ContentOverlay nicePads Solid" style="height: 400px;">
					<div class="FlexTable">
						<?$ql = $pdo_db->query('SELECT id, name, (SELECT COUNT(*) FROM hookups_managers WHERE worker_id=p.id AND closed=0) AS tasksCount, (SELECT COUNT(*) FROM hookups_managers WHERE worker_id=p.id AND closed=1) AS tasksCompleted FROM people p WHERE permissionGroup=4 ORDER BY tasksCompleted DESC, tasksCount DESC, name ASC');
						while ($fl = $ql->fetch(2)) {
							$fillerLength = 0;
							if ($fl['tasksCompleted']) $fillerLength = $fl['tasksCompleted'] / ($fl['tasksCount'] + $fl['tasksCompleted']) * 100;
						?>
						<div class="TableElem cellpadding">
							<div style="width: calc(100% - 100px);"><?=$fl['name']?></div>
							<div class="FillingLine">
								<div class="__filler" style="width: <?=$fillerLength?>%"></div>
								<div class="__leftValue"><?=$fl['tasksCompleted']?></div>
								<div class="__rightValue"><?=$fl['tasksCount']?></div>
							</div>
						</div>
						<?}?>
					</div>
				</div>
			</div>
		</div>
		<div class="floatContainer">
			<div class="fl bs100 nicePads">
				<div class="sectionName _bottomSpace">
					<div class="h2">Завершенные заявки <span class="ui-helper-text" onmouseover="UEI.ShowTooltip('Закрытые заявки.', this);" onmouseout="UEI.DestroyTooltips();">?</span></div>
				</div>
				<div class="ContentOverlay">
					<div class="proposalLineContainer asHeader">
						<div class="proposalInspectorReward _date">Завершено</div>
						<div class="proposalName _options">Заказчик</div>
						<div class="proposalName _options">Менеджер</div>
						<div class="proposalName _options">Исполнитель</div>
						<div class="proposalName _options _date">Создано</div>
						<div class="proposalName">Название заявки</div>
					</div>
					<?
					$sql = 'SELECT id, topic, added_time, complete_date, (SELECT name FROM people WHERE id=person_b) AS manager_name, (SELECT name FROM people WHERE id=person_a) AS client_name, (SELECT IFNULL(name, "wtf") FROM people WHERE id=worker_id) AS worker_name FROM hookups_managers WHERE closed=1 ORDER BY added_time DESC';
					$o1 = $pdo_db->prepare($sql);
					$o1->execute(array($USER['id']));
					while ($f1 = $o1->fetch(PDO::FETCH_ASSOC)) {
						$f1['manager_name'] = $f1['manager_name'] ?: '...';
						$f1['worker_name'] = $f1['worker_name'] ?: '...';?>
					<div class="proposalLineContainer">
						<div class="proposalInspectorReward _y _date"><?=prettyTime($f1['complete_date'], 'H:i d.m.y')?></div>
						<div class="proposalName _options"><?=$f1['client_name']?></div>
						<div class="proposalName _options"><?=$f1['manager_name']?></div>
						<div class="proposalName _options"><?=$f1['worker_name']?></div>
						<div class="proposalName _options _nums _date"><?=prettyTime($f1['added_time'], 'H:i d.m.y')?></div>
						<div class="proposalName"><?=$f1['topic']?></div>
					</div>
					<?}?>
				</div>
			</div>
		</div>
		<?if (false) {?>
		<div class="floatContainer">
			<div class="fl bs50 nicePads">
				<div class="sectionName _bottomSpace">
					<div class="h2">Все заявки</div>
				</div>
				<div class="ContentOverlay Solid" style="height: 400px;">
					<?$sql = "SELECT id, person_a, topic, (SELECT name FROM people WHERE id=person_a) AS name, (SELECT login FROM people WHERE id=person_a) AS tel FROM hookups_managers WHERE closed=0 ORDER BY added_time DESC";
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
						</div>
					</div>
					<? } ?>
				</div>
			</div>
			<div class="fl bs50 nicePads">
			</div>
		</div>
		<?}?>
	</div>
</div>