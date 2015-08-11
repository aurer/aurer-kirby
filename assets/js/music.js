;(function(){
	var music = {
		// Global variables and settings
		lastFm: "http://ws.audioscrobbler.com/2.0/",
		template: "/views/track.html",
		currentPage: 1,
		totalPages: 1,
		trackList: document.querySelector('.track-list'),
		trackPagination: document.querySelector('.track-pagination'),
		data: {},

		// Initialise
		init: function(){
			promise.get(music.template).then(function(error, response){
				music.data.template = _.template(response);
				music.currentPage = music.getPageParam();
				music.loadTracks();
			});
		},

		// Load tracks based on the current page
		loadTracks: function() {
			music.trackList.className += ' loading';
			var page = music.currentPage;
			var settings = {
				method: 'user.getrecenttracks',
				user: 'philmau',
				api_key: 'ccfce33b35f8480c2413f2a642fa2c6a',
				format: 'json',
				page: page
			};
			promise.get(music.lastFm, settings).then(function(error, response) {
				music.data.trackData = JSON.parse(response);
				music.totalPages = music.data.trackData.recenttracks['@attr'].totalPages;
				music.renderTracks();
			});
		},

		// Render all tracks from data.trackData using the html view
		renderTracks: function() {
			var tracks = [];

			// Map data into sensible forms
			_.each(music.data.trackData.recenttracks.track, function(item){
				var track = {};
				track.name = item.name;
				track.artist = item.artist['#text'];
				track.album = item.album['#text'];
				track.url = item.url;
				track.thumbnail = music.thumbnail(item.image, 'extralarge', track.artist);
				track.searchparam = encodeURIComponent(track.artist +  " " + track.name);
				track.timestamp = music.getTimeStamp(item);
				track.nowplaying = music.isPlaying(item);
				tracks.push(track);
			});

			// Append tracks into the containing div
			var html = music.data.template({tracks: tracks});
			music.trackList.innerHTML = html;

			// Remove the loading class
			music.trackList.className = music.trackList.className.replace(' loading', '');

			// Add pagination
			music.addPagination();

			// Scroll to the top of the tracks
      music.scrollToTracks();

      // Handle image load errors
      music.handleImageLoadErrors();
		},

		// Add pagination for tracks
		addPagination: function(){
			var totalPages = music.totalPages;
			var pagination = document.createElement('div')
			pagination.className = 'pagination';

			// Create 'next' button
			var nextButton = document.createElement('button')
			nextButton.className = 'pagination-next';
			nextButton.textContent = 'Older';
			nextButton.onclick = music.nextPage;

			// Create 'previous' button
			var prevButton = document.createElement('button')
			prevButton.className = 'pagination-prev';
			prevButton.textContent = 'Newer';
			prevButton.onclick = music.prevPage;

			// Disable next/previous buttons at each end
			if (music.currentPage <= 1) {
	      prevButton.disabled = true;
	    } else if (music.currentPage >= music.totalPages) {
	      nextButton.disabled = true;
	    }

	    // Create a sensible range of pages
			var rangeStart = music.currentPage-2;
			if (music.currentPage < 4) {
				rangeStart = 1;
			}	else if (music.currentPage > totalPages-5) {
				rangeStart = totalPages-5;
			}

			// Create the range array
			var range = _.range(rangeStart, rangeStart+5);

			// Add previos page button
			pagination.appendChild(prevButton);

			// Loop and add each page link
			_.each(range, function(i) {
				var link = document.createElement('a');
				link.className = (i == music.currentPage) ? 'pagination-page active' : 'pagination-page';
				link.href = '?p=' + i;
				link.text = i;
				pagination.appendChild(link);
			});

			// Add next page button
			pagination.appendChild(nextButton);

			// Add pagination to the DOM
			music.trackPagination.innerHTML = '';
			music.trackPagination.appendChild(pagination);
		},

		// Load the next page
		nextPage: function() {
			music.currentPage = music.getPageParam();
			music.currentPage += 1;
			history.pushState(null, 'Music page ' + music.currentPage , '?p=' + music.currentPage );
			music.loadTracks();
		},

		// load the previous page
		prevPage: function() {
			music.currentPage = music.getPageParam();
			music.currentPage -= 1;
			history.pushState(null, 'Music page ' + music.currentPage , '?p=' + music.currentPage );
			music.loadTracks();
		},

    // Images often fail to load so I'm adding a fallback
  	handleImageLoadErrors: function(){
  		var images = document.querySelectorAll('.track img');
  		_.each(images, function(image){
  			image.onerror = function(e){
  				image.src = 'http://placehold.it/128x128/214D5E/fff&text=Image Missing';
  				this.onerror = false; // Prevent endless calls if fallback also fails
  			}
  		});
  	},

    // Scroll to the top of the trackList
    scrollToTracks: function(){
    	if( screen.width < 800){
    		var top = music.trackList.offsetTop - 60;
    		window.scrollTo(0, top);
    	}
    },

		// Return image and attributes for a lastFM track image
		thumbnail: function(images, size, text){
			var newImages = [];
			var sizes = {'extralarge': 300, 'large': 126, 'medium': 64, 'small': 43};
			_.each(images, function(image){
				var width = sizes[image.size];
				var height = sizes[image.size];
				var scale = sizes[image.size] + 'x' + sizes[image.size];
				var url = (image['#text'] == '') ? 'http://placehold.it/'+scale+'/214D5E/fff/&text='+encodeURIComponent(text) : image['#text'];
				newImages[image.size] = {
					url: url,
					width: width,
					height: height,
					scale: scale
				}
			});
			return newImages[size];
		},

		// Is the track playing now?
		isPlaying: function(item) {
			return ( item['@attr'] && item['@attr'].nowplaying );
		},

		// Get the page from the querystring
		getPageParam: function(key) {
			var page = window.location.search.match(/p=([0-9]+)/);
			return page ? parseInt(page[1]) : 1;
		},

		// Format the timestamp for a lastFM track
		getTimeStamp: function(item) {
			if ( music.isPlaying(item) ) {
				return 'Now playing';
			} else if (item.date && item.date['#text']) {
				return "Played " + music.timeSince(item.date['#text']) + ' ago';
			}
		},

		// Format a timestamp as x seconds/minutes/hours ago
		timeSince: function(date)  {
			if (typeof date !== 'object') {
				date = new Date(date);
			}

			var seconds = Math.floor((new Date() - date) / 1000);
			var intervalType;

			var interval = Math.floor(seconds / 31536000);
			if (interval >= 1) {
				intervalType = 'year';
			} else {
				interval = Math.floor(seconds / 2592000);
				if (interval >= 1) {
					intervalType = 'month';
				} else {
					interval = Math.floor(seconds / 86400);
					if (interval >= 1) {
						intervalType = 'day';
					} else {
						interval = Math.floor(seconds / 3600);
						if (interval >= 1) {
							intervalType = "hour";
						} else {
							interval = Math.floor(seconds / 60);
							if (interval >= 1) {
								intervalType = "minute";
							} else {
								interval = seconds;
								intervalType = "second";
							}
						}
					}
				}
			}

			if (interval > 1 || interval === 0) {
				intervalType += 's';
			}

			return interval + ' ' + intervalType;
		}
	}

	// ...Run it!
	music.init();
}());
