<?
$sql = 'SELECT id, login, name, permissionGroup AS pg FROM people WHERE permissionGroup=0 OR permissionGroup=1 ORDER BY id';
$pq = $pdo_db->query($sql);
?>
<script type="text/javascript" src="../client/admin-superior-helper.js"></script>
<div class="primary clearFix">
	<div class="clearFix">
		<div class="h1">Управление менеджерами</div>
		<div class="littleSpace"></div>
		<div class="floatContainer">
			<div class="fl bs70">
				<div class="h2">Список</div>
				<div class="littleSpace double"></div>
				<div id="UsersListing">
					<?while ($f = $pq->fetch(2)) {?>
					<div class="ui-ue-managers-table">
						<div class="_row" style="width: auto;">
							<?if ($f['pg']==0) {?>
							<input type="checkbox" class="checking" onclick="UfaEyesInterface.swapToManager(<?=$f['id']?>);">
							<?}else{?>
							<input type="checkbox" class="checking" onclick="UfaEyesInterface.swapToManager(<?=$f['id']?>);" checked>
							<?}?>
						</div>
						<div class="_row" style="width: 10%;">
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
			<div class="fl bs30">
				<div class="h2">Поиск</div>
				<div class="littleSpace">
					<input class="xver" type="text" id="UserSearchPart" placeholder="Телефон">
				</div>
				<div class="littleSpace">
					<button class=" ue" onclick="UfaEyesInterface.getListOfUsers(mr.Dom('#UserSearchPart').V());">Отсечь</button>
				</div>
			</div>
		</div>
	</div>
</div>