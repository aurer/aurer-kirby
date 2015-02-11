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
		body        = document.body;

	window.onscroll = function(e){
		var scrolltop = document.body.scrollTop || document.documentElement.scrollTop || 0;
		if(document.body.scrollWidth > 700){
			if(scrolltop > 40){
				addClass(body, 'off-top');
			} else {
				removeClass(body, 'off-top');
			}
		};
	}
}

Appreciation = {
  init: function(ele) {
    Appreciation.button = document.querySelector(ele);
    if (!Appreciation.button) {
    	return;
    }
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
		button.innerText = 'Thank you!';
    	button.className += ' appreciated';
	});
  }
}

Appreciation.init('button.btn--appreciate');

(function(){
	'use strict';
	handleFixedNav();
}());