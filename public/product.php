<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');?>
<div class="breadcrumb-container">
	<div class="Breadcrumbs"><?=SITE_NAME?><?foreach ($Breadcrumb AS $v) {echo '<span></span>' . $v['subject_name'];}?><span></span><?=$Product['product_name']?></div>
</div>
<div class="shop-product-info">
	<div class="PageHeader shop-product-head"><?=$Product['product_name']?></div>
	<div class="shop-product-body">
		<div class="floatContainer">
			<div class="fl bs40">
				<div class="product-preview-section">
					<img src="/res/<?=$Product['cover_image']?>">
				</div>
			</div>
			<div class="fl bs60">
				<div class="product-info-action-name">Купить</div>
				<div class="product-info-title"><?=$Product['product_name']?></div>
				<div class="product-info-price"><?=$Product['cost']?> ₽</div>
				<div class="product-info-order">
					<div class="order-by-phone">
						<button class="xver" style="width: 200px;" onclick="addToBasket(<?=$productID?>);">Добавить в корзину</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="PageHeader shop-product-head">Описание</div>
	<div class="shop-product-attribute">
		<?if ($ProductDesc) {?>
		<div class="shop-product-description-section">
			<?foreach ($ProductDesc AS $v) {?>
			<div class="product-description-body">
				<div class="description-title">
					<div style="padding-right: 24px;"><?=$v['title']?></div>
				</div>
				<div class="description-text"><?=$v['description']?></div>
			</div>
			<?}?>
		</div>
		<?} else {?>
		<div class="shop-product-description-section">
			<div class="product-description-body">
				<div class="description-text">Описание отсутствует</div>
			</div>
		</div>
		<?}?>
	</div>
	
	<div class="PageHeader shop-product-head">Отзывы</div>
	<div class="shop-product-attribute">
		<?if ($Review) {?>
		<div class="shop-product-reviews-section">
			<?foreach ($Review AS $v) {?>
			<div class="product-review-body">
				<div class="review-body-pack">
					<div class="review-reviewer">
						<div style="padding-right: 24px;"><?=$v['reviewer']?> <span><?=time_elapsed('@'.$v['added_time'])?></span></div>
					</div>
					<div class="review-text"><?=$v['review']?></div>
				</div>
			</div>
			<?}?>
		</div>
		<?} else {?>
		<div class="shop-product-description-section">
			<div class="product-description-body">
				<div class="description-text">Отзывов пока нет</div>
			</div>
		</div>
		<?}?>
	</div>
	
	<?if (SHOP_SHOW_RELATED_PRODUCTS) {?>
	<div class="PageHeader shop-product-head">Другие товары</div>
	<div class="shop-related">
		<?foreach ($RelatedProducts AS $v) {?>
		<div class="shop-related-item">
			<a href="/product/?id=<?=$v['id']?>">
				<div class="related-item-photo" style="background-image: url('/res/<?=$v['cover_image']?>');"></div>
				<div class="related-item-name"><?=$v['product_name']?></div>
				<div class="related-item-cost"><?=$v['cost']?> ₽</div>
			</a>
		</div>
		<?}?>
	</div>
	<?}?>
</div>

<script>
function addToBasket(product_id) {
	let t = event.target;
	mr.Dom(t).SetTxt('Добавлено');
	sn.shop.addToOrder(product_id);
	mr.Timers.CreateTimer(1.0, function() {
		mr.Dom(t).SetTxt('Добавить в корзину');
	});
}
</script>