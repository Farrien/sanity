
var DEBUG = false;

var Manipulation = function(el, c) {
	var supenOn = this;
	if (el == window || el === 'body') {
		this.Object =  document.body || window;
	}
	if (!el) return this;
	this.Context = el;
	if (typeof el === "object") {
		this.Object = el;
	}
	if (typeof el === "string") {
		if (c)
			this.Object = document.querySelectorAll(el);
		else
			this.Object = document.querySelector(el);
	}
}

Manipulation.prototype = {
	GetParent : function() {
		this.Object = this.Object.parentNode;
		return this;
	},
	fort : function() {
		console.log(this.self);
	},
	NewEvent : function(eventName, callback) {
		this.Object.addEventListener(eventName, callback, false);
	},
	DelEvent : function(eventName, callback) {
		this.Object.removeEventListener(eventName, callback);
	},
	eClick : function(c) {
		this.NewEvent('click', c);
	},
	eHover : function(c) {
		this.NewEvent('hover', c);
	},
	eScroll : function(c) {
		this.NewEvent('scroll', c);
	},
	Event : {
		simple : this,
		Click : function(callback) {
			return new Manipulation(this.simple).NewEvent('click', callback);
		},
		Hover : function(callback) {
			return new Manipulation(this.simple).NewEvent('hover', callback);
		},
		Scroll : function(callback) {
			return new Manipulation(this.simple).NewEvent('scroll', callback);
		},
	},
	GetAttr : function(n) {
		return this.Object.getAttribute(n);
	},
	NewClass : function(className) {
		if (this.Object.classList)
			this.Object.classList.add(className);
		else
			this.Object.className += ' ' + className;
	},
	DelClass : function(className) {
		if (this.Object.classList)
			this.Object.classList.remove(className);
		else
			this.Object.className = this.Object.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
	},
	OwnsClass : function(className) {
		if (this.Object.classList)
			return this.Object.classList.contains(className);
		else
			return new RegExp('(^| )' + className + '( |$)', 'gi').test(this.Object.className);
	},
	Сontains : function(a, b) {
		if (typeof a === 'string') {
			if (a == 'class' && typeof b === 'string') {
				if (this.Object.classList)
					return this.Object.classList.contains(b);
				else
					return new RegExp('(^| )' + b + '( |$)', 'gi').test(this.Object.b);
			}
			if (a == 'child' && typeof b === 'object') {
				// try compareDocumentPosition
				if (this.Object == b) return false;
				return this.Object.contains(b);
			}
			return false;
		}
		return false;
		// Miracle.Dom(document.body).Contains('class', 'simple_class');
	},
	IsParentOf : function(a) {
		//if 
	},
	RemoveSelf : function() { // РЈРґР°Р»СЏРµС‚ СЌР»РµРјРµРЅС‚
		this.Object.parentNode.removeChild(this.Object);
		return;
	},
	RemoveWithParent : function() { // РЈРґР°Р»СЏРµС‚ СЌР»РµРјРµРЅС‚
		this.Object.parentNode.remove();
		return;
	},
	ClearSelf : function() { // РЈРґР°Р»СЏРµС‚ СЌР»РµРјРµРЅС‚
		this.Object.innerHTML = '';
		return;
	},
	AddChild : function(context) { // РЈРґР°Р»СЏРµС‚ СЌР»РµРјРµРЅС‚
		this.Object.innerHTML += context;
		return;
	},
	/*
	CreateDoc : function(html) { // 
		var d = document.createDocumentFragment(),
			h = document.createElement
		
		this.Object.innerHTML += context;
		return;
	},
	*/
	CreateDOMbyRules : function(rules) {
		var els = rules.els;
		var d = document.createDocumentFragment();
		for (var k in els) {
			var attrList = '';
			var attrs = els[k].attr;
			for (var v in attrs) {
				attrList += v + '=\"' + attrs[v] + '\"';
			}
		//	console.log('Will create: ' + '<' + els[k].tag + ' ' + attrList + '>' + '</' + els[k].tag + '>');
			d = this.ConstructFromFragments(d, els[k].tag, els[k].attr, els[k].inner);
		}
		this.Object.insertBefore(d, null); // or d/h?
	},
	ConstructFromFragments : function(mainFragment, tag, attr, inner) {
		if (typeof inner === 'string') {
			var h = document.createTextNode(inner);
			mainFragment.appendChild(h);
			return mainFragment;
		};
		var h = document.createElement(tag);
		for (var k in attr) {
			h.setAttribute(k, attr[k]);
		}
		if (inner != null && inner != 'undefined') {
		//	console.log('ConstructFromFragments: type of ' + typeof inner);
			for (var v in inner) {
				h = this.ConstructFromFragments(h, inner[v].tag, inner[v].attr, inner[v].inner);
				
			}
		}
		mainFragment.appendChild(h);
		return mainFragment;
	},
	JoinChild : function(html) {
		var d = document.createDocumentFragment(),
			h = document.createElement('div');
		h.innerHTML = html;
		d.appendChild(h);
	//	this.Object.appendChild(d);
	//	return this.Object.insertBefore(d, null); // or d/h?
		this.Object.insertBefore(d, null); // or d/h?
		return h;
	},
	MakeIllusion : function() {
		var d = this.Object.cloneNode(true);
	},
	GetDistance : function() {
		var rt = this.Object.getBoundingClientRect();
		return {top : rt.top + document.body.scrollTop, left: rt.left + document.body.scrollLeft}
	},
	GetTopRange : function() {
		return this.GetDistance().top;
	},
	GetSideRange : function() {
		return this.GetDistance().left;
	},
	CurrentScroll : function() {
		return window.pageYOffset || document.body.scrollTop;
	},
	GetWidth : function() {
		if (this.Object.style.display != 'none') return this.Object.offsetWidth;
		else return 0;
	},
	SetWidth : function(i) {
		this.Object.style.width = i;
	},
	SetHeight : function(i) {
		this.Object.style.height = i;
	},
	FocusOn : function() {
		this.Object.focus();
	},
	MakeEditable : function() {
		this.Object.contentEditable = true;
	},
	SetTxt : function(txt, after) {
		if (after) {
			this.Object.innerText += txt;
			return;
		}
		this.Object.innerText = txt;
	},
	t : function(t, a) { // just the same as SetTxt || short version
		if (a) {
			this.Object.innerText += t;
			return;
		}
		this.Object.innerText = t;
	},
	Content : function(html, after) {
		if (after) {
			this.Object.innerHTML += html;
			return;
		}
		this.Object.innerHTML = html;
	},
	Src : function(source) {
		// это бред, это медленно. юзай Miracle.Dom(element).Object напрямую или Miracle.Dom(element, false, true) 
		this.Object.src = source;
	}
}

var LastParicledID = 1,
	ParticleResourceID = 1;
var Particle = {
	Data : [],
	Emit : [], //emitter
	RenderSprites : [], //image
	MovementBasic : [], //image // gravity // drag
	LifespanDecay : [], //image
	PositionWithinSphereRandom : [], //image
	continuously : [],
	Create : function(o) {
		var particleEmission = 30,
			frameRate = 1000/ 24,
			lol;
		
		
		function interval(id, r) {
			var duration = 1000;
			var axisZ = Math.floor(Math.random() * (111 - 0 + 1)) + 0;
			var l = Math.floor(Math.random() * (99 - 0 + 1)) + 0;
			
			var p = LastParicledID;
			var rotateRandom = Math.floor(Math.random() * (180 - 0 + 1)) + 0;
			Miracle.Dom('#particleL'+p).Object.style.left = l;
			Miracle.Dom('#particleL'+p).Object.style.WebkitTransform = 'rotate('+rotateRandom+'deg)';
			Miracle.Dom('#particleL'+p).Object.style.OTransform = 'rotate('+rotateRandom+'deg)';
			Miracle.Dom('#particleL'+p).Object.style.MsTransform = 'rotate('+rotateRandom+'deg)';
			Miracle.Dom('#particleL'+p).Object.style.transform = 'rotate('+rotateRandom+'deg)';
			var frameRate = 1000 / 24;
			var gravityZ = 111 / 24;
			var curZ = axisZ;
			var drag = 0;
			var step = 1;
			LastParicledID += 1;
			var opacityRate = 1 / (duration / frameRate);
			var currentOpacity = 1;
			//console.log('lol');
			var sI = setInterval(function() {
			//	console.log('LOG '+Miracle.Dom('#particleL'+p));
			//	console.log(Miracle.Dom('#particleL'+p));
				curZ += gravityZ;
			//	gravityZ *= 1+((1-drag)/24);
				gravityZ *= (1+drag/100)*(1+drag/100);
				step += 0;
				Miracle.Dom('#particleL'+p).Object.style.bottom = curZ;//axisZ;//Increment;
				Miracle.Dom('#particleL'+p).Object.style.opacity = currentOpacity;
				currentOpacity -= opacityRate;
				axisZ = (axisZ + 1);
			}, frameRate);
			var tO = setTimeout(function() {
			//	clearInterval(id);
				Miracle.Dom('#particleL'+p).RemoveWithParent();
				clearInterval(sI);
			//	console.log('stopped');
			}, duration);
		}
		
		var EmissionRate = 30;
		setInterval(function() {
			var nI;
		//	console.log(LastParicledID);
			var particleID = LastParicledID;
			var div = '<div id="particleL'+particleID+'" style="opacity: 0; position: absolute; border-radius: 50%; height: 15px; width: 15px; background-image: url(particle_sprite_01.png); background-size: cover;"></div>';
			Miracle.Dom(o).JoinChild(div);
		//	var w = Miracle.Dom(o).GetWidth();
			var duration = 2000;
			interval();
		}, 1000 / EmissionRate);
	},
	WcreateYP : function(o) {
		var particleEmission = 30,
			frameRate = 1000/ 24,
			lol;
		
		
		function interval(id, r) {
			var duration = 1000;
			var axisZ = Math.floor(Math.random() * (111 - 0 + 1)) + 0;
			var l = Math.floor(Math.random() * (99 - 0 + 1)) + 0;
			var p = LastParicledID;
			Miracle.Dom('#particleL'+p).Object.style.left = l;
			var frameRate = 1000 / 24;
			var gravityZ = 111 / 24;
			var bsize = 50 / 24;
			var sizeH = Math.floor(Math.random() * (25 - 5 + 1)) + 5;
			var curZ = axisZ;
			var curX = l;
			var drag = 0;
			LastParicledID += 1;
			var opacityRate = 1 / (duration / frameRate);
			var currentOpacity = 1;
			//console.log('lol');
			var sI = setInterval(function() {
			//	console.log('LOG '+Miracle.Dom('#particleL'+p));
			//	console.log(Miracle.Dom('#particleL'+p));
				curZ += gravityZ;
				gravityZ *= (1+drag/100)*(1+drag/100);
				sizeH += bsize;
				bsize *= (1+drag/100)*(1+drag/100);
				Miracle.Dom('#particleL'+p).Object.style.bottom = curZ - sizeH / 2;//axisZ;//Increment;
				Miracle.Dom('#particleL'+p).Object.style.height = sizeH;
				Miracle.Dom('#particleL'+p).Object.style.width = sizeH;
				Miracle.Dom('#particleL'+p).Object.style.left = l - sizeH / 2;
				Miracle.Dom('#particleL'+p).Object.style.opacity = currentOpacity;
				currentOpacity -= opacityRate;
				axisZ = (axisZ + 1);
			}, frameRate);
			var tO = setTimeout(function() {
			//	clearInterval(id);
				Miracle.Dom('#particleL'+p).RemoveWithParent();
				clearInterval(sI);
			//	console.log('stopped');
			}, duration);
		}
		
		var EmissionRate = 10;
		setInterval(function() {
			var nI;
		//	console.log(LastParicledID);
			var particleID = LastParicledID;
			var div = '<div id="particleL'+particleID+'" style="opacity: 0; position: absolute; border-radius: 50%; height: 5px; width: 5px; background-image: url(particle_sprite_01.png); background-size: cover;"></div>';
			Miracle.Dom(o).JoinChild(div);
		//	var w = Miracle.Dom(o).GetWidth();
			var duration = 2000;
			interval();
		}, 1000 / EmissionRate);
	}
}

var Miracle = {
	Timers : {
		LocalTable : {
		
		},
		CreateTimer : function(q, a) {
			if (typeof q === 'function') {
				this.StartTimer(q, 1);
				return;
			}
			if (typeof q === 'number' && typeof a === 'function') {
				this.StartTimer(a, q);
				return;
			}
			if (typeof q === 'object' && typeof a === 'function') {
				if (q.infinite) {
					setInterval(function() {
						a();
					}, q.endTime*1000);
				} else {
					this.StartTimer(a, q.endTime);
				}
			}
		},
		StartTimer : function(c, t) {
			var t = t*1000;
			setTimeout(function() {
				c();
			}, t);
		}
	},
	Dom : function(element, more, directObj) {
		if (!typeof more === "boolean" || typeof more === "undefined") more = false;
		if (typeof directObj === "boolean" && directObj == true) return new Manipulation(element, more).Object;
		return new Manipulation(element, more);
	},
	Query : function(url, query, callback) {
		var querylist = '';
		for (var key in query) {
			querylist += key + "=" + encodeURIComponent(query[key]) + '&';
		}
		if (DEBUG) console.log('Creating a query...\nTarget URL: '+url+'\nRequest Script: '+querylist.substring(0, querylist.length - 1)+'\nContent-Type: application/x-www-form-urlencoded');
		return this.sendRequest(url, querylist.substring(0, querylist.length - 1), callback);
	},
	createRequest : function(){
		var xhr;
		try {
			xhr = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (E) {
				xhr = false;
			}
		}
		if (!xhr && typeof XMLHttpRequest!='undefined') {
			xhr = new XMLHttpRequest();
		}
		return xhr;
	},
	POST : function(url, postArgs, options, callback) {
		var reqLoc = url || '',
			xtp = this.createRequest();
		if (!xtp) return false;
		try { xtp.open('POST', reqLoc, true); }
		catch(e) { return false; }
		xtp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xtp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xtp.timeout = 3140;
		xtp.ontimeout = function() {
			alert('Too long query.');
		};
		if (typeof options === 'function') {
			xtp.onreadystatechange = function() {
				if (xtp.readyState == 4 && xtp.status == 200) {
					if (options && typeof options === 'function') options(xtp.responseText);
				}
			};
			xtp.send(postArgs);
			return true;
		}
		if (options && options.customTimeout) xtp.timeout = options.customTimeout * 1000;
		xtp.onreadystatechange = function() {
			if (xtp.readyState == 4 && xtp.status == 200) {
			//	console.log(xtp.responseText);
				if (callback && typeof callback === 'function') callback(xtp.responseText);
			}
		};
		xtp.send(postArgs);
		return true;
	},
	SubAction : function(callback) {
		callback();
	},
	sendRequest : function(url, dataForm, callback){
		var reqLoc = url || '';
		var xtp = this.createRequest();
		try { xtp.open('POST', reqLoc, true); }
		catch(e) { return false; }
		xtp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xtp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xtp.timeout = 30000;
		xtp.onreadystatechange = function() {
			if (xtp.readyState == 4 && xtp.status == 200) {
			//	console.log(xtp.responseText);
				if (callback && typeof callback === 'function') callback(xtp.responseText);
			}
		};
		xtp.ontimeout = function() {
			alert('Can not connect to server.');
		};
		xtp.send(dataForm);
		return false;
	},
	sendForm : function(url, dataForm, callback){
		var reqLoc = url || '';
		var xtp = this.createRequest();
		try { xtp.open('POST', reqLoc, true); }
		catch(e) { return false; }
	//	xtp.setRequestHeader('Content-Type', 'multipart/form-data');
		xtp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xtp.timeout = 30000;
		xtp.onreadystatechange = function() {
			if (xtp.readyState == 4 && xtp.status == 200) {
			//	console.log(xtp.responseText);
				if (callback && typeof callback === 'function') callback(xtp.responseText);
			}
		};
		xtp.ontimeout = function() {
			alert('Can not connect to server.');
		};
		xtp.send(dataForm);
		return false;
	}
}

var $m = Miracle;

/*
Miracle.Dom(window).eScroll(function(event) {
	var scrollv	= Miracle.Dom(this).CurrentScroll(),
		hdr	= Miracle.Dom('.header-bar-main');
	if ( hdr && scrollv > 0 ) {
		if ( !hdr.OwnsClass('second') ) hdr.NewClass('second');
	} else {
		hdr.DelClass('second');
	}
});
*/

/* примеры если забудешь */
var thread = {
	editPost : function(id) {
		Miracle.Dom('#reply_text_'+id).Object.contentEditable = true;
		Miracle.Dom('#reply_text_'+id).FocusOn();
		Miracle.Dom('#reply-'+id).NewClass('editable');
	},
	sendEditedReply : function(id) {
		Miracle.Dom('#reply_text_'+id).Object.contentEditable = false;
		var reply_text = Miracle.Dom('#reply_text_'+id).Object.innerText;
		Miracle.Dom('#reply_text_'+id).FocusOn();
		Miracle.Dom('#reply-'+id).DelClass('editable');
		var result = Miracle.Query('control_center.php', {typeofquery : 2, reply_i : id, reply_text}, function(response) {
			console.log('Secure ' + response);
		});
	},
	markFave : function(id) {
		Miracle.Query('control_center.php', {typeofquery : 3, reply_i : id}, function(response) {
			console.log('Secure ' + response);
		});
	},
	showNewReply : function(t_id) {
		Miracle.Dom('#new_reply_box').NewClass('focused');
		Miracle.Dom('#reply_focus').FocusOn();
	},
	removePost : function(el, id) {
		Miracle.Dom('#reply-'+id).RemoveSelf();
		Miracle.Query('control_center.php', {typeofquery : 1, reply_i : id});
	}
}