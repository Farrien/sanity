<?
use Helper\Wallet\Wallet;
?>
<div>
	<widget>
		<div class="BlockTitle h2">Состояние счета</div>
		<div class="lane-block-kv">
			<div class="ikey">Баланс</div>
			<div class="ivalue"><?=Wallet::summary($USER['id'])?> ₽</div>
		</div>
	</widget>
</div>