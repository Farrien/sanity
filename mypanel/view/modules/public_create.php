<?# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');?>

<div class="ui-mypanel-mapper">
	<a class="ui-mypanel-link flag-back" href="?act=modules/main">Список модулей</a>
	<a class="ui-mypanel-link" href="?act=core/modules/add" onclick="return local_action_1();">Создать</a>
</div>

<div class="PageHeader"><?=$PageTitle?></div>

<div>
	<form id="modules-main-add">
		<div class="data-box-field">
			<div class="input-placeholder">Название</div>
			<input type="text" name="module_name">
		</div>
		<div class="data-box-field">
			<div class="input-placeholder">Автор</div>
			<input type="text" name="module_author" value="<?=OWNER_NAME?>">
		</div>
		<div class="field-space"></div>
		<div class="data-box-field">
			<div class="input-placeholder">Обработчик</div>
			<input type="checkbox" class="switcher" name="has_vc">
		</div>
		<div class="data-box-explanation">
			Включить обработчик (middleware). Это позволяет манипулировать данными до их вывода.
		</div>
	</form>
</div>

<script>
function local_action_1() {
	mr.SendForm('?act=core/modules/add', '#modules-main-add', function() {
		location.href = '?act=modules/main';
	});
	return false;
}
</script>