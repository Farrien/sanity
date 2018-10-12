<?# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');?>


<div class="ui-mypanel-mapper">
	<a class="ui-mypanel-link flag-back" href="?act=shop/products">Список товаров</a>
	<a class="ui-mypanel-link" href="?act=core/shop/save" onclick="return local_action_1();">Сохранить</a>
</div>

<div class="PageHeader"><?=$PageTitle?></div>

<div class="WhiteBlock VerticalSpaces">
	<form id="shop-product-form">
		<input type="hidden" name="product_id" value="<?=$id?>">
		<div class="data-box-field">
			<div class="input-placeholder">Артикуль</div>
			<input type="text" name="product_articul" value="<?=$articul?>">
		</div>
		<div class="data-box-field">
			<div class="input-placeholder">Название</div>
			<input type="text" name="product_name" value="<?=$name?>">
		</div>
		<div class="data-box-field">
			<div class="input-placeholder">Количество</div>
			<input type="text" name="product_quantity" value="<?=$quantity?>">
		</div>
		<div class="data-box-field">
			<div class="input-placeholder">Категория</div>
			<input type="text" name="product_category" value="<?=$category?>">
		</div>
		<div class="data-box-field">
			<div class="input-placeholder">Цена</div>
			<input type="text" name="product_cost" value="<?=$cost?>">
		</div>
	</form>

	<div class="field-space"></div>
	
	<div class="data-box-choose-photo">
		<div class="data-thumbnail-preview">
			<img src="/res/shop/<?=$source_photo?>">
		</div>
		<div class="FileForm" p-name="product_photo" p-accept="image/jpeg,image/png"></div>
	</div>
	
	<div class="field-space"></div>
</div>


<script>
function local_action_1() {
	let mw = '?act=core/shop/save';
	mr.SendForm(mw, '#shop-product-form', function(r) {
		location.href = '?act=shop/products';
	//	console.log(r);
	});
	return false;
}
</script>