mr.Dom(function() {
	initFileForms();
	initSelectForms();
	initMaterialButtons();
	initRangeForms();
	initSpoilers();
});

function initFileForms() {
	if (!document.querySelector('.FileForm')) return;
	
	var x = document.querySelectorAll('.FileForm');
	for (var i = 0; i < x.length; i++) {
		x[i].innerHTML = '';
		
		let paramAccept = x[i].getAttribute('p-accept');
		let paramName = x[i].getAttribute('p-name');
		
		let inputFile = document.createElement('input');
		inputFile.setAttribute('type', 'file');
		inputFile.setAttribute('name', paramName);
		inputFile.setAttribute('class', 'FileForm_input');
		inputFile.setAttribute('accept', paramAccept);
		inputFile = x[i].insertBefore(inputFile, x[i].firstChild);
		
		let btn = document.createElement('div');
		btn.setAttribute('class', 'FileForm_button');
		btn.innerText = 'Upload a photo';
		btn = x[i].insertBefore(btn, x[i].firstChild);
		
		let xi = x[i].querySelector('input[type="file"]')
		btn.onclick = function() {
			if (!xi) return;
			xi.click();
		};
		
		x[i].removeAttribute('p-accept');
		x[i].removeAttribute('p-name');
	}
	
	console.log('[SN Design] File forms are created.');
}

function initMaterialButtons() {
	if (!document.querySelector('.button.xver.material')) return;
	
	var x, j, selElmnt, b, c;
	x = document.querySelectorAll('button.xver.material');
	for (var i = 0; i < x.length; i++) {
		x[i].innerHTML = '<div class="inner">' + x[i].innerHTML + '</div>';
		
		let light1 = document.createElement('div');
		light1.setAttribute('class', 'light');
		let light2 = document.createElement('div');
		light2.setAttribute('class', 'lightCenter');
		
		light2 = x[i].insertBefore(light2, x[i].firstChild);
		light1 = x[i].insertBefore(light1, x[i].firstChild);
		let br = x[i].getBoundingClientRect();
		let pcx = br.left + pageXOffset;
		let pcy = br.top + pageYOffset;
		let pxw = br.width;
		let pxh = br.height;
		let primaryLength = pxw;
		if (pxh > pxw) primaryLength = pxh;
		light1.style.width = primaryLength * 0.9;
		light1.style.height = primaryLength * 0.9;
		light2.style.width = primaryLength * 0.65;
		light2.style.height = primaryLength * 0.65;
		x[i].onmousemove = function(e) {
			var cx = e.pageX - pcx - (primaryLength * 0.9 / 2);
			var cy = e.pageY - pcy - (primaryLength * 0.9 / 2);
			light1.style.left = cx + 'px';
			light1.style.top = cy + 'px';
			cx = e.pageX - pcx - (primaryLength * 0.65 / 2);
			cy = e.pageY - pcy - (primaryLength * 0.65 / 2);
			light2.style.left = cx + 'px';
			light2.style.top = cy + 'px';
		};
		x[i].onmouseenter = function(e) {
			
		};
		x[i].onmouseout = function(e) {
			
		};
	}
	console.log('[SN Design] Dynamic light buttons are created.');
}

function initSelectForms() {
	if (!document.querySelector('.SelectForm')) return;
	
	var x, i, j, selElmnt, a, b, c;
	x = document.getElementsByClassName("SelectForm");
	for (i = 0; i < x.length; i++) {
		selElmnt = x[i].getElementsByTagName("select")[0];
		a = document.createElement("DIV");
		a.setAttribute("class", "selected");
		a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
		x[i].appendChild(a);
		b = document.createElement("DIV");
		b.setAttribute("class", "select-items select-hide");
		for (j = 1; j < selElmnt.length; j++) {
			c = document.createElement("DIV");
			c.innerHTML = selElmnt.options[j].innerHTML;
			c.onclick = function(e) {
				var i, s, h;
				s = this.parentNode.parentNode.getElementsByTagName("select")[0];
				h = this.parentNode.previousSibling;
				for (i = 0; i < s.length; i++) {
					if (s.options[i].innerHTML == this.innerHTML) {
						s.selectedIndex = i;
						h.innerHTML = this.innerHTML;
						break;
					}
				}
				h.click();
			};
			b.appendChild(c);
		}
		x[i].appendChild(b);
		a.onclick = function(e) {
			e.stopPropagation();
			closeAllSelect(this);
			this.nextSibling.classList.toggle("select-hide");
			this.classList.toggle("select-arrow-active");
		};
	}

	var DropdownMenus = document.getElementsByClassName("DropdownMenu");
	for (var i = 0; i < DropdownMenus.length; i++) {
		var a = DropdownMenus[i].querySelectorAll('.Header')[0];
		a.parentNode.querySelectorAll('.Variables')[0].classList.add('select-hide');
		/*
		a.addEventListener("click", function(e) {
			e.stopPropagation();
			closeAllSelect(this);
			this.parentNode.querySelectorAll('.Variables')[0].classList.toggle("select-hide");
		});*/
		a.onclick = function(e) {
			e.stopPropagation();
			closeAllSelect(this);
			this.parentNode.querySelectorAll('.Variables')[0].classList.toggle('select-hide');
		};
	}
	
	console.log('[SN Design] Select forms are created.');
}

function initRangeForms() {
	if (!document.querySelector('.RangeForm')) return;
	
	var x = document.getElementsByClassName('RangeForm');
	for (i = 0; i < x.length; i++) {
		let xrf_vn = x[i].querySelector('.RangeForm_valueNode');
		let xrf_if = x[i].querySelector('.RangeForm_inputFiller');
		let xrf_ir = x[i].querySelector('input[type="range"]');
		if (xrf_vn) {
			xrf_vn.innerHTML = xrf_ir.value;
		}
		if (xrf_if) {
			let xrf_if_l = ((xrf_ir.value - xrf_ir.min ) * 100) / (xrf_ir.max - xrf_ir.min) - 100;
			let vl2 = 12;
			xrf_if.style.left = 'calc(' + xrf_if_l + '% - ' + vl2 + 'px)';
		}
		xrf_ir.oninput = function() {
			if (xrf_vn) {
				xrf_vn.innerHTML = xrf_ir.value;
			}
		}
		
		if (xrf_if) {
			xrf_ir.addEventListener('input', function() {
				let xrf_if_l = ((xrf_ir.value - xrf_ir.min ) * 100) / (xrf_ir.max - xrf_ir.min) - 100;
				let vl2 = 12;
				xrf_if.style.left = 'calc(' + xrf_if_l + '% - ' + vl2 + 'px)';
			});
		}
	}
	
	console.log('[SN Design] Range forms are created.');
}

function initSpoilers() {
	if (!document.querySelector('.Spoiler')) return;
	
	let x = document.querySelectorAll('.Spoiler');
	for (var i = 0; i < x.length; i++) {
		let s = x[i];
		let sh = s.querySelector('.SpoilerHead');
		let hr = s.querySelector('.hiddenRes');
		let mxH = hr.offsetHeight;
		if (hr.childNodes.length > 0 && mxH > 0) {
			s.classList.add('closed');
		}
		sh.onclick = function() {
			hr.style.maxHeight = mxH + 'px';
			if (hr.childNodes.length > 0 && mxH > 0) {
				s.classList.toggle('closed');
			}
		}
	}
	
	console.log('[SN Design] Spoilers are created.');
}

function closeAllSelect(elmnt) {
	var x, y, z, i, arrNo = [];
	x = document.querySelectorAll(".SelectForm .select-items");
	y = document.querySelectorAll(".SelectForm .selected");
	z = document.querySelectorAll(".DropdownMenu .Variables");
	for (i = 0; i < y.length; i++) {
		if (elmnt == y[i]) {
			arrNo.push(i)
		} else {
			y[i].classList.remove("select-arrow-active");
		}
	}
	for (i = 0; i < x.length; i++) {
		if (arrNo.indexOf(i)) {
			x[i].classList.add("select-hide");
		}
	}
	for (i = 0; i < z.length; i++) {
		if (arrNo.indexOf(i)) {
			z[i].classList.add("select-hide");
		}
	}
}

document.removeEventListener("click", closeAllSelect);
document.addEventListener("click", closeAllSelect);

