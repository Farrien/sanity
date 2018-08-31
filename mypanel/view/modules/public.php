<?# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');?>

<div class="PageHeader"><?=$PageTitle?></div>
<div class="WhiteBlock VerticalSpaces">
	<div class="data-box-field">
		<a class="ui-mypanel-link" href="?act=modules/main/add">Добавить новый</a>
	</div>
	
	<?foreach ($modules_list AS $v) {?>
	<div class="data-box-field">
		<div class="data-box-value"><?=$v['link_name']?></div>
	</div>
	<?}?>

	<div class="field-space"></div>
</div>