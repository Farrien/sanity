<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');
?>
<!DOCTYPE html>
<html lang="<?=SITE_LANG?>">
<head>
	<?include STANDARD_HEADER_LAYER?>

	<script type="text/javascript">
		var utiTime = <?=$globalTime?>;
	</script>
</head>
<body>
	<div class="pageWrap directed">
		<div class="HeaderSuperPosition">
			<div class="HeaderWrap">
				<div class="rowLogo" style="position: relative;">
					<a href="/"><div class="tempLogo WhiteLetter"></div></a>
				</div>
				<div style="position: relative;">
					<div class="HeaderRightMenu WhiteLetters">
						<?if ($perm) {?>
						<div class="item">
							<a href="../index/">Главная</a>
						</div>
						<div class="item deks_only">
							<div class="DropdownMenu fromRight">
								<div class="Header" style="font-weight: 700;">Управление</div>
								<div class="Variables select-hide">
									<div class="Vars"><a href="../<?=$linkToCabinet?>/">Личный кабинет</a></div>
									<div class="Vars"><a href="../account/">Настройки</a></div>
									<div class="Vars"><a href="../logout/">Выйти</a></div>
								</div>
							</div>
						</div>
						<div class="item mobile_only">
							<a href="../<?=$linkToCabinet?>/">Личный кабинет</a>
						</div>
						<?if (false) {?>
						<div class="item">
							<a >Баланс: <?=$SN->widget('ewallet-sum')?></a>
						</div>
						<?}?>
						<div class="item mobile_only">
							<a href="../account/">Настройки</a>
						</div>
						<div class="item mobile_only">
							<a href="../logout/">Выйти</a>
						</div>
						<?} else {?>
						<div class="item">
							<a href="">О сайте</a>
						</div>
						<div class="item">
							<a href="/performer-verification/">Стать Исполнителем</a>
						</div>
						<div class="item">
							<a href="../login/?ownp=origin">Войти</a>
						</div>
						<?}?>
					</div>
				</div>
			</div>
		</div>
		<div class="layout">
			<div class="contentSpace">
