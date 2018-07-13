UEI.ChangePassword = function() {
	var t = mr.Dom(event.target);
	var d = mr.Dom('#for-changePass');
	if (!d.OwnsClass('visible')) {
		t.SetTxt('Отмена');
		d.NewClass('visible');
	} else {
		t.SetTxt('Изменить');
		d.DelClass('visible');
	}
}


UEI.SendChangePasswordForm = function() {
	var t = mr.Dom(event.target);
	mr.SendForm('../get/Userdata/ChangePassword', '#ChangePasswordForm', function(response) {
		console.log(response);
		var r = JSON.parse(response).result;
		if (r) {
			t.SetTxt('Пароль изменен');
			mr.Timers.CreateTimer(1.314, function() {
				t.SetTxt('Изменить пароль');
				mr.Dom('#for-changePass').GetParent().GetChild('button.xsimple').SetTxt('Изменить');
				mr.Dom('#for-changePass').GetParent().GetChild('#for-changePass').DelClass('visible');
			});
		} else {
			t.SetTxt('Что-то пошло не так');
			mr.Timers.CreateTimer(1.314, function() {t.SetTxt('Изменить пароль')});
		}
	});
}