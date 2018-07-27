<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');
$PageTitle = 'Добро Пожаловать';
?>
<!DOCTYPE html>
<html lang="<?=SITE_LANG?>">
<head>
	<?include STANDARD_HEADER_LAYER?>
	<link rel="stylesheet" type="text/css" href="//<?=$_SERVER['HTTP_HOST']?>/client/index-promo.css" media="all">

	<script type="text/javascript">
		var _cLocation = 'main';
		var _cFlag = 'unauth';
		var utiTime = <?=$globalTime?>;
	</script>
</head>
<body style="background-color: #fff;">
	<div>
		<div>
			<div class="contentSpace">
				<div class="primary clearFix">

				<!-- Index -->
					<div>
						<div class="WrapHelper">
							<div class="HeaderMenuUl">
								<ul class="items-list">
									<li><a href="https://vk.com/ufaeyesufa"><img src="../res/ui/ui-icons-social-vk.png"></a></li>
									<li><a href=""><img src="../res/ui/ui-icons-social-okru.png"></a></li>
									<li><a href="/pages/?id=1">О сайте</a></li>
									<li><a href="/login/?ownp=origin">Войти</a></li>
								</ul>
							</div>
							<div class="ui-promo-page-phones">
								<a href="tel:+79631437644">+7 (963) 143-76-44</a>
								<a href="tel:+79625300259">+7 (962) 530-02-59</a>
							</div>
							<div class="promo-hat">
								<div class="rowLogo">
									<a href="/?ownp=origin"><div class="tempLogo muchBigger"></div></a>
								</div>
								<div class="_helpit">
									<div class="promo-text-01">Сервис подбора исполнителя</div>
									<div class="promo-text-02">У нас Вы найдете надежного исполнителя для любых задач</div>
								</div>
							</div>
							<div class="promo-form-steps">
								<div class="form_steps_item si1">
									<span><strong>Создайте задание</strong><br>Напишите, что Вам нужно сделать.</span>
								</div>
								<div class="form_steps_item si3">
									<span><strong>Дождитесь менеджера</strong><br>Он позаботится <nobr>о поиске</nobr> исполнителя <nobr>за Вас.</nobr></span>
								</div>
								<div class="form_steps_item si2">
									<span><strong>Посмотрите предложения</strong><br>Выберите подходящего исполнителя.</span>
								</div>
								<div class="form_steps_item si4">
									<span><strong>Получите результат</strong><br>Проверенный исполнитель выполнит Ваше задание.</span>
								</div>
							</div>
						</div>
						
						<div class="promo-zapros-creator">
								<div class="WhitePaper fadeIn noShadow Absolution" style="display: none" id="TaskCompleteNotification">
									<div class="">
										<div class="HeaderChecked">
											Ваша заявка была принята.
										</div>
									</div>
									<div class="LoadContainer">
									</div>
								</div>
							<div class="floatContainer" style="position: relative;">
								<div class="promo-page-form" id="TaskCreationForm">
									<div class="sectionName">
										<div class="h1" style="">Новое задание</div>
									</div>
									<div class="ChatPositionWindow" style="width: 100%;">
										<form id="mainPageMessenger" action="" method="POST">
											<div class="floatContainer">
												<div class="fl bs50 sidePads">
													<?if (!$userData) {?>
													<div class="promo-text-03 dek_only">Вы будете зарегистрированы по этому телефону.</div>
													<input class="xver adaptScreen ue_input" type="text" id="tel" name="tel" placeholder="Телефон" oninput="UEI.CheckLogin(this);" autocomplete="off">
													<div class="promo-text-03 mobile_only">Вы будете зарегистрированы по этому телефону.</div>
													<?} else {?>
													<input class="xver adaptScreen ue_input" type="text" placeholder="<?=$userData['login']?>" disabled>
													<input type="hidden" id="tel" name="tel" value="<?=$userData['login']?>">
													<?}?>
												</div>
												<div class="fl bs50">
													<?if (!$userData) {?>
													<div class="promo-text-03 dek_only">Имя для Вашего профиля.</div>
													<input class="xver adaptScreen ue_input" type="text" id="name" name="name" placeholder="Ваше имя">
													<div class="promo-text-03 mobile_only">Имя для Вашего профиля.</div>
													<?} else {?>
													<input class="xver adaptScreen ue_input" type="text" placeholder="<?=$userData['name']?>" disabled>
													<input type="hidden" id="name" name="name" value="<?=$userData['name']?>">
													<?}?>
												</div>
											</div>
											<div class="littleSpace">
												<input class="xver adaptScreen ue_input" type="text" id="zapros" name="zapros" placeholder="В какой области Вам нужна помощь">
											</div>
											<div class="littleSpace">
												<div class="TextareaFullForm">
													<textarea class="xver adaptScreen messageTextarea" name="msg" rows="5" placeholder="Попробуйте как можно детальнее описать то, что Вам нужно." id="messageText"></textarea>
													<div class="_s2 darker">
														<button class="xver" onclick="return UfaEyesInterface.startChat(); return false;">Создать задание</button>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="promo-box-01">
								<a class="promo-a-link" href="/login/?ownp=origin&act=signup">Регистрация</a>
								<a class="promo-a-link greyBlue with-icon" href="/performer-verification/">Стать исполнителем<span class="ui-icon hammer"></span></a>
							</div>
						</div>
						
						<div class="ui-promo-page-heads">Все категории услуг</div>
						
						<div class="ui-section-categories">
							<?$q = $pdo_db->query('SELECT * FROM subjects WHERE parent_subject IS NULL ORDER BY subject_name');
							while ($f = $q->fetch(2)) {?>
							<div class="ui-categories-item-body">
								<div class="ui-categories-item-main-header"><?=$f['subject_name']?></div>
								<div class="ui-categories-item-children">
									<?$q1 = $pdo_db->query('SELECT * FROM subjects WHERE parent_subject=' . $f['id'] . ' LIMIT 4');
									while ($f1 = $q1->fetch(2)) {?>
									<div class="ui-categories-item-child-item-name"><?=$f1['subject_name']?></div>
									<?}?>
								</div>
							</div>
							<?}?>
						</div>
						
						<?if (false) {?>
						<div>
							<div class="ui-ue-agila-list">
							<?$sql = 'SELECT worker_ad_title, COUNT(*) AS cnt, SUM(worker_cost) AS totalSum, ROUND(AVG(worker_cost), 1) AS average FROM workers_ads AS t2 WHERE worker_cost>0 GROUP BY worker_ad_title ORDER BY average ASC, cnt DESC LIMIT 6';
							$q = $pdo_db->query($sql);
							while ($f = $q->fetch(2)) {?>
								<div class="ui-ue-agila-block-outer-body">
									<div class="ui-ue-agila-block-average-cost-num">~<?=$f['average']?> <sup>руб</sup></div>
									<div class="ui-ue-agila-block-service-name"><?=$f['worker_ad_title']?></div>
								</div>
							<?}?>
							</div>
							<div class="" style="padding-bottom: 16pt;">
								<div class="ui-unique-rounded-btn">
									<div class="btn-body"></div>
								</div>
							</div>
						</div>
						<?}?>
						
						<div>
							<div class="ui-promo-page-heads">Отзывы</div>
							<div class="WrapHelper">
								<div class="ui-block-reviews">
									<?$o1 = $pdo_db->query('SELECT *, (SELECT name FROM people WHERE id=author_id) AS author_name FROM site_reviews WHERE module=0 ORDER BY added_time DESC LIMIT 3');
									while ($f1 = $o1->fetch(PDO::FETCH_ASSOC)) {?>
									<div class="ui-user-review-card">
										<div class="ui-user-review-avatar">
											<img src="../res/ui/depositphotos_119670044-stock-illustration-user-icon-man-profile-businessman-999.png" width="48">
										</div>
										<div class="ui-user-review-inner">
											<div class="ui-user-review-username"><?=$f1['author_name']?></div>
											<div class="ui-user-review-text"><?=$f1['review_message']?></div>
										</div>
									</div>
									<?}?>
								</div>
							</div>
						</div>
					</div>
				<!-- ~~~~~ -->
	
				</div>
			</div>

<?
include_once "./templates/{$TemplatesPath}/bottom-template.php";
?>
</body>
</html>