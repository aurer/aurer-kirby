function addClass(ele, class){
	'use strict';
	var className = ele.className;
	var classMatch = new RegExp('\\s?' + class + '\\s?');
	if( !className.match(classMatch) ){
		ele.className += ' ' + class;
	}
}

function removeClass(ele, class){
	'use strict';
	var classMatch = new RegExp('\\s?' + class);
	ele.className = ele.className.replace(classMatch, '');
}

function setHeroImageHeight(){
	'use strict';
	var mastheight = document.querySelector('.mast').scrollHeight;
	var intro = document.querySelector('.intro');
	if (intro){
		var winheight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
		var resize = winheight - mastheight;
		document.querySelector('.intro').style.height = resize + 'px';
	}
}

function handleFixedNav(){
	'use strict';
	
	var docheight 	= document.body.scrollHeight;
	var winheight 	= window.screen.height;
	var mast 		= document.querySelector('.mast');
	var body 		= document.body;
	var bgp 		= 0;

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
		}

	 	mast.style.backgroundPositionY = Math.round(bgp) + 'px';	
	    body.style.backgroundPositionY = Math.round(bgp) + 'px';	
	}	
}

(function(){
	handleFixedNav();
	setHeroImageHeight();
})();
