<?
use Helper\Wallet\Wallet;
$transactions = Wallet::lastTransactions($USER['id']);
?>
<div>
	<widget>
		<div class="BlockTitle h2">Последние действия</div>
		<?if (empty($transactions)) {?>
		<div class="lane-block-kv">
			Ничего не найдено
		</div>
		<?} else {
		foreach ($transactions as $transaction) { ?>
		<div class="lane-block-kv">
			<div class="ikey"><?=$transaction['change_type'] ? '-' : '+'?></div>
			<div class="ivalue"><?=$transaction['amount']?> ₽</div>
		</div>
		<?}
		}
		?>
	</widget>
</div>