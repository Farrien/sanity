<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');
?>
<!DOCTYPE html>
<html lang="<?=SITE_LANG?>">
<head>
	<?include_once TEMPLATES_DIR . DESIGN_TEMPLATE . 'page_parts/head.tpl'?>

	<script type="text/javascript">
		var utiTime = <?=$globalTime?>;
	</script>
</head>
<body>
	<div class="pageWrap">
		<div class="header">
			<!-- HEADER -->
			
			<div class="header-body compact">
				<a href="/">
					<div class="logo-image"></div>
				</a>
			
				<div class="menu-list">
				<?$menulist = include 'menu-list.php';
				foreach ($menulist AS $link=>$name) {
					echo '<div class="san-link"><a href="' . $link . '">' . $name . '</a></div>';
				}
				?>
				</div>
			</div>
			
			<!-- /HEADER -->
		</div>
		<div class="layout">
			<div class="contentSpace">
