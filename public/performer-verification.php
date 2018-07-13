<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');
?>
<div class="primary clearFix">
	<div class="ui-promo-section">
		<div class="ui-promo-section ui-sub-section">
			<div class="ui-sub-container main-promo">
				<div class="ui-promo-sub-super-headline"><?=SITE_NAME?></div>
				<div class="ui-promo-sub-headline">Приветствует специалистов</div>
				<div class="ui-image-promo-ufaeyes"></div>
				<div class="ui-promo-landing-action-btns">
					<div class="ui-form-btn" onclick="document.querySelector('#first-promo-elements').scrollIntoView();">Подробнее</div>
					<div class="ui-form-btn" onclick="document.querySelector('#PerformerFormContainer').scrollIntoView();">Заполнить анкету</div>
				</div>
			</div>
		</div>
		<div class="ui-promo-section ui-sub-section" id="first-promo-elements">
			<div class="ui-sub-container withBackgroundPicture" style="background-image: url('../res/ui/promos/fotolia_49905169_subscription_monthly_l.jpg');">
				<div class="ui-promo-sub-eyebrow">Почему <?=SITE_NAME?></div>
				<div class="ui-promo-sub-headtitle">Кредо нашей организации</div>
				<div class="ui-promo-sub-qt">Честность, порядочность, огромное желание помогать людям и максимальная прозрачность любых операций - это про нас.<br>Поэтому от наших будущих исполнителей мы ждем тоже самое.</div>
			</div>
			<div class="ui-sub-container">
				<div class="ui-promo-sub-headtitle">Как стать исполнителем?</div>
				<div class="ui-promo-sub-qt">Сперва Вам необходимо заполнить форму анкеты <nobr>на сайте</nobr>. Анкета обрабатывается в течении нескольких дней и с Вами связывается наш менеджер для уточнения деталей. Затем заключается договор.</div>
				<div class="ui-promo-landing-action-btns">
					<div class="ui-form-btn" onclick="document.querySelector('#PerformerFormContainer').scrollIntoView();">Перейти</div>
				</div>
			</div>
		</div>
		<div class="ui-promo-section ui-sub-section">
			<div class="ui-sub-container withBackgroundPicture FullLeftOrHalfBottom" style="background-image: url('../res/ui/promos/benat_02.jpg'); color: #444;"">
				<div class="ui-promo-sub-headtitle">Что нужно для заключения договора?</div>
				<div class="ui-promo-sub-qt">
					<div class="flexContainer _listing">
						<div class="ui-outline-second-info">Паспорт</div>
						<div class="ui-outline-second-info">ИНН</div>
						<div class="ui-outline-second-info">СНИЛС</div>
						<div class="ui-outline-second-info">Диплом об образовании</div>
					</div>
					
					Если Ваша деятельность связана <nobr>с вождением</nobr> автомобиля.
					
					<div class="flexContainer _listing">
						<div class="ui-outline-second-info">Водительское удостоверение</div>
						<div class="ui-outline-second-info">ПТС/СТС на автомобиль</div>
					</div>
				</div>
			</div>
			<div class="ui-sub-container withBackgroundPicture FullLeftOrHalfBottom" style="background-image: url('../res/ui/promos/benat_01.jpg'); color: #444;">
				<div class="ui-promo-sub-headtitle">Сотрудничество</div>
				<div class="ui-promo-sub-qt">
					После одобрения Ваш аккаунт приобретает статус исполнителя. Менеджеры сразу начнут рассматривать Вас для заказов, <nobr>в интересующей</nobr> Вас категории.
				</div>
				<div class="ui-promo-landing-action-btns">
					<div class="ui-outline-second-info"><?=$AcceptedPerformersText?></div>
				</div>
			</div>
		</div>
		<?if ($PerformerFormIsVisible) {?>
		<div class="ui-promo-section ui-sub-section">
			<div class="ui-sub-container" id="PerformerFormContainer">
				<div class="WhitePaper fadeIn noShadow Absolution" style="display: none;" id="PerformerRequestCheck">
					<div class="HeaderChecked">Ваша анкета была принята.</div>
					<div class="LoadContainer"></div>
				</div>
				<div class="ui-promo-sub-super-headline">Анкета</div>
				<div class="ui-permormer-register-window">
					<form id="PerformerRequest" method="POST">
						<input type="hidden" name="sign_in" value="1">
						<div class="flexContainer">
							<div class="_row mr">
								<input class="xver adaptScreen" type="text" name="performerPhone" placeholder="Телефон для связи" autocomplete="off" required>
							</div>
							<div class="_row mr">
								<input class="xver adaptScreen" type="text" name="performerMail" placeholder="Электронная почта" autocomplete="off">
							</div>
							<div class="_row mr">
								<input class="xver adaptScreen" type="text" name="performerName" placeholder="Имя" required>
							</div>
							<div class="_row mr">
								<input class="xver adaptScreen" type="text" name="performerSecondName" placeholder="Фамилия" required>
							</div>
						</div>
						<div class="littleSpace">
							<textarea class="xver" name="performerMsg" rows="5" placeholder="Опишите ваш род деятельности? Какие услуги вы предоставляете?"></textarea>
						</div>
						<div class="littleSpace">
							<label class="toLeft">Я подтверждаю, что отправляю анкету в первый раз.<input type="checkbox" name="check"></label>
						</div>
						<div class="littleSpace">
							<label class="toLeft">Отправляя анкету, вы даете согласие на <a class="SimpleLink" href="/pages/?id=2">обработку персональных данных</a>.<input type="checkbox" checked disabled></label>
						</div>
						<div class="littleSpace">
							<button class="xver adaptScreen" onclick="return UEI.PostVoid('CustomRequests/PerformerRequest', '#PerformerRequest', UEI.PerformerRequestHandler);">Отправить</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?}else{?>
		<div class="ui-promo-section ui-sub-section">
			<div class="ui-sub-container" id="PerformerFormContainer">
				<div class="WhitePaper fadeIn noShadow Absolution" style="position: unset;">
					<div class="HeaderChecked">Вы уже отправили анкету.</div>
				</div>
			</div>
		</div>
		<?}?>
	</div>
</div>