function addClass(ele, classname){
	'use strict';
	var className = ele.className,
		classMatch = new RegExp('\\s?' + classname + '\\s?');
	if( !className.match(classMatch) ){
		ele.className += ' ' + classname;
	}
}

function removeClass(ele, classname){
	'use strict';
	var classMatch = new RegExp('\\s?' + classname);
	ele.className = ele.className.replace(classMatch, '');
}

function handleFixedNav(){
	'use strict';
	
	var docheight   = document.body.scrollHeight,
		winheight   = window.screen.height,
		mast        = document.querySelector('.mast'),
		body        = document.body,
		bgp         = 0;

	window.onscroll = function(e){
		var scrolltop = document.body.scrollTop || document.documentElement.scrollTop || 0;
		if(document.body.scrollWidth > 700){
			if(scrolltop > 40){
				addClass(body, 'off-top');
			} else {
				removeClass(body, 'off-top');
			}
			var range = 2 + ((scrolltop-30)/100);
			if(range > 6){
				range = 6;
			}
			bgp = -scrolltop / range;
		};
		mast.style.backgroundPosition = 'center ' + Math.round(bgp) + 'px';
		body.style.backgroundPosition = 'center ' + Math.round(bgp) + 'px';
	}
}

(function(){
	'use strict';
	handleFixedNav();
}());