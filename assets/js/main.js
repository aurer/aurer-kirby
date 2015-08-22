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

function loadPens() {
	var pensContainer = document.querySelector('.pens');

	// Exit if container does not exist
	if (!pensContainer) return;

	promise.get('/pens').then(function(error, data) {
		pensContainer.className += ' js-loaded';
		for (var i = 0; i < data.length; i++) {
			var src = 'http://codepen.io/api/oembed/?url=' + data[i].link + '&format=js&callback=renderPen';
			var script = document.createElement('script');
			script.src = src;
			var head = document.querySelector('head');
			head.appendChild(script);
			head.removeChild(script);
		};
	})
}

function renderPen(data) {
	var pensContainer = document.querySelector('.pens');
	var penOutput = document.createElement('div');
	penOutput.className = 'pens-item';
	penOutput.innerHTML = data.html;
	pensContainer.appendChild(penOutput);
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
    button.className = 'appreciate appreciate--clicked appreciate--active';
    promise.post('/appreciate', {page_id: id});
  }
}

function loadCss(path) {
  var link = document.createElement('link');
  link.rel = 'stylesheet';
  link.href = path;
  var head = document.getElementsByTagName('head')[0];
  head.parentNode.insertBefore(link, head);
}

Appreciation.init('button.appreciate');
setTimeout(function(){
	loadCss('http://fonts.googleapis.com/css?family=Oxygen:400,300');
},0)

window.addEventListener('load', function(){
	'use strict';
	handleFixedNav();
	loadPens();
});
