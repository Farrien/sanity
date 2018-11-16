<!DOCTYPE html>
<html>
<head>

<?include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/SanityHeaderLayout.php';?>

</head>
<body>
<div class="PanelPageWrap">
	<div class="PanelSidebarNav">
		<div class="LogoSpace">
			<div class="SanityLogo"></div>
		</div>
		<div class="PanelUI-Menu">
			<div class="">
				<nav class="PanelUI-Navigation">
					<a href="/mypanel/">Главная</a>
				</nav>
			</div>
		</div>
		<div class="SanityVersion">
			ver. <?=PATCH_VER?><br>
			<?=PATCH_NAME?><br>
			<?=$_SERVER['HTTP_HOST']?><br>
			<?=APP_NAME?><br>
			
			<div class="CompanyLogo"></div>
		</div>
	</div>
	<div class="uip-WindowSpace">
		<div class="uip-TopPart">
			<div class="uip-ScreenName"><?=$PageTitle?></div>
		</div>
		<div class="PageContent">
			<div class="ContentLayout">
			
				<?$view = 'view/' . $RO['SECTION'] . '/' . $controllerInstance->view() . '.php';
				if (file_exists($view)) {
					include $view;
				}?>
				
			</div>
		</div>
	</div>
</div>
</body>
</html>