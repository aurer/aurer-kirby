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
		var doc = document.body;
		
		if(document.body.scrollWidth > 700){
			if(doc.scrollTop > 40){
				addClass(body, 'off-top');
			} else {
				removeClass(body, 'off-top');
			}
			var range = 2 + ((doc.scrollTop-30)/100);
			if(range > 6){
				range = 6;
			}
			bgp = -doc.scrollTop / range;
		};

		mast.style.backgroundPositionY = Math.round(bgp) + 'px';
		body.style.backgroundPositionY = Math.round(bgp) + 'px';
	}
}

(function(){
	'use strict';
	handleFixedNav();
}());
