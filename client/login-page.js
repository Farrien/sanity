var con = false;
function ToggleFormFrames() {
	if (con) {
		AppearLogin();
	} else {
		AppearSignForm();
	}
	con = !con;
}

function AppearLogin(c) {
	var t = event.target;
	mr.Dom(t).SetTxt('Регистрация');
	Miracle.Dom('#FrameLoginForm').Visibility(true);
	Miracle.Dom('#RestorePassBtn').Visibility(true);
	Miracle.Dom('#FrameSignForm').Visibility(false);
	return true;
}

function AppearSignForm(c) {
	var t = event.target;
	mr.Dom(t).SetTxt('Вход');
	Miracle.Dom('#FrameLoginForm').Visibility(false);
	Miracle.Dom('#RestorePassBtn').Visibility(false);
	Miracle.Dom('#FrameSignForm').Visibility(true);
	return true;
}

function hideBottomControls() {
	Miracle.Dom('.BottomControls').RemoveSelf();
	// and show tabs
//	Miracle.Dom('#Tabs').NewClass('Show');
}

function AppearDesc(c) {
	Miracle.Dom('#FrameLoginForm').DelClass('Show');
	Miracle.Dom('#FrameSiteDescription').NewClass('Show');
	return true;
}

ug.SendRegistrationData = function(cc, count) {
	mr.Dom(cc).NewClass('loading');
	mr.SendForm('get/Userdata/AcceptUser', '#SignForm', function(response) {
		mr.Dom(cc).DelClass('loading');
		console.log(response);
		var r = JSON.parse(response);
		var reason = r.result.comments;
		if (reason == 'noPic') {
			alert('Выберите фотографию.');
		}
		if (reason == 'wrongType') {
			
		}
		if (reason == 'successful') {
			window.location = '';
		}
		if (reason == 'emptyFields') {
			alert('Заполните все поля.');
		}
	});
	return false;
}

UEI.Signup = function() {
	var t = mr.Dom(event.target);
	var rL = mr.Dom('#SignForm input[name=regLogin]');
	if (rL.V() === '' || rL.V().length < 10) {
		UEI.ShowTooltip('Укажите номер телефона. Например, 88005553535 или +78005553535.', rL);
		rL.FocusOn();
		return false;
	}
	var rN = mr.Dom('#SignForm input[name=regName]');
	if (rN.V() === '' || rN.V().length < 2) {
		UEI.ShowTooltip('Укажите свое имя.', rN);
		rN.FocusOn();
		return false;
	}
	t.NewClass('loading');
	mr.SendForm('../get/Userdata/Signup', '#SignForm', function(response) {
		console.log(response);
		var r = JSON.parse(response);
		t.DelClass('loading');
		if (r.result == false) {
			t.SetTxt('Ошибка');
			UEI.ShowTooltip('Указанный Вами номер телефона уже занят. Если это Ваш телефон, то войдите со своим паролем или восстановите его.', t);
			mr.Timers.CreateTimer(1.0, function() {
				t.SetTxt('Зарегистрироваться');
			});
		}
		if (r.result == true) {
			UEI.ShowTooltip('Вы были успешно зарегистрированы. Дождитесь SMS с вашим паролем. <br><a class="SimpleLink" href="/login/?ownp=origin">Вернуться на страницу входа</a>', t);
			rL.V('');
			rN.V('');
			ToggleFormFrames();
		}
	});
	return false;
}

UEI.Signin = function() {
	var t = mr.Dom(event.target);
	var rL = mr.Dom('#AuthForm input[name=authLogin]');
	if (rL.V() === '' || rL.V().length < 10) {
		UEI.ShowTooltip('Укажите номер телефона. Например, 88005553535 или +78005553535.', rL);
		rL.FocusOn();
		return false;
	}
	var rN = mr.Dom('#AuthForm input[name=authPass]');
	if (rN.V() === '') {
		UEI.ShowTooltip('Заполните это поле.', rN);
		rN.FocusOn();
		return false;
	}
	t.NewClass('loading');
	mr.SendForm('../get/Userdata/Signin', '#AuthForm', function(response) {
		console.log(response);
		var r = JSON.parse(response);
		if (r.result == false) {
			t.DelClass('loading');
			t.SetTxt('Неверный логин или пароль');
			mr.Timers.CreateTimer(1.5, function() {
				t.SetTxt('Войти');
			});
		}
		if (r.result == true) {
			rL.V('');
			rN.V('');
			mr.Timers.CreateTimer(1.0, function() {
				window.location = '';
			});
		}
	});
	return false;
}

UEI.RestorePassword = function() {
	var rL = mr.Dom('#AuthForm input[name=authLogin]');
	if (rL.V() === '' || rL.V().length < 10) {
		UEI.ShowTooltip('Укажите свой телефон для получения пароля.', rL);
		rL.FocusOn();
		return false;
	}
	mr.SendForm('../get/Userdata/Restore', '#AuthForm', function(response) {
		console.log(response);
		var r = JSON.parse(response);
		if (!r.result) return false;
		mr.Dom('.LoginForm').ClearSelf();
		var a = {els:[]};
		var preparedModel = {
			attr:'HeaderChecked onTop',
			inner:[
				{inner:'Вам будет отправлено SMS с Вашим новым паролем. <br><a class="SimpleLink" href="/login/?ownp=origin">Вернуться на страницу входа</a>'},
			]
		};
		a.els.push(preparedModel);
		mr.Dom('.LoginForm').CreateDOMbyRules(a, true);
	});
	return false;
}