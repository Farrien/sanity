SN.UI = {};

/* Scrolling of fixed right sidebar */
mr.Dom(function() {
	var rsbmE = mr.Dom('#right_sidebar_menu');
	if (!/iPhone|iPad|iPod|Android/i.test(navigator.userAgent) && rsbmE.Object) {
		var hwH = mr.Dom('.pageWrap .header').Object.offsetHeight;
		
		mr.Dom('body').Event.Scroll(function(e) {
			if (mr.Dom(window).CurrentScroll() > hwH) {
				rsbmE.NewClass('fix_scroll');
			} else {
				rsbmE.DelClass('fix_scroll');
			}
		});
	}
});