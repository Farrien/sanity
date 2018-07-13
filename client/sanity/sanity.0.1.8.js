var DEBUG = false;

var Manipulation = function(el, c) {
	var supenOn = this;
	if (el == window || el === 'body') {
		this.Object =  document.body || window;
	}
	if (!el) return this;
//	this.Context = el;
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
	GetChild : function(a) {
		if (typeof a === 'number') {
			this.Object = this.Object.childNodes[a];
			return this;
		}
		if (typeof a === 'string') {
			this.Object = this.Object.querySelector(a);
			return this;
		}
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
	Attr : function(n, v) {
		return this.Object.setAttribute(n, v);
		return this;
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
	Contains : function(a, b) {
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
	RemoveSelf : function() {
		this.Object.parentNode.removeChild(this.Object);
		return this;
	},
	RemoveWithParent : function() {
		this.Object.parentNode.remove();
		return;
	},
	ClearSelf : function() {
		this.Object.innerHTML = '';
		return this;
	},
	AddChild : function(context) {
		this.Object.innerHTML += context;
		return this;
	},
	/*
	CreateDoc : function(html) { // 
		var d = document.createDocumentFragment(),
			h = document.createElement
		
		this.Object.innerHTML += context;
		return;
	},
	*/
	CreateDOMbyRules : function(rules, before) {
		var els = rules.els;
		if (els.length == 0) return this;
		var d = document.createDocumentFragment();
		for (var k in els) {
			var attrList = '';
			var attrs = els[k].attr;
			for (var v in attrs) {
				attrList += v + '=\"' + attrs[v] + '\"';
			}
			d = this.ConstructFromFragments(d, els[k].tag, els[k].attr, els[k].inner);
		}
		if (before) {
			this.Object.insertBefore(d, this.Object.firstChild);
			this.Object = this.Object.firstChild;
		} else {
			this.Object.insertBefore(d, null);
			this.Object = this.Object.lastChild;
		}
	//	this.fixConstructedFragment(els[k].tag, els[k].attr);
		return this;
	},
	fixConstructedFragment : function(t, c) {
		var context = '.';
		if (typeof c === 'string') {
			context += c;
		} else {
			context += c.class;
		}
		this.Context = context;
		this.Object = document.querySelector(context);
	},
	ConstructFromFragments : function(mainFragment, tag, attr, inner) {
		if (typeof inner === 'string') {
		//	var h = document.createTextNode(inner);
			mainFragment.innerHTML = mainFragment.innerHTML + inner;
			return mainFragment;
		};
		if (tag === undefined) tag = 'div';
		var h = document.createElement(tag);
		if (typeof attr === 'string') {
			h.setAttribute('class', attr);
		} else {
			for (var k in attr) {
				h.setAttribute(k, attr[k]);
			}
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
	JoinChild : function(html, before) {
		var d = document.createDocumentFragment(),
			h = document.createElement('div');
		h.innerHTML = html;
		d.appendChild(h);
		if (before) { this.Object.insertBefore(d, this.Object.firstChild) }
		else {this.Object.insertBefore(d, null);}
		return this;
	},
	InsertIntoDOM : function(rules) {
		
		
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
	},
	Disable : function() {
		this.Object.disabled = true;
		return this;
	},
	Enable : function() {
		this.Object.disabled = false;
		return this;
	},
	SwitchState : function() {
		this.Object.disabled = !(this.Object.disabled);
		return this;
	},
	V : function(val) {
		if (typeof val === 'undefined') return this.Object.value;
		this.Object.value = val;
		return this;
	},
	Visibility : function(a) {
		if (typeof a === 'boolean' && a == true) {
			this.Object.style.visibility = 'visible';
			this.Object.style.display = 'block';
			return this;
		}
		this.Object.style.visibility = 'collapse';
		this.Object.style.display = 'none';
		return this;
	},
	i : function() {
		if (this.Object) return true;
		return false;
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
	Dom : function(elem, more, directObj) {
		if (typeof elem === "function") {
			window.addEventListener('load', elem, false);
			return;
		}
		if (!typeof more === "boolean" || typeof more === "undefined") more = false;
		if (typeof directObj === "boolean" && directObj == true) return new Manipulation(elem, more).Object;
		return new Manipulation(elem, more);
	},
	Query : function(url, query, callback, $long) {
		var querylist = '';
		for (var key in query) {
			querylist += key + "=" + encodeURIComponent(query[key]) + '&';
		}
		if (DEBUG) console.log('Creating a query...\nTarget URL: '+url+'\nRequest Script: '+querylist.substring(0, querylist.length - 1)+'\nContent-Type: application/x-www-form-urlencoded');
		if ($long) return this.PingPong(url, querylist.substring(0, querylist.length - 1), callback);
		return this.sendRequest(url, querylist.substring(0, querylist.length - 1), callback);
	},
	HttpGet : function() {
		var t1 = [],
			t2 = [],
			p1 = [],
			get = location.search,
			o;
		if (get.length > 1) {
			t1 = (get.substr(1)).split('&');
			for (var i=0; i < t1.length; i++) {
				t2 = t1[i].split('=');
				p1[decodeURI(t2[0])] = decodeURI(t2[1]);
			}
			o = document.getElementById('greq');
			return p1;
		}
		return false;
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
	PingPong : function(url, dataForm, callback){
		var timing = Math.floor(new Date().getTime()/1000) - 1;
		var dataFormMod = dataForm + '&timestamp=' + timing;
		console.log('Poll sended time ' + timing);
		var reqLoc = url || '';
		var xtp = this.createRequest();
		try { xtp.open('POST', reqLoc, true); }
		catch(e) { return false; }
		xtp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xtp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xtp.timeout = 20000;
		xtp.onreadystatechange = function() {
			if (xtp.readyState == 4 && xtp.status == 200) {
			//	console.log(xtp.responseText);
				if (callback && typeof callback === 'function') {
					callback(xtp.responseText);
					setTimeout(function() {
						Miracle.PingPong(url, dataForm, callback);
					}, 500);
				}
			}
		};
		xtp.ontimeout = function(response) {
			console.log('Current poll request is expired. \nTrying to send a new poll request. \nTarget: '+url);
			setTimeout(function() {
				Miracle.PingPong(url, dataForm, callback)
			}, 500);
		};
		xtp.send(dataFormMod);
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
	},
	SendForm : function(url, dataFormElement, callback){
		var dataForm;
		if (typeof dataFormElement === 'string') dataForm = new FormData(document.querySelector(dataFormElement));
		if (typeof dataFormElement === 'object') dataForm = new FormData(dataFormElement.Object);
		var reqLoc = url || '';
		var xtp = this.createRequest();
		try { xtp.open('POST', reqLoc, true); }
		catch(e) { return false; }
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
	Render : function(obj) {
		return new NR(obj);
	}
}

/*
var NR = function(sugar) {
	this.S = sugar;
	this.Config = {};
	this.Config.renderContainer = null;
	this.Config.Shadow = null;
	this.hiddenTree = [];
	
	var NRt = this;
	var NRs = this.S.food;
	this.setContainer(this.S.container);
	this.Config.Shadow = this.Config.renderContainer.innerHTML;
};

NR.prototype = {
	findAllRegular : function() {
		var allElems = document.querySelectorAll('[sn-chain]');
		for (var i = 0; i < allElems.length; i++) {
			var result = allElems[i],
				valueChained = result.getAttribute('sn-chain');
			var food = this.S.food;
			allElems[i].addEventListener('input', function() {
				food[valueChained] = 1;
			}, false);
		}
	},
	Construct : function() {
		var newTree = [];
		var nodes = this.Config.renderContainer.childNodes;
		
		console.log(nodes);
		for (var i = 0; i < nodes.length; ++i) {
			newTree = this.AddToConstruct(nodes, i, newTree);
		}
		this.hiddenTree.push(newTree);
		console.log(this.hiddenTree);
	},
	AddToConstruct : function(parN, child, container) {
		var ceel = [];
		if (parN[child].hasChildNodes()) {
			var pCh = parN[child].childNodes;
			for (var i = 0; i < pCh.length; ++i) {
				ceel.childs = this.AddToConstruct(pCh, i, ceel);
			}
		}
		if (parN[child].nodeName == '#text' && parN[child].textContent.length > 4) {
			ceel.tag = parN[child].nodeName.toLowerCase();
			ceel.content = parN[child].textContent;
			container.push(ceel);
			return container;
		} else if (parN[child].nodeName == '#text' && parN[child].textContent.length <= 4) {
			return container;
		}
		ceel.tag = parN[child].nodeName.toLowerCase();
		if (parN[child].nodeName == '#text') {
			ceel.content = parN[child].textContent;
		}
		if (parN[child].hasAttributes()) {
			ceel.attr = parN[child].attributes;
		}
		container.push(ceel);
		return container;
	}
};

function setDefineFunction( ) {
	
}

function defineNR(o, key, oldVal, customCaller) {
	var property = Object.getOwnPropertyDescriptor(o, key);
	var getter = property && property.get;
	var setter = property && property.set;
	
	if (oldVal) {
		var val = oldVal;
		Object.defineProperty(o, key, {
			enumerable: true,
			configurable: true,
			get : function() {
				var value = getter ? getter.call(o) : val;
			//	console.log('Getter ' + key);
				return value;
			},
			set : function(newVal) {
				var value = getter ? getter.call(o) : val;
				if (newVal === value || (newVal !== newVal && value !== value)) {
					return;
				}
			//	console.log('Setter ' + $v + ' has changed to ' + newVal);
				if (setter) {
					setter.call(o, newVal);
				} else {
					val = newVal;
				}
				customCaller.Render();
			}
		});
	}
}

NR.prototype.setContainer = function(ob) {
	this.Config.renderContainer = document.querySelector(ob);
}

NR.prototype.Render = function() {
	var $h = this.Config.Shadow,
		$s = $h,
		$reg = /{{\s*[a-zA-Z0-9]+\s*}}/g,
		$matches = $h.match($reg);
	
	if ($matches) {
		var vars = this.S.food;
		for (var stringVariable of $matches) {
			var objectVariable = stringVariable.replace(/[{}\s]+/g, '');
			$s = $s.replace(stringVariable, vars[objectVariable]);
		}
		this.Config.renderContainer.innerHTML = $s;
	}
	this.findAllRegular();
}

NR.prototype.R = function() {
//	Build DOM
	this.Construct();

//	Define reactive	
	for ($v in this.S.food) {
		defineNR(this.S.food, $v, this.S.food[$v], this);
	}
	this.Render();
	this.findAllRegular();
}
*/

// shorten version 
var mr = Miracle;
//Miracle = null;