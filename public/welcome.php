<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');?>


<div class="gather-round">
	<div class="gather-round-el ui-text"><?=$lang['new_app_created']?></div>
</div>


<style>
.gather-round {
	display: flex;
	justify-content: center;
	align-items: center;
	height: calc(100vh - 204px - 16px - 48px - 16px);
}

.gather-round-el.ui-text {
	display: flex;
	justify-content: center;
	align-items: center;
	border-radius: 50%;
	border: 20px solid #f2f2f2;
	width: 40vw;
	height: 40vw;
	box-sizing: border-box;
	padding: 5vw;
	font-size: 200%;
	line-height: 100%;
	text-align: center;
}



</style>