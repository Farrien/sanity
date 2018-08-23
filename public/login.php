<?# Destroy the call if this file called directly
defined('SN_Start') or die('Access denied.');?>
<!DOCTYPE html>
<html lang="<?=SITE_LANG?>">
<head>
	<?include_once TEMPLATES_DIR . DESIGN_TEMPLATE . 'page_parts/head.tpl'?>

	<script type="text/javascript">
		var _cLocation = 'login';
		var utiTime = <?=$globalTime?>;
		if (mr.HttpGet()['act'] === 'signup') {
			mr.Dom(function() {
				ToggleFormFrames();
				mr.Dom('#FramesToggleBtn').SetTxt('Вход');
			});
		}
	</script>
	<script type="text/javascript" src="//<?=$_SERVER['HTTP_HOST']?>/client/login-page.js"></script>
	<link rel="stylesheet" type="text/css" href="//<?=$_SERVER['HTTP_HOST']?>/client/login-page.css" media="all">
</head>
<body>
	<div class="primary clearFix">

	<!-- Login Form -->

		<div class="LoginSingle">
			<div class="_wrapper">
				<div class="back-button-block">
					<a href="/" class="handle-parent">на главную</a>
				</div>
				<div class="LoginForm">
					<div class="logo-position">
						<div class="logo-image"></div>
					</div>
					<div class="_formIcon">
					</div>
					<div id="FrameLoginForm">
						<form id="AuthForm" method="POST">
							<input type="hidden" name="sign_in" value="1" />
							<div>
								<input class="xver adaptScreen" type="text" name="authLogin" placeholder="Телефон или логин" autocomplete="off" required />
							</div>
							<div class="littleSpace">
								<input class="xver adaptScreen" type="password" name="authPass" placeholder="Пароль" required />
							</div>
							<div class="littleSpace">
								<label class="toRight">Показать вводимые знаки<input class="" type="checkbox" onchange="SN.LoginPage.togglePasswordVisibility();"></label>
							</div>
							<div class="littleSpace">
								<button class="xver adaptScreen" style="width: 100%;" onclick="return SN.LoginPage.Signin();">Войти</button>
							</div>
						</form>
					</div>
					<div id="FrameSignForm" style="display: none;">
						<form id="SignForm" method="POST">
							<input type="hidden" name="sign_up" value="1" />
							<div>
								<input class="xver adaptScreen" type="text" autocomplete="off" placeholder="Телефон" name="regLogin" oninput="UEI.CheckLogin(this);" required />
							</div>
							<div class="littleSpace">
								<input class="xver adaptScreen" type="text" placeholder="Имя" name="regName" required />
							</div>
							<div class="littleSpace">
								<button class="xver adaptScreen" style="width: 100%;" onclick="return SN.LoginPage.Signup();">Зарегистрироваться</button>
							</div>
						</form>
					</div>
					<div class="BottomControls ue">
						<div class="littleSpace">
							<button id="FramesToggleBtn" class="xsimple" onclick="return ToggleFormFrames();">Регистрация</button>
						</div>
						<div class="littleSpace">
							<button id="RestorePassBtn" class="xsimple" onclick="return SN.LoginPage.RestorePassword();">Восстановить пароль</button>
						</div>
					</div>
				</div>
			</div>
		</div>

	<!-- ~~~~~ -->

	</div>

</body>
</html>