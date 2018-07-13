<?
# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');

$pageID = intval($_REQUEST['id']);
$q = $pdo_db->prepare('SELECT page_name, page_inner, added_time FROM pages_content WHERE id=?');
$q->execute(array($pageID));
$f = $q->fetch(PDO::FETCH_ASSOC);
if ($f) {
	$pageHead = $f['page_name'];
	$pageInner = $f['page_inner'];
	$pageAdded = $f['added_time'];
?>
<div class="primary clearFix">
	<div class="floatContainer">
		<div class="fl bs10 sidePads">
			<div class="Pages-PublishDate"><?=date('d.m.Y', $pageAdded)?></div>
		</div>
		<div class="fl bs60 sidePads">
			<div class="WhitePaper noShadow">
				<div class="Pages-MainHeader"><?=$pageHead?></div>
				
				<div class="Pages-Content">
					<?=$pageInner?>
				</div>
				<div></div>
			</div>
		</div>
		<div class="fl bs30 sidePads">
			<div class="ui-par-pages-last-pages-block">
				<ul class="v-menu ui-par-pages-last-pages-ul">
				<?$sql = 'SELECT id, page_name, page_inner, added_time FROM pages_content ORDER BY added_time DESC LIMIT 5';
				$q = $pdo_db->query($sql);
				while ($f1 = $q->fetch(PDO::FETCH_ASSOC)) {
					$activeFlag = '';
					if ($f1['id'] == $pageID) $activeFlag = ' active';
					echo '<li class="ui-par-pages-last-pages-block-element' . $activeFlag . '"><a href="?id=' . $f1['id'] . '">' . $f1['page_name'] . '</a></li>';
				}?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?
} else {

	include './public/standard/404.php';
}
?>