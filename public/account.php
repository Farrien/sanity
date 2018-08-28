<?
if (empty($USER['id'])) die('Access denied.');

$id = $USER['id'];
use Helper\Users;
use Helper\Userthings;
$uName = Users::getName($id);
$uLogin = Users::getLogin($id);
$tcons = Userthings::GetPasswordChangeTime($id);
$passwordChangeString = $tcons ? 'Обновлен ' . time_elapsed('@' . $tcons) : 'Никогда не обновлялся';

$userSettings = Users::getPrivateSettings($USER['id']);
?>
<div class="primary">
	<div class="clearFix">
		<div class="floatContainer">
			<div class="fl bs20 sidePads">
				<div class="SectionBlock sn-policy-form">
					<div class="sn-icon-place">
						<div class="sn-icons medium-well i-cloud"></div>
					</div>
					<div class="sn-policy-form-innerText">
						После изменения некоторых пунктов настроек необходимо сохранение.
					</div>
					<div class="sn-policy-actions">
						<button class="xver" disabled>Сохранить настройки</button>
					</div>
				</div>
			</div>
			<div class="fl bs60 sidePads">
				<div class="SectionBlock">
					<div class="SectionHeader">Аккаунт</div>
					<div class="SectionContent">
						<div class="Section-ui-option-row">
							<div class="__title">ID</div>
							<div class="__val">
								<div class="ui-set-constant">
									<?=$USER['id']?>
								</div>
							</div>
						</div>
						<div class="Section-ui-option-row">
							<div class="__title">Логин</div>
							<div class="__val">
								<div class="ui-set-constant">
									<?=$uLogin?>
								</div>
							</div>
						</div>
						<div class="Section-ui-option-row">
							<div class="__title">Имя</div>
							<div class="__val">
								<div class="ui-set-constant">
									<?=$uName?>
								</div>
							</div>
						</div>
						<div class="Section-ui-option-row">
							<div class="__title">Фамилия</div>
							<div class="__val">
								<div class="ui-set-constant">
									Не указана
								</div>
							</div>
						</div>
						<div class="Section-ui-option-row">
							<div class="__title">Электронная почта</div>
							<div class="__val">
								<div class="ui-set-constant">
									Не указана
								</div>
							</div>
						</div>
						<div class="Section-ui-option-row">
							<div class="__title">Пароль</div>
							<div class="__val">
								<div>
									<?=$passwordChangeString?><br>
									<button class="xsimple ui-link-in-paper inline inText" onclick="SN.UI.ChangePassword();">Изменить</button>
								</div>
								<div id="for-changePass" class="ui-paper-options-hidden-spoiler">
									<form id="ChangePasswordForm" method="POST">
										<div class="littleSpace">
											<input class="xver ue_input compact" type="text" name="oldpass" placeholder="Старый пароль">
										</div>
										<div class="littleSpace">
											<input class="xver ue_input compact" type="text" name="wishpass" placeholder="Новый пароль">
										</div>
										<div class="littleSpace">
											<input class="xver ue_input compact" type="text" name="wishpasscheck" placeholder="Новый пароль повторно">
										</div>
									</form>
									<div>
										<div class="littleSpace">
											<button class="xver" onclick="SN.UI.SendChangePasswordForm();">Изменить пароль</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="SectionBlock">
					<div class="SectionHeader">Общее</div>
					<div class="SectionContent">
						<div class="Section-ui-option-row">
							<div class="__title">Настройки отображения</div>
							<div class="__val">
								<div class="ui-set-constant">
									<label>
										<input disabled class="switcher" type="checkbox" <?if ($userSettings['view_options']['hide_completed_quests']) echo 'checked'?>>Скрывать блок завершенных заданий
									</label>
									<label>
										<input disabled class="switcher" type="checkbox">Показывать только мои записи 
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="SectionBlock">
					<div class="SectionHeader">Приватность</div>
					<div class="SectionContent">
						<div class="Section-ui-option-row">
							<div class="__title">Скрывать мой телефон</div>
							<div class="__val">
								<div class="ui-set-constant">
									<input disabled class="switcher" type="checkbox">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="fl bs20 sidePads">
				<div id="right_sidebar_menu" class="FloatingSidebar desktop_only">
					<ul class="v-menu ui-par-pages-last-pages-ul">
						<li class="ui-par-pages-last-pages-block-element"><a href="" onclick="return false;">Аккаунт</a></li>
						<li class="ui-par-pages-last-pages-block-element"><a href="" onclick="return false;">Общее</a></li>
						<li class="ui-par-pages-last-pages-block-element"><a href="" onclick="return false;">Приватность</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
SN.UI.ChangePassword = function() {
	var t = mr.Dom(event.target);
	var d = mr.Dom('#for-changePass');
	if (!d.OwnsClass('visible')) {
		t.SetTxt('Отмена');
		d.NewClass('visible');
	} else {
		t.SetTxt('Изменить');
		d.DelClass('visible');
	}
}

SN.UI.SendChangePasswordForm = function() {
	var t = mr.Dom(event.target);
	mr.SendForm('../get/Userdata/ChangePassword', '#ChangePasswordForm', function(response) {
		console.log(response);
		var r = JSON.parse(response).result;
		if (r) {
			t.SetTxt('Пароль изменен');
			mr.Timers.CreateTimer(1.314, function() {
				t.SetTxt('Изменить пароль');
				mr.Dom('#for-changePass').GetParent().GetChild('button.xsimple').SetTxt('Изменить');
				mr.Dom('#for-changePass').GetParent().GetChild('#for-changePass').DelClass('visible');
			});
		} else {
			t.SetTxt('Что-то пошло не так');
			mr.Timers.CreateTimer(1.314, function() {t.SetTxt('Изменить пароль')});
		}
	});
}
</script>