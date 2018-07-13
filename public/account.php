<?# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');
if (empty($USER['id'])) die('Access denied.');

$id = $USER['id'];
use Helper\Users\Users;
use Helper\Userthings\Userthings;
$uName = Users::getName($id);
$uLogin = Users::getLogin($id);
$tcons = Userthings::GetPasswordChangeTime($id);
$passwordChangeString = $tcons ? 'Обновлен ' . time_elapsed('@' . $tcons) : 'Никогда не обновлялся';

$userSettings = Users::getPrivateSettings($USER['id']);
?>
<script type="text/javascript" src="../client/settings-page.js"></script>

<div class="primary">
	<div class="clearFix">
		<div class="floatContainer">
			<div class="fl bs20 sidePads">
				<div class="sn-policy-form">
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
				<div class="WhitePaper noShadow">
					<div class="PageHeader">Аккаунт</div>
					<div class="PageInner ui-account-settings-paper">
						<div class="ui-paper-sets-row">
							<div class="ui-paper-set-name">
								ID
							</div>
							<div class="ui-paper-set-options">
								<div class="ui-set-constant">
									<?=$USER['id']?>
								</div>
							</div>
						</div>
						<div class="ui-paper-sets-row">
							<div class="ui-paper-set-name">
								Логин
							</div>
							<div class="ui-paper-set-options">
								<div class="ui-set-constant">
									<?=$uLogin?>
								</div>
							</div>
						</div>
						<div class="ui-paper-sets-row">
							<div class="ui-paper-set-name">
								Имя
							</div>
							<div class="ui-paper-set-options">
								<div class="ui-set-constant">
									<?=$uName?>
								</div>
							</div>
						</div>
						<div class="ui-paper-sets-row">
							<div class="ui-paper-set-name">
								Фамилия
							</div>
							<div class="ui-paper-set-options">
								<div class="ui-set-constant">
									Не указана
								</div>
							</div>
						</div>
						<div class="ui-paper-sets-row">
							<div class="ui-paper-set-name">
								Электронная почта
							</div>
							<div class="ui-paper-set-options">
								<div class="ui-set-constant">
									Не указана
								</div>
							</div>
						</div>
						<div class="ui-paper-sets-row">
							<div class="ui-paper-set-name">
								Пароль
							</div>
							<div class="ui-paper-set-options">
								<div>
									<?=$passwordChangeString?><br>
									<button class="xsimple ui-link-in-paper inline" onclick="UEI.ChangePassword();">Изменить</button>
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
											<button class="xver" onclick="UEI.SendChangePasswordForm();">Изменить пароль</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="WhitePaper noShadow">
					<div class="PageHeader">Общее</div>
					<div class="PageInner ui-account-settings-paper">
						<div class="ui-paper-sets-row">
							<div class="ui-paper-set-name">Настройки отображения</div>
							<div class="ui-paper-set-options">
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
				<div class="WhitePaper noShadow">
					<div class="PageHeader">Приватность</div>
					<div class="PageInner ui-account-settings-paper">
						<div class="ui-paper-sets-row">
							<div class="ui-paper-set-name">Скрывать мой телефон от менеджера</div>
							<div class="ui-paper-set-options">
								<div class="ui-set-constant">
									<input disabled class="switcher" type="checkbox">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="fl bs20 sidePads">
				<div id="right_sidebar_menu" class="ui-par-pages-last-pages-block desktop_only">
					<ul class="v-menu ui-par-pages-last-pages-ul">
						<li class="ui-par-pages-last-pages-block-element"><a href="" onclick="return false;">Аккаунт</a></li>
						<li class="ui-par-pages-last-pages-block-element"><a href="" onclick="return false;">Общее</a></li>
						<li class="ui-par-pages-last-pages-block-element"><a href="" onclick="return false;">Приватность</a></li>
					</ul>
				</div>
			</div>
		</div>
		<emi style="display: none;">
			<?var_dump(Users::getPrivateSettings($USER['id']))?>
		</emi>
	</div>
</div>
<script>
	/* Скроллинг меню */
	if (!/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
		var hwH = mr.Dom('.HeaderWrap').Object.offsetHeight;
		var rsbmE = mr.Dom('#right_sidebar_menu');
		mr.Dom('body').Event.Scroll(function(e) {
			if (mr.Dom(window).CurrentScroll() > hwH) {
				rsbmE.NewClass('floatingMenu');
			} else {
				rsbmE.DelClass('floatingMenu');
			}
		});
	}
</script>