<?
$sql = 'SELECT id, login, name, permissionGroup AS pg FROM people WHERE permissionGroup=0 OR permissionGroup=4 ORDER BY id';
$pq = $pdo_db->query($sql);
?>
<script type="text/javascript" src="../client/admin-superior-helper.js"></script>
<div class="primary clearFix">
	<div class="clearFix">
		<div class="h2">Управление исполнителями</div>
		<div class="littleSpace double"></div>
		<?while ($f = $pq->fetch(2)) {?>
		<div class="ui-ue-managers-table">
			<div class="_row" style="width: auto;">
				<?if ($f['pg']==0) {?>
				<input type="checkbox" class="checking" onclick="UfaEyesInterface.swapToWorker(<?=$f['id']?>);">
				<?}else{?>
				<input type="checkbox" class="checking" onclick="UfaEyesInterface.swapToWorker(<?=$f['id']?>);" checked>
				<?}?>
			</div>
			<div class="_row">
				<?=$f['id']?>
			</div>
			<div class="_row">
				<?=$f['login']?>
			</div>
			<div class="_row">
				<?=$f['name']?>
			</div>
		</div>
		
		<?}?>
	</div>
</div>