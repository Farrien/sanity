<?# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');?>

<div class="PageHeader"><?=$PageTitle?></div>
<div class="WhiteBlock VerticalSpaces">
	<form id="sps-main-form">
		<?foreach ($lines AS $v) {?>
		<div class="data-box-textareas">
			<div class="data-box-key"># <?=$v['unique_name']?></div>
			<div class="data-box-textbox">
				<textarea name="value[<?=$v['id']?>]" class="xver" rows="3"><?=$v['string_value']?></textarea>
			</div>
		</div>
		<?}?>
	</form>

	<div class="data-box-field">
		<a class="ui-mypanel-link" href="#" onclick="local_action_save_strings(); return false;">Сохранить изменения</a>
	</div>
	<div class="data-box-explanation">
		Сохраняет все затронутые элементы.
	</div>
</div>

<div class="PageHeader">Создание новой метки</div>
<div class="WhiteBlock VerticalSpaces">
	<form id="sps-add-form">
		<div class="data-box-textareas">
			<div class="data-box-key" style="padding-top: 0;">
				<input class="xver normal lane" type="text" name="htag" placeholder="Название метки">
				<div class="data-box-explanation lane">
					Только строчные латинские буквы.
				</div>
			</div>
			<div class="data-box-textbox">
				<textarea name="value" class="xver" rows="5" placeholder="Текст"><?=$metka?></textarea>
			</div>
		</div>
	</form>


	<div class="data-box-field">
		<a class="ui-mypanel-link" href="#" onclick="local_action_add_htag(); return false;">Добавить</a>
	</div>

	<div class="field-space"></div>
</div>

<script>
function local_action_save_strings() {
	mr.SendForm('?act=core/sps/save', '#sps-main-form', function(r) {
	//	console.log(r);
		location.reload();
	});
	return false;
}
function local_action_add_htag() {
	mr.SendForm('?act=core/sps/add', '#sps-add-form', function(r) {
	//	console.log(r);
		location.reload();
	});
	return false;
}
</script>