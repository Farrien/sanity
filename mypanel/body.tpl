<!DOCTYPE html>
<html>
<head>
<?include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/SanityHeaderLayout.php';?>
</head>
<body <?echo $uniqueBGStyle ? 'class="grey"' : ''?>>
<div class="PanelPageWrap">
	<div class="PanelSidebarNav">
		<div class="LogoSpace">
			<div class="SanityLogo"></div>
		</div>
		<div class="PanelUI-Menu">
			<div class="">
				<nav class="PanelUI-Navigation">
					<a class="selected" href="/mypanel/">Главная</a>
					<a href="/mypanel/">Статистика</a>
					<a href="/mypanel/">Настройки</a>
				</nav>
			</div>
		</div>
			<div class="SanityVersion">
				ver. <?=PATCH_VER?><br>
				<?=PATCH_NAME?><br>
				<?=$_SERVER['HTTP_HOST']?><br>
				<?=APP_NAME?><br>
			</div>
	</div>
	<div class="uip-WindowSpace">
		<div class="uip-TopPart">
			<div class="uip-ScreenName"><?=$ScreenTitle?></div>
		</div>
		<div class="PageContent">
			<div class="ContentLayout">
				<?
				$extractedVariablesCount = extract($CONTROLLER->data(), EXTR_OVERWRITE);
				$view = $_SERVER['DOCUMENT_ROOT'] . '/mypanel/view/' . $RO['SECTION'] . '/' . $CONTROLLER->view() . '.php';
				include $view;
				?>
			</div>
		</div>
	</div>
</div>
</body>
</html>