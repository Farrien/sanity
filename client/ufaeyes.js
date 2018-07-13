useStorage = localStorage;
var UEI = {};

mr.Dom(function() {
	document.cookie = "clientTimezone="+getTimeZone()+";path=/";
	if (typeof _cLocation != 'undefined') {
		if (_cLocation == 'main') {
			if (useStorage.key && useStorage.connect && useStorage.name && useStorage.tel && useStorage.topic) {
				mr.Dom('#chatBeginner').RemoveSelf();
				mr.Dom('#chatSender').Visibility(true);
				mr.Dom('#tel').V(useStorage.getItem('tel')).Disable();
				mr.Dom('#name').V(useStorage.getItem('name')).Disable();
				mr.Dom('#zapros').V(useStorage.getItem('topic')).Disable();
				mr.Query('./get/ChatMessages/GetMessageHistory', {lastMessagesCount : 10, hook : useStorage.getItem('connect'), key : useStorage.getItem('key')}, function(response) {
					mr.Dom('#ChatBody').ClearSelf();
					var a = {els:[]};
					var r = JSON.parse(response);
					var results = r.result.msgList;
					for (var k in results) {
						var preparedModel = {
							attr:'MessageBody',
							inner:[
								{attr:'MsgTxt',inner:[{inner:results[k]['inner']}]},
								{attr:'MsgTime',inner:[{inner:results[k]['for_order']}]}
							]
						};
						a.els.push(preparedModel);
					}
					mr.Dom('#ChatBody').CreateDOMbyRules(a);
					UfaEyesInterface.autoUpdateChat({hook : useStorage.getItem('connect'), key : useStorage.getItem('key')});
				});
			}
		}
	}
	
	if (mr.Dom('#ChatBody').i()) mr.ScrollDownChat('ChatBody');
	if (mr.Dom('#ChatBodyClient').i()) mr.ScrollDownChat('ChatBodyClient');
	if (mr.Dom('#ChatBodyInspector').i()) mr.ScrollDownChat('ChatBodyInspector');
	if (mr.Dom('#ChatBodyWorker').i()) mr.ScrollDownChat('ChatBodyWorker');
});

UfaEyesInterface = {
	autoUpdateChat : function(data) {
		if ((!useStorage.key || !useStorage.connect) && !_mon.Manager.settings) return false;
		mr.Query('../server/LongPollChat.php', data, function(response) {
			console.log(response);
			var a = {els:[]};
			var r = JSON.parse(response);
			var results = r.result.msgList;
			for (var k in results) {
				var preparedModel = {
					attr:'MessageBody clearFix',
					inner:[
						{attr:'MsgSender',inner:[{inner:results[k]['sender']}]},
						{attr:'MsgTime',inner:[{inner:results[k]['for_order']}]},
						{attr:'MsgTxt',inner:[{inner:results[k]['inner']}]},
					]
				};
				a.els.push(preparedModel);
			}
			mr.Dom('#ChatBody').CreateDOMbyRules(a, true);
		}, true);
	},
	startChat : function() {
		let inputTel = mr.Dom('#mainPageMessenger input[name=tel]');
		let inputTelCorrect = inputTel.V().replace(/(\+7|\+8)/gm, '8');
		let NumberRegExpMatch = /^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/.test(inputTelCorrect);
		if (!NumberRegExpMatch) {
			UEI.ShowTooltip('Введите корректный номер телефона. Например, 88005553535 или +78005553535.', inputTel)
			return false;
		}
		if (mr.Dom('#mainPageMessenger input[name=name]').V() == '') {
			UEI.ShowTooltip('Введите свое имя.', mr.Dom('#mainPageMessenger input[name=name]'))
			return false;
		}
		if (mr.Dom('#mainPageMessenger input[name=zapros]').V() == '') {
			UEI.ShowTooltip('Заполните это поле. Оно является обязательным.', mr.Dom('#mainPageMessenger input[name=zapros]'))
			return false;
		}
		if (mr.Dom('#mainPageMessenger textarea#messageText').V().length < 3) {
			UEI.ShowTooltip('Заполните это поле. Оно является обязательным.', mr.Dom('#mainPageMessenger textarea#messageText'))
			return false;
		}
		
		var a = {els:[
			{attr:'LoadContainer loading'}
		]};
		mr.Dom('#TaskCreationForm').CreateDOMbyRules(a, true);
		
		mr.SendForm('../get/ChatMessages/StartDiscussion', '#mainPageMessenger', function(response) {
			console.log(response);
			var r = JSON.parse(response);
			if (r.result.comments == 'successful') {
				mr.Dom('#TaskCreationForm .LoadContainer').RemoveSelf();
				mr.Dom('#TaskCompleteNotification').Visibility(true);
				if (_cLocation) {
					mr.Timers.CreateTimer(1.0, function() {
						location.href = '/private/';
					});
					return;
				}
				let zapros = mr.Dom('#TaskCreationForm #zapros').V();
			//	mr.Dom('#mainPageMessenger #zapros').V('');
			//	mr.Dom('#mainPageMessenger #messageText').V('');
				mr.Timers.CreateTimer(1.0, function() {
					mr.Dom('#TaskCompleteNotification').Visibility(false);
					mr.Dom('#TaskCreationForm').ClearSelf();
					a = {els:[
						{attr:'sectionName _bottomSpace',inner:[{attr:'h2',inner:[{inner:'Чат с менеджером'}]}]},
						{attr:'sectionName _bottomSpace',inner:[{attr:'h3',inner:[{inner:zapros}]}]},
						{attr:{id:'ChatWithManager',class:'ChatPositionWindow'},inner:[
							{attr:'ChatWindow',inner:[{attr:{id:'ChatBody',class:'ChatBody'}}]},
							{attr:'littleSpace',inner:[
								{attr:'TextareaFullForm',inner:[
									{tag:'textarea',attr:{class:'xver adaptScreen messageTextarea',name:'msg',rows:5,onkeypress:'return UfaEyesInterface.sendMessageForce();'}},
									{attr:'_s2',inner:[{tag:'button',attr:{class:'xver',onclick:'return UfaEyesInterface.sendMessage();'},inner:[{inner:'Отправить'}]}]}
								]}
							]}
						]}
					]};
					mr.Dom('#TaskCreationForm').CreateDOMbyRules(a, true);
					defineHookKey(r.result.hook, r.result.hook_key);
					UfaEyesInterface.autoUpdateManagerClientChat({hook : r.result.hook, key : r.result.hook_key});
					
					if (_cFlag == 'unauth' && mr.HttpGet().ownp) {
						location.reload();
					}
				});
			} else if (r.result == false) {
				mr.Dom('#TaskCreationForm .LoadContainer').RemoveSelf();
			}
		});
		return false;
	},
	createNewTask : function() {
		var a = {els:[
			{attr:'LoadContainer loading'}
		]};
	//	mr.Dom('#TaskCreationForm').CreateDOMbyRules(a, true);
		
		mr.SendForm('../get/TaskHandling/NewTask', '#mainPageMessenger', function(response) {
			console.log(response);
			var r = JSON.parse(response);
			if (r.result.comments == 'successful') {
			//	mr.Dom('#TaskCompleteNotification').Visibility(true);
				let zapros = mr.Dom('#TaskCreationForm #zapros').V();
			//	mr.Dom('#mainPageMessenger #zapros').V('');
			//	mr.Dom('#mainPageMessenger #messageText').V('');
				mr.Timers.CreateTimer(1.0, function() {
			//		mr.Dom('#TaskCompleteNotification').Visibility(false);
					mr.Dom('#TaskCreationForm').ClearSelf();
					a = {els:[
						{attr:'sectionName _bottomSpace',inner:[{attr:'h2',inner:[{inner:'Чат с менеджером'}]}]},
						{attr:'sectionName _bottomSpace',inner:[{attr:'h3',inner:[{inner:zapros}]}]},
						{attr:{id:'ChatWithManager',class:'ChatPositionWindow'},inner:[
							{attr:'ChatWindow',inner:[{attr:{id:'ChatBody',class:'ChatBody'}}]},
							{attr:'littleSpace',inner:[
								{attr:'TextareaFullForm',inner:[
									{tag:'textarea',attr:{class:'xver adaptScreen messageTextarea',name:'msg',rows:5}},
									{attr:'_s2',inner:[{tag:'button',attr:{class:'xver',onlick:'return UfaEyesInterface.sendMessage()'},inner:[{inner:'Отправить'}]}]}
								]}
							]}
						]}
					]};
				//	mr.Dom('#TaskCreationForm').CreateDOMbyRules(a, true);
				//	UfaEyesInterface.autoUpdateManagerClientChat({hook : r.result.hook, key : r.result.hook_key});
					
				});
			} else if (r.result == false) {
				mr.Dom('#TaskCreationForm .LoadContainer').RemoveSelf();
			}
		});
		return false;
	},
	sendChat : function() {
		if (!useStorage.key || !useStorage.connect) return false;
		var sendingMessage = mr.Dom('#messageText').V();
		mr.Dom('#messageText').V('');
		if (sendingMessage.length < 1) return false;
		var sm_hook = useStorage.getItem('connect'),
			sm_key = useStorage.getItem('key');
		if (_mon.Manager.settings) {
			sm_hook = _mon.Manager.settings.hook;
			sm_key = _mon.Manager.settings.key;
		}
		mr.Query('../get/ChatMessages/SendMessage', {sendingMessage : sendingMessage, hook : sm_hook, key : sm_key}, function(response) {
			
		});
		return false;
		
	},
	insertMessage : function(s) {
		mr.Dom('.ChatWindow').JoinChild(s);
	}
}

UfaEyesInterface.autoUpdateManagerClientChat = function(data) {
	mr.Timers.CreateTimer({endTime:3, infinite:1}, function() {
		mr.Query('../get/ChatMessages/GetMessageHistory', {lastMessagesCount : 10, hook : data.hook, key : data.key}, function(response) {
			mr.Dom('#ChatBody').ClearSelf();
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
			mr.Dom('#ChatBody').CreateDOMbyRules(a);
		});
	});
}

UfaEyesInterface.showWorkerInfoInAdminPanel = function(worker_id) {
	mr.Dom('#workerCardContainer').Visibility(true);
	mr.Dom('#inspectorCardContainer').Visibility(false);
	mr.Query('../get/Workers/GetWorkerInfo', {worker_id : worker_id}, function(response) {
		var r = JSON.parse(response).result;
		mr.Dom('#workerCardContainer .__name').SetTxt(r.name);
		mr.Dom('#workerCardContainer .__ph').SetTxt(r.phone_num);
		mr.Dom('#workerCardContainer .__comp').SetTxt(r.company);
		mr.Dom('#workerCardContainer .__subs_list').ClearSelf();
		r.subjects.forEach(function(v) {
			var a = {els:[
				{
					attr:'NewTagQuad',
					inner:[{inner:v.name}]
				}
			]};
			mr.Dom('#workerCardContainer .__subs_list').CreateDOMbyRules(a);
		});
	});
}

UfaEyesInterface.showInspectorInfoInAdminPanel = function(_id) {
	mr.Dom('#workerCardContainer').Visibility(false);
	mr.Dom('#inspectorCardContainer').Visibility(true);
	mr.Query('../get/Inspectors/GetInfo', {target_id : _id}, function(response) {
		var r = JSON.parse(response).result;
		mr.Dom('#inspectorCardContainer .__name').SetTxt(r.name);
		mr.Dom('#inspectorCardContainer .__ph').SetTxt(r.phone_num);
		mr.Dom('#inspectorCardContainer .__currentTasksList').ClearSelf();
		r.tasks.forEach(function(v) {
			var a = {els:[
				{
					attr:'',
					inner:[{inner:v.topic}]
				},
				{
					tag:'ul',
					attr:'default',
					inner:[
						{
							tag:'li',
							inner:[{inner:'Заказчик '+v.client}]
						},
						{
							tag:'li',
							inner:[{inner:'Менеджер '+v.manager}]
						}
					]
				}
			]};
			mr.Dom('#inspectorCardContainer .__currentTasksList').CreateDOMbyRules(a);
		});
	});
}

UEI.CheckLogin = function(res) {
	if (res.tagName.toLowerCase() === 'input') {
		str = res.value;
	}
	if (str.length < 10) return;
	mr.Query('/', {shared_login : str}, function(response) {
		console.log(response);
		var r = JSON.parse(response);
		if (!r.correct) {
			UEI.ShowTooltip('Неверно указан номер.', res);
			return;
		}
		if (r.exist && r.correct) UEI.ShowTooltip('Указанный Вами номер телефона уже зарегистрирован.\n<br />Если это были Вы, <a href="../login/?ownp=origin">Войдите</a> сперва на сайт.', res);
	});
}


UEI.ShowTooltip = function(html, elem) {
	if (elem instanceof Manipulation) {
		elem = elem.Object;
	}
	var br = elem.getBoundingClientRect();
	var a = {els:[
		{attr:'UE_Tooltip',inner:[
			{inner:html}
		]}
	]};
	var TooltipBody = mr.Dom('body').CreateDOMbyRules(a).Object;
	UEI.TooltipIsPresent = true;
	TooltipBody.style.left = br.left + 'px';
	if (elem.offsetWidth < 180) {
		TooltipBody.style.left =  br.left - 90 + elem.offsetWidth / 2 + 'px';
	}
//	var top = elem.offsetHeight + elem.offsetTop;
	var top = br.top + pageYOffset + elem.offsetHeight;
	TooltipBody.style.top = top + 'px';
	var width = br.right - br.left;
	TooltipBody.style.width = width + 'px';
	mr.Timers.CreateTimer(3.14, function() {
		if (UEI.TooltipIsPresent) mr.Dom(TooltipBody).RemoveSelf();
	});
}

UEI.DestroyTooltips = function() {
	var x = document.querySelectorAll('.UE_Tooltip');
	for (i = 0; i < x.length; i++) {
		mr.Dom(x[i]).RemoveSelf();
	}
	UEI.TooltipIsPresent = false;
}

UEI.PostVoid = function(rel, formID, handler) {
	let t = event.target;
	var nrel = '../get/' + rel;
	mr.SendForm(nrel, formID, function(response) {
		if (handler && typeof handler === 'function') {
			handler(JSON.parse(response).result);
		}
	});
	return false;
}

UEI.PerformerRequestHandler = function(bool) {
	if (bool) {
		mr.Dom('#PerformerRequestCheck').Object.style.display = 'flex';
	} else {
		UEI.ShowTooltip('Ошибка в анкете: Проверьте правильность введенного номера телефона и отсутствие пустых пунктов.', mr.Dom('#PerformerRequest button'));
	}
}

function timeConverter(UNIX_timestamp){
  var a = new Date(UNIX_timestamp * 1000);
//  var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  var months = ['01','02','03','04','05','06','07','08','09','10','11','12'];
  var year = a.getFullYear().toString().substr(-2);
  var month = months[a.getMonth()];
  var date = a.getDate();
  var hour = a.getHours();
  var min = a.getMinutes();
  if (min.toString().length == 1) min = '0'+min;
  var sec = a.getSeconds();
  var time = date + '.' + month + '.' + year + ' ' + hour + ':' + min;
  return time;
}

function getTimeZone() {
	var d = new Date();
	var time_zone = ((utiTime*1000 - d.getTime())/1000).toFixed(0);
	return time_zone;
}

UfaEyesInterface.LoginPage = {
	togglePasswordVisibility : function() {
		var x = mr.Dom('input[name=authPass]').Object;
		if (x.type === "password") {x.type = "text";} else {x.type = "password";}
	}
}

UfaEyesInterface.sendMessageForce = function(e) {
	e = e || window.event;
	if (e.which == 13 && e.shiftKey == false) {
		UfaEyesInterface.sendMessage();
		return false;
	}
}