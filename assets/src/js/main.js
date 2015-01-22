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

Appreciation = {
  init: function(ele) {
    this.ele = document.querySelector(ele);
    this.button = this.ele.querySelector('.btn-appreciate');
    this.bindEvents();
  },
  
  bindEvents: function() {
    this.button.onclick = function(e){
      var entry = Appreciation.addEntry();
      e.preventDefault();
    };
  },
  
  addEntry: function() {
  	var button = this.button;
    var id = button.getAttribute('data-page_id');
    qwest.post('/appreciate', {
		page_id:  id
	}, {responseType: 'json'}).success(function(response){
		console.log(response);
		console.log(button);
		button.innerText = 'Thank you!';
    	button.className += ' appreciated';
	});
  }
}

Appreciation.init('.appreciate');

(function(){
	'use strict';
	handleFixedNav();
}());