<?php
function ShowCategories(&$tree, $sub = false) {
	if ($sub) echo '<div class="shop-sidebar-items hidden">';
	else echo '<div class="shop-sidebar-items">';
	
	foreach($tree AS &$v) {
		echo '<div class="shop-sidebar-item">';
		echo '<div class="shop-sidebar-item-name" onclick="sn.shop.SelectCategory(' . $v['id'] . ');">' . $v['subject_name'] . '</div>';
		if(!empty($v['subitems'])) {
			echo '<div class="shop-sidebar-plus" onclick="sn.shop.toggleCatVisibility(this);">+</div>';
			ShowCategories($v['subitems'], true);
		}
		echo '</div>';
	}
	echo '</div>';
}