<html>
<head>
	<script src="client/sanity/sanity.0.1.8.js"></script>
</head>
<body>
	<div id="myApp">
		Заголовок
		<div>{{ testVar }}</div>
		<div class="OLA">{{ userName }} и {{ targetName }}</div>
		<div>
			<input type="text" sn-chain="targetName" value="" />
			<input type="text" sn-chain="userName" value="Альберт" />
			<input type="text" sn-chain="testVar" value="" />
		</div>
		<div>
			<button sn-click="">Жми</button>
		</div>
		<div>
			<button sn-click="">Жми</button>
		</div>
		конец лакки
	</div>
	<script>
		var science = {
			testVar : 'Диалог',
			userName : 'Альберт',
			targetName : 'Алина'
		};
		var myApp = new Miracle.Render({
			container : '#myApp',
			food : science
		});
		myApp.R();
	</script>
</body>
</html>