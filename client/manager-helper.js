mr.Dom(function() {
	if (typeof _cLocation != 'undefined') {
		// WORKER
		if (_cLocation == 'worker_panel') {
			// Enabling chat with manager(?)
			if (_mon.Worker.settings.yourWorker > 0 && mr.Dom('#ChatBodyWorker').i()) {
				mr.Query('../get/ChatMessages/GetMessageHistoryBtwnManagerWorker', {lastMessagesCount : 10, specific_user : _mon.Worker.settings.yourWorker, hook : _mon.Worker.settings.hook, key : _mon.Worker.settings.key}, function(response) {
					mr.Dom('#ChatBodyWorker').ClearSelf();
					var a = {els:[]};
					var r = JSON.parse(response);
					var results = r.result.msgList;
					for (var k in results) {
						var correctTime = timeConverter(results[k]['for_order']);
						var preparedModel = {
							attr:'MessageBody clearFix',
							inner:[
								{attr:'MsgSender',inner:[{inner:results[k]['sender']}]},
								{attr:'MsgTime',inner:[{inner:correctTime}]},
								{attr:'MsgTxt',inner:[{inner:results[k]['inner']}]}
							]
						};
						a.els.push(preparedModel);
					}
					mr.Dom('#ChatBodyWorker').CreateDOMbyRules(a);
					UfaEyesInterface.autoUpdateManagerWorkerChat({hook : _mon.Manager.settings.hook, key : _mon.Manager.settings.key});
				});
			}
		}
		// INSPECTOR
		if (_cLocation == 'inspector_panel') {
			// Enabling chat with manager(?)
			if (_mon.Manager.settings.yourInspector > -1 && mr.Dom('#ChatBodyInspector').i()) {
				mr.Query('../get/ChatMessages/GetMessageHistoryBtwnManagerInspector', {lastMessagesCount : 10, specific_user : _mon.Manager.settings.yourInspector, hook : _mon.Manager.settings.hook, key : _mon.Manager.settings.key}, function(response) {
					mr.Dom('#ChatBodyInspector').ClearSelf();
					var a = {els:[]};
					var r = JSON.parse(response);
					var results = r.result.msgList;
					for (var k in results) {
						var correctTime = timeConverter(results[k]['for_order']);
						var preparedModel = {
							attr:'MessageBody clearFix',
							inner:[
								{attr:'MsgSender',inner:[{inner:results[k]['sender']}]},
								{attr:'MsgTime',inner:[{inner:correctTime}]},
								{attr:'MsgTxt',inner:[{inner:results[k]['inner']}]}
							]
						};
						a.els.push(preparedModel);
					}
					mr.Dom('#ChatBodyInspector').CreateDOMbyRules(a);
					UfaEyesInterface.autoUpdateManagerInspectorChat({hook : _mon.Manager.settings.hook, key : _mon.Manager.settings.key});
				});
			}
		}
		// MANAGER
		if (_cLocation == 'manager_panel') {
			if (_mon.Manager.settings) {
			//	mr.Dom('#chatBeginner').RemoveSelf();
			//	mr.Dom('#chatSender').Visibility(true);
				mr.Query('../get/ChatMessages/GetMessageHistory', {lastMessagesCount : 10, hook : _mon.Manager.settings.hook, key : _mon.Manager.settings.key}, function(response) {
					mr.Dom('#ChatBodyClient').ClearSelf();
					var a = {els:[]};
					var r = JSON.parse(response);
					var results = r.result.msgList;
					for (var k in results) {
						var correctTime = timeConverter(results[k]['for_order']);
						var preparedModel = {
							attr:'MessageBody clearFix',
							inner:[
								{attr:'MsgSender',inner:[{inner:results[k]['sender']}]},
								{attr:'MsgTime',inner:[{inner:correctTime}]},
								{attr:'MsgTxt',inner:[{inner:results[k]['inner']}]}
							]
						};
						a.els.push(preparedModel);
					}
					mr.Dom('#ChatBodyClient').CreateDOMbyRules(a);
					UfaEyesInterface.autoUpdateManagerClientChat({hook : _mon.Manager.settings.hook, key : _mon.Manager.settings.key});
				});
			}
			// Enabling chat with inspector
			if (_mon.Manager.settings.yourInspector > -1) {
				mr.Query('../get/ChatMessages/GetMessageHistoryBtwnManagerInspector', {lastMessagesCount : 10, specific_user : _mon.Manager.settings.yourInspector, hook : _mon.Manager.settings.hook, key : _mon.Manager.settings.key}, function(response) {
					mr.Dom('#ChatBodyInspector').ClearSelf();
					var a = {els:[]};
					var r = JSON.parse(response);
					var results = r.result.msgList;
					for (var k in results) {
						var correctTime = timeConverter(results[k]['for_order']);
						var preparedModel = {
							attr:'MessageBody clearFix',
							inner:[
								{attr:'MsgSender',inner:[{inner:results[k]['sender']}]},
								{attr:'MsgTime',inner:[{inner:correctTime}]},
								{attr:'MsgTxt',inner:[{inner:results[k]['inner']}]}
							]
						};
						a.els.push(preparedModel);
					}
					mr.Dom('#ChatBodyInspector').CreateDOMbyRules(a);
					UfaEyesInterface.autoUpdateManagerInspectorChat({hook : _mon.Manager.settings.hook, key : _mon.Manager.settings.key});
				});
			}
			// Enabling chat with worker
			if (_mon.Manager.settings.yourWorker > -1) {
				mr.Query('../get/ChatMessages/GetMessageHistoryBtwnManagerWorker', {lastMessagesCount : 10, specific_user : _mon.Manager.settings.yourWorker, hook : _mon.Manager.settings.hook, key : _mon.Manager.settings.key}, function(response) {
					mr.Dom('#ChatBodyWorker').ClearSelf();
					var a = {els:[]};
					var r = JSON.parse(response);
					var results = r.result.msgList;
					for (var k in results) {
						var correctTime = timeConverter(results[k]['for_order']);
						var preparedModel = {
							attr:'MessageBody clearFix',
							inner:[
								{attr:'MsgSender',inner:[{inner:results[k]['sender']}]},
								{attr:'MsgTime',inner:[{inner:correctTime}]},
								{attr:'MsgTxt',inner:[{inner:results[k]['inner']}]}
							]
						};
						a.els.push(preparedModel);
					}
					mr.Dom('#ChatBodyWorker').CreateDOMbyRules(a);
					UfaEyesInterface.autoUpdateManagerWorkerChat({hook : _mon.Manager.settings.hook, key : _mon.Manager.settings.key});
				});
			}
		}
	}
});

UfaEyesInterface.manSendChat = function() {
	if (!_mon.Manager.settings) return false;
	var sendingMessage = mr.Dom('#messageText').V();
	mr.Dom('#messageText').V('');
	if (sendingMessage.length < 1) return false;
	if (_mon.Manager.settings) {
		sm_hook = _mon.Manager.settings.hook;
		sm_key = _mon.Manager.settings.key;
	}
	mr.Query('../get/ChatMessages/ManageSendMessage', {sendingMessage : sendingMessage, hook : sm_hook, key : sm_key}, function(response) {
		console.log(response);
	});
	return false;
};

var currentMsgCount = [];
currentMsgCount['client-manager'] = 0;
currentMsgCount['inspector-manager'] = 0;
currentMsgCount['worker-manager'] = 0;
UfaEyesInterface.autoUpdateManagerClientChat = function(data) {
	mr.Timers.CreateTimer({endTime:3, infinite:1}, function() {
		mr.Query('../get/ChatMessages/GetMessageHistory', {lastMessagesCount : 10, hook : _mon.Manager.settings.hook, key : _mon.Manager.settings.key}, function(response) {
			mr.Dom('#ChatBodyClient').ClearSelf();
			var a = {els:[]};
			var r = JSON.parse(response);
			var results = r.result.msgList;
			for (var k in results) {
				var correctTime = timeConverter(results[k]['for_order']);
				var preparedModel = {
					attr:'MessageBody clearFix',
					inner:[
						{attr:'MsgSender',inner:[{inner:results[k]['sender']}]},
						{attr:'MsgTime',inner:[{inner:correctTime}]},
						{attr:'MsgTxt',inner:[{inner:results[k]['inner']}]}
					]
				};
				a.els.push(preparedModel);
			}
			mr.Dom('#ChatBodyClient').CreateDOMbyRules(a);
			if (results && results.length > currentMsgCount['client-manager']) {
				currentMsgCount['client-manager'] = results.length;
				if (mr.Dom('#ChatBodyClient').i()) mr.ScrollDownChat('ChatBodyClient');
			}
		});
	});
	/*
	if (!_mon.Manager.settings) return false;
	data.vision_flag = 0;
	mr.Query('../server/Chats.php', data, function(response) {
		console.log(response);
		var a = {els:[]};
		var r = JSON.parse(response);
		var results = r.result.msgList;
		for (var k in results) {
			var correctTime = timeConverter(results[k]['for_order']);
			var preparedModel = {
				attr:'MessageBody clearFix',
				inner:[
					{attr:'MsgSender',inner:[{inner:results[k]['sender']}]},
					{attr:'MsgTime',inner:[{inner:correctTime}]},
					{attr:'MsgTxt',inner:[{inner:results[k]['inner']}]}
				]
			};
			a.els.push(preparedModel);
		}
		mr.Dom('#ChatBodyClient').CreateDOMbyRules(a, true);
	}, true);
	*/
}

UfaEyesInterface.autoUpdateManagerInspectorChat = function(data) {
	mr.Timers.CreateTimer({endTime:3, infinite:1}, function() {
		mr.Query('../get/ChatMessages/GetMessageHistoryBtwnManagerInspector', {lastMessagesCount : 10, specific_user : _mon.Manager.settings.yourInspector, hook : _mon.Manager.settings.hook, key : _mon.Manager.settings.key}, function(response) {
			mr.Dom('#ChatBodyInspector').ClearSelf();
			var a = {els:[]};
			var r = JSON.parse(response);
			var results = r.result.msgList;
			for (var k in results) {
				var correctTime = timeConverter(results[k]['for_order']);
				var preparedModel = {
					attr:'MessageBody clearFix',
					inner:[
						{attr:'MsgSender',inner:[{inner:results[k]['sender']}]},
						{attr:'MsgTime',inner:[{inner:correctTime}]},
						{attr:'MsgTxt',inner:[{inner:results[k]['inner']}]}
					]
				};
				a.els.push(preparedModel);
			}
			mr.Dom('#ChatBodyInspector').CreateDOMbyRules(a);
			if (results && results.length > currentMsgCount['inspector-manager']) {
				currentMsgCount['inspector-manager'] = results.length;
				if (mr.Dom('#ChatBodyInspector').i()) mr.ScrollDownChat('ChatBodyInspector');
			}
		});
	});
	/*
	if (!_mon.Manager.settings) return false;
	data.vision_flag = 3;
	mr.Query('../server/Chats.php', data, function(response) {
		console.log(response);
		var a = {els:[]};
		var r = JSON.parse(response);
		var results = r.result.msgList;
		for (var k in results) {
			var correctTime = timeConverter(results[k]['for_order']);
			var preparedModel = {
				attr:'MessageBody clearFix',
				inner:[
					{attr:'MsgSender',inner:[{inner:results[k]['sender']}]},
					{attr:'MsgTime',inner:[{inner:correctTime}]},
					{attr:'MsgTxt',inner:[{inner:results[k]['inner']}]}
				]
			};
			a.els.push(preparedModel);
		}
		mr.Dom('#ChatBodyInspector').CreateDOMbyRules(a, true);
	}, true);
	*/
}

UfaEyesInterface.autoUpdateManagerWorkerChat = function(data) {
	mr.Timers.CreateTimer({endTime:3, infinite:1}, function() {
		mr.Query('../get/ChatMessages/GetMessageHistoryBtwnManagerWorker', {lastMessagesCount : 10, specific_user : _mon.Manager.settings.yourWorker, hook : _mon.Manager.settings.hook, key : _mon.Manager.settings.key}, function(response) {
			mr.Dom('#ChatBodyWorker').ClearSelf();
			var a = {els:[]};
			var r = JSON.parse(response);
			var results = r.result.msgList;
			for (var k in results) {
				var correctTime = timeConverter(results[k]['for_order']);
				var preparedModel = {
					attr:'MessageBody clearFix',
					inner:[
						{attr:'MsgSender',inner:[{inner:results[k]['sender']}]},
						{attr:'MsgTime',inner:[{inner:correctTime}]},
						{attr:'MsgTxt',inner:[{inner:results[k]['inner']}]}
					]
				};
				a.els.push(preparedModel);
			}
			mr.Dom('#ChatBodyWorker').CreateDOMbyRules(a);
			if (results && results.length > currentMsgCount['worker-manager']) {
				currentMsgCount['worker-manager'] = results.length;
				if (mr.Dom('#ChatBodyWorker').i()) mr.ScrollDownChat('ChatBodyWorker');
			}
		});
	});
}

UfaEyesInterface.createNewWorkerAdForm = function() {
	mr.CreateDialogWindow('Новое предложение');
	mr.DialogSetContent({els:[
		{tag:'form',attr:{id:'WorkerAdCreator'},inner:[
			{attr:'floatContainer',inner:[
				{attr:'fl bs50 sidePads',inner:[{attr:'SelectForm ue',inner:[
					{tag:'select',attr:{id:'worker_ad_subject_select',name:'ad_sub'},inner:[
						{tag:'option',attr:{value:0},inner:[{inner:'Выберите тематику'}]}
					]}
				]}]},
				{attr:'fl bs50 sidePads',inner:[{tag:'input',attr:{class:'xver adaptScreen ue_input',type:'text',name:'ad_cost',placeholder:'Стоимость в час'}}]}
			]},
			{attr:'littleSpace',inner:[
				{attr:'TextareaFullForm',inner:[
					{tag:'textarea',attr:{class:'xver adaptScreen messageTextarea',rows:3,name:'ad_msg',placeholder:'Содержание'}},
					{attr:'_s2 darker',inner:[{tag:'button',attr:{class:'xver',onclick:'return UfaEyesInterface.sendWorkerAd(this)'},inner:[{inner:'Отправить'}]}]}
				]}
			]}
		]}
	]});
	var a = {els:[]};
	subjectsList.forEach(function(v, i, arr) {
		a.els.push({tag:'option',attr:{value:i+1},inner:[{inner:v}]});
	});
	mr.Dom('#worker_ad_subject_select').CreateDOMbyRules(a);
	initSelectForms(); // sn-design
}

UfaEyesInterface.sendWorkerAd = function(btn) {
	mr.Dom(btn).NewClass('loading');
	mr.SendForm('../get/WorkerAds/NewAd', '#WorkerAdCreator', function(response) {
		mr.Timers.CreateTimer(0.6, function() {
			mr.DestroyDialogWindow()
		});
	});
	return false;
}

UfaEyesInterface.setWorker = function(worker_id) {
	mr.Dom(event.target).NewClass('pressed');
	mr.Query('../get/TaskManagement/SetWorker', {worker_id : worker_id, task_id : _mon.Manager.settings.hook}, function(response) {
		console.log(response);
		location.reload();
	});
}

UfaEyesInterface.createInspectorReward = function(worker_id) {
	mr.Dom(event.target).NewClass('pressed');
	mr.SendForm('../get/TaskManagement/SetInspectionQuest', '#InspectorSettingReward form', function(response) {
		console.log(response);
		location.reload();
	});
}

UfaEyesInterface.chooseWorker = function() {
	mr.CreateDialogWindow('Список исполнителей');
	mr.DialogSetContent({els:[
		{attr:{id:'WorkersList',class:''}}
	]});
	mr.Query('../get/GroupManagement/GetAllWorkers', {}, function(response) {
	//	console.log(response);
		var a = {els:[]};
		var r = JSON.parse(response).result;
		for (var k in r.list) {
		//	console.log(r.list[k]);
			var preparedModel = {
				attr:'ui-list-design-workers-i',
				inner:[
					{attr:'ui-list-design-workers-i-first-row',inner:[{inner:r.list[k].id}]},
					{attr:'ui-list-design-workers-i-second-row',inner:[{inner:r.list[k].name}]},
					{attr:'ui-list-design-workers-i-third-row',inner:[{attr:{class:'ui-control-outlined-button inline',onclick:'UfaEyesInterface.setWorker(' + r.list[k].id + ');'},inner:[{inner:'выбрать'}]}]}
				]
			};
			a.els.push(preparedModel);
		}
		mr.Dom('#WorkersList').CreateDOMbyRules(a);
	});
}

UfaEyesInterface.fireWorkerPlaceFromTask = function() {
	
	mr.Dom(event.target).NewClass('pressed');
	mr.Query('../get/TaskManagement/unsetWorker', {task_id : _mon.Manager.settings.hook}, function(response) {
		console.log(response);
		location.reload();
	});
}

UfaEyesInterface.showTaskInfo = function(taskID) {
	mr.CreateDialogWindow('Информация о заявке');
	mr.DialogSetContent({els:[
		{attr:{id:'TaskInfoChat',class:'TaskChat ChatBody'}}
	]});
	mr.Query('../get/ChatMessages/GetMessagesUltimateAccess', {hook : taskID}, function(response) {
		mr.Dom('#TaskInfoChat').ClearSelf();
		var a = {els:[]};
		var r = JSON.parse(response);
		var results = r.result.msgList;
		for (var k in results) {
			var correctTime = timeConverter(results[k]['for_order']);
			var preparedModel = {
				attr:'MessageBody clearFix',
				inner:[
					{attr:'MsgSender',inner:[{inner:results[k]['sender']}]},
					{attr:'MsgTime',inner:[{inner:correctTime}]},
					{attr:'MsgTxt',inner:[{inner:results[k]['inner']}]}
				]
			};
			a.els.push(preparedModel);
		}
		mr.Dom('#TaskInfoChat').CreateDOMbyRules(a);
	});
}

UfaEyesInterface.logIntoTask = function(taskID) {
	mr.Query('../get/TaskManagement/EnterIntoTask', {task_id : taskID}, function(response) {
		console.log(response);
		location.href = '?hook=' + taskID;
	});
}

UfaEyesInterface.completeTask = function(taskID) {
	mr.Query('../get/TaskManagement/CloseTask', {task_id : taskID}, function(response) {
		console.log(response);
		location.href = '/';
	});
}

UfaEyesInterface.leaveTask = function() {
	mr.Query('../get/TaskManagement/FireManager', {task_id : _mon.Manager.settings.hook}, function(response) {
		console.log(response);
		location.href = '/';
	});
}

let key_notifyPersonA = false;
UfaEyesInterface.notifyPersonA = function(elem) {
	let t = elem;
	if (!key_notifyPersonA) {
		mr.Dom(t).Content('<span>SMS отправлено</span>');
		key_notifyPersonA = !key_notifyPersonA;
	}
	mr.Query('../get/TaskManagement/NotifyClient', {task_id : _mon.Manager.settings.hook}, function(response) {
		console.log(response);
	});
}

UfaEyesInterface.sendMessageTo = function(arg1) {
	var arguments = {};
	if (_mon.Manager) {
		sm_hook = _mon.Manager.settings.hook;
		sm_key = _mon.Manager.settings.key;
	}
	if (_mon.Inspector) {
		sm_hook = _mon.Inspector.settings.hook;
		sm_key = _mon.Inspector.settings.key;
	}
	if (_mon.Worker) {
		sm_hook = _mon.Worker.settings.hook;
		sm_key = _mon.Worker.settings.key;
	}
	
	if (arg1 == 'inspector') {
		sendingMessage = mr.Dom('#ChatWithInspector textarea.messageTextarea').V();
		mr.Query('../get/ChatMessages/ServiceCommunicateAdd', {variant : arg1, sendingMessage : sendingMessage, hook : sm_hook, key : sm_key}, function(response) {
			mr.Dom('#ChatWithInspector textarea.messageTextarea').V('');
			console.log(response);
		});
	}
	
	if (arg1 == 'worker') {
		sendingMessage = mr.Dom('#ChatWithWorker textarea.messageTextarea').V();
		mr.Query('../get/ChatMessages/ServiceCommunicateAdd', {variant : arg1, sendingMessage : sendingMessage, hook : sm_hook, key : sm_key}, function(response) {
			mr.Dom('#ChatWithWorker textarea.messageTextarea').V('');
			console.log(response);
		});
	}
}

UfaEyesInterface.TurnSubjectActivity = function(sub, el, type = false) {
	mr.Dom(el).Attr('disabled', '');
	var source = '../get/Subscriptions/ExcludeSubject';
	var data = {id : sub};
	if (type) {
		source = '../get/Subscriptions/IncludeSubject';
	}
	mr.Query(source, data, function(response) {
		console.log(response);
	});
}

UfaEyesInterface.Inspector = {}

UfaEyesInterface.Inspector.chooseQuest = function(quest) {
	mr.Query('../get/Inspection/EnterIntoTask', {quest_id : quest}, function(response) {
		console.log(response);
		let r = JSON.parse(response);
		if (r.result.taskID) {
			location.href = '?hook=' + r.result.taskID;
			return;
		}
		location.reload();
	});
}