let AutoMessage = 'Здравствуйте! В ближайшее время свободный менеджер ответит Вам.<br>Вы заранее можете ответить на наиболее часто возникающие вопросы такие как,<br>- В чем заключается проблема?<br>- Ваш адрес, если необходим выезд?<br>- Когда выполнить работы? (Например, завтра после 16:00)<br>- На какую стоимость рассчитываете?';

mr.Dom(function() {
	if (typeof _cLocation != 'undefined') {
		if (_cLocation == 'client_panel' && mr.Dom('#ChatBody').i()) {
			mr.Query('../get/ChatMessages/GetMessageHistory', {lastMessagesCount : 10, hook : _mon.Client.settings.hook, key : _mon.Client.settings.key}, function(response) {
				mr.Dom('#ChatBody').ClearSelf();
				var a = {els:[]};
				var preparedModel = {
					attr:'MessageBody clearFix',
					inner:[
						{attr:'MsgSender highlighted',inner:[{inner:'Добро Пожаловать'}]},
						{attr:'MsgTime',inner:[{inner:''}]},
						{attr:'MsgTxt',inner:[{inner:AutoMessage}]}
					]
				};
				a.els.push(preparedModel);
				var r = JSON.parse(response);
				var results = r.result.msgList;
				for (var k in results) {
					var sMsgSenderElClass = 'MsgSender';
					if (_iIde && _iIde != results[k]['im_id']) sMsgSenderElClass += ' highlighted';
					var correctTime = timeConverter(results[k]['for_order']);
					var preparedModel = {
						attr:'MessageBody clearFix',
						inner:[
							{attr:sMsgSenderElClass,inner:[{inner:results[k]['sender']}]},
							{attr:'MsgTime',inner:[{inner:correctTime}]},
							{attr:'MsgTxt',inner:[{inner:results[k]['inner']}]}
						]
					};
					a.els.push(preparedModel);
				}
				mr.Dom('#ChatBody').CreateDOMbyRules(a);
				UfaEyesInterface.autoUpdateManagerClientChat({hook : _mon.Client.settings.hook, key : _mon.Client.settings.key});
			});
		}
	}
});

var currentMsgCount = [];
currentMsgCount['client-manager'] = 0;
UfaEyesInterface.autoUpdateManagerClientChat = function(data) {
	mr.Timers.CreateTimer({endTime:3, infinite:1}, function() {
		mr.Query('../get/ChatMessages/GetMessageHistory', {lastMessagesCount : 10, hook : _mon.Client.settings.hook, key : _mon.Client.settings.key}, function(response) {
			mr.Dom('#ChatBody').ClearSelf();
		//	console.log(response);
			var a = {els:[]};
			var preparedModel = {
				attr:'MessageBody clearFix',
				inner:[
					{attr:'MsgSender highlighted',inner:[{inner:'Добро Пожаловать'}]},
					{attr:'MsgTime',inner:[{inner:''}]},
					{attr:'MsgTxt',inner:[{inner:AutoMessage}]}
				]
			};
			a.els.push(preparedModel);
			var r = JSON.parse(response);
			var results = r.result.msgList;
			for (var k in results) {
				var sMsgSenderElClass = 'MsgSender';
				if (_iIde && _iIde != results[k]['im_id']) sMsgSenderElClass += ' highlighted';
				var correctTime = timeConverter(results[k]['for_order']);
				var preparedModel = {
					attr:'MessageBody clearFix',
					inner:[
						{attr:sMsgSenderElClass,inner:[{inner:results[k]['sender']}]},
						{attr:'MsgTime',inner:[{inner:correctTime}]},
						{attr:'MsgTxt',inner:[{inner:results[k]['inner']}]}
					]
				};
				a.els.push(preparedModel);
			}
			mr.Dom('#ChatBody').CreateDOMbyRules(a);
			if (results.length > currentMsgCount['client-manager']) {
				currentMsgCount['client-manager'] = results.length;
				if (mr.Dom('#ChatBody').i()) mr.ScrollDownChat('ChatBody');
			}
		});
	});
}

UfaEyesInterface.sendMessage = function() {
	if (!_mon.Client.settings.key || !_mon.Client.settings.hook) return false;
	var sendingMessage = mr.Dom('#ChatWithManager .messageTextarea').V();
	mr.Dom('#ChatWithManager .messageTextarea').V('');
	if (sendingMessage.length < 1) return false;
	var sm_hook = _mon.Client.settings.hook,
		sm_key = _mon.Client.settings.key;
	mr.Query('../get/ChatMessages/SendMessage', {sendingMessage : sendingMessage, hook : sm_hook, key : sm_key}, function(response) {
		console.log(response);
	});
	return false;
}