<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');?>

<div class="shop-product-edit-body">
	<div class="product-edit-body-tool">
		<form id="tagme-form">
			<input type="hidden" name="product_id" value="<?=$Product['id']?>">
			<div class="form-value-field">
				<div class="value-field-title">
					Название
				</div>
				<div class="value-field-input">
					<input class="xver" type="text" name="product_name" placeholder="Название товара" value="<?=$Product['product_name']?>">
				</div>
			</div>
			<div class="form-value-field">
				<div class="value-field-title">
					Количество
				</div>
				<div class="value-field-input">
					<input class="xver" type="text" name="product_quantity" placeholder="Количество" value="<?=$Product['quantity']?>">
				</div>
			</div>
			
			<div class="form-value-field">
				<div class="value-field-title">
					Категория
				</div>
				<div class="value-field-input">
					<div class="SelectForm">
						<select name="product_category">
							<option value="<?=$Product['category_id']?>"><?=$Product['category_name']?></option>
							<?foreach ($Categories AS $v) {
							echo '<option value="' . $v['id'] . '">' . $v['subject_name'] . '</option>';
							}?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-value-field">
				<div class="value-field-title">
					Цена
				</div>
				<div class="value-field-input">
					<input class="xver" type="text" name="product_cost" placeholder="Цена" value="<?=$Product['cost']?>">
				</div>
			</div>
			<div class="form-value-field">
				<div class="value-field-title">
					Изображение
				</div>
				<div class="value-field-input">
					<input class="xver" type="text" placeholder="Фото" value="<?=$Product['cover_image']?>">
				</div>
			</div>
		</form>
	</div>
	<div class="product-edit-body-bottom">
		<button class="xver" onclick="sn.shop.SaveProductChanges();">Сохранить</button>
	</div>
</div>
<script>
sn.shop.SaveProductChanges = function() {
	let t = event.target;
	mr.SendForm('../get/ShopManagement/ChangeProductInfo', '#tagme-form', function(response) {
		console.log(response);
		let r = JSON.parse(response);
		console.log(r);
		if (r.result) {
			mr.Dom(t).SetTxt('Сохранено');
			mr.Timers.CreateTimer(0.314, function() {
				location.href = '/admin/?act=products';
			});
		}
	});
}
</script>