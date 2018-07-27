<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');?>
<script>
	g_sortType = <?=SHOP_SORT_VALUE?>;
</script>
<div>
	<div class="flexContainer">
		<div class="fl bs20">
			<div class="shop-sidebar-categories">
				<div class="shop-sidebar-block-title">Категории</div>
				
				<?=ShowCategories( $CategoriesTree );?>
				
				<div class="shop-sidebar-items">
					<div class="shop-sidebar-item">
						<div class="shop-sidebar-item-name" onclick="sn.shop.SelectCategory(0);">Сбросить</div>
					</div>
				</div>
			</div>
		</div>
		<div class="fl bs80">
			<div class="shop-listing-control">
				<div id="shop-listing-control">
					<div>
						<input type="text" class="xver asSearch" placeholder="Поиск по товарам">
					</div>
					<div class="shop-sort-toggle-wrapper">
						<div class="helper-text">Сортировка:</div>
						<div id="sort_dropdown" class="DropdownMenu fromRight">
							<div class="Header">Новые</div>
							<div class="Variables select-hide">
								<div class="Vars"><a href="/" onclick="return sn.shop.SortBy(0);">Старые</a></div>
								<div class="Vars"><a href="/" onclick="return sn.shop.SortBy(1);">По дате добавления</a></div>
								<div class="Vars"><a href="/" onclick="return sn.shop.SortBy(2);">Сначала дешевые</a></div>
								<div class="Vars"><a href="/" onclick="return sn.shop.SortBy(3);">Сначала дорогие</a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="shop-focus-listing">
				<div class="shop-shopping-goods">
					<?foreach ($Products AS $v) {?>
					<div class="shop-shipping-goods-item">
						<a href="/product/?id=<?=$v['id']?>">
							<?if ($v['unavailable']) {?>
							<div class="product_unavaulable">
								<div class="_desc">Нет в наличии</div>
							</div>
							<?}?>
							<div class="product_cover" style="background-image: url('../res/<?=$v['cover_image']?>');"></div>
							<div class="product_name"><?=$v['product_name']?></div>
							<div class="product_price"><?=$v['cost']?> ₽</div>
						</a>
					</div>
					<?}?>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
/* Скроллинг меню */
if (!/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
	var hwH = mr.Dom('.header').Object.offsetHeight;
	var rsbmE = mr.Dom('.shop-sidebar-categories');
	rsbmE.Object.style.width = rsbmE.Object.offsetWidth + 'px';
	mr.Dom('body').Event.Scroll(function(e) {
		if (mr.Dom(window).CurrentScroll() > hwH) {
			rsbmE.NewClass('floatingMenu');
		} else {
			rsbmE.DelClass('floatingMenu');
		}
	});
	var rsbmE2 = mr.Dom('#shop-listing-control');
	rsbmE2.Object.style.width = rsbmE2.Object.offsetWidth + 'px';
	mr.Dom('body').Event.Scroll(function(e) {
		if (mr.Dom(window).CurrentScroll() > hwH) {
			rsbmE2.NewClass('floatingMenu');
		} else {
			rsbmE2.DelClass('floatingMenu');
		}
	});
}
</script>