// Models
var Track = Backbone.Model.extend({
  defaults: function() {
    return {
      name: '',
      artist: '',
      album: '',
      url: '',
      thumbnail: {},
      timestamp: ''
    }
  }
});

// Collections
var TrackList = Backbone.Collection.extend({
  model: Track,

  url: function () {
    return 'https://ws.audioscrobbler.com/2.0/?' + $.param(this.parameters) + '&page=' + this.page;
  },

  page: 1,

  currentlyPlayingTrack: {},

  parameters: {
  	method: 'user.getrecenttracks',
  	user: 'philmau',
  	api_key: 'ccfce33b35f8480c2413f2a642fa2c6a',
  	format: 'json',
  	limit: 6,
  },

  parse: function(res, options) {
    var Collection = this;
    this.apiProperties = res.recenttracks['@attr'];

    var tracks = _.map(res.recenttracks.track, function(item){
      item.artist = item.artist['#text'];
      item.album = item.album['#text'];
      item.thumbnail = Collection.thumbnail(item.image, 'extralarge', item.artist);
      item.searchparam = encodeURIComponent(item.artist +  " " + item.name);
      item.timestamp = Collection.getTimeStamp(item);
      item.nowplaying =  (item['@attr'] && item['@attr'].nowplaying);
      return item;
    });

    // The API adds the currently playing track in front of all other tracks,
    // this is not useful so take it out and stick it somewhere for later use
    tracks = _.filter(tracks, function(track){
    	if (track.nowplaying) {
    		Collection.currentlyPlayingTrack = track;
    		return false;
    	};
    	return true;
    });

    return tracks;
  },

  // Format the timestamp for a lastFM track
  getTimeStamp: function(item) {
    if (item.date && item.date['#text']) {
      return "Played " + $.timeago(item.date['#text']);
    } else {
    	return 'Playing now';
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
      var url = (image['#text'] == '') ? '/assets/images/music.svg' : image['#text'];
      newImages[image.size] = {
        url: url,
        width: width,
        height: height,
        scale: scale
      }
    });
    return newImages[size];
  }
});
var Tracks = new TrackList;

// Views
var TrackView = Backbone.View.extend({
  tagName: 'div',

  attributes: {
  	class: 'col-md-1of2 col-lg-1of3',
  },

  template: _.template($('#track-template').html()),

  render: function() {
    this.$el.html(this.template(this.model.toJSON()));
    this.$el.find('.track-image').on('load', function(){
    	$(this).addClass('loaded');
    })
    return this;
  }
});

var TracksView = Backbone.View.extend({
	el: $('#tracklist'),

	initialize: function() {
		this.listenTo(Tracks, 'update', this.addAll);
		this.$el.addClass('grid grid--pad').html('');
	},

	addAll: function() {
		this.$el.html('');
		Tracks.each(this.addOne, this);

		var className = this.el.className.replace('out-prev', 'in-prev').replace('out-next', 'in-next');
		this.el.className = className;
	},

	addOne: function(track) {
		var view = new TrackView({model: track});
		view.render();
		this.$el.append(view.el);
	}
});

var PaginatorView = Backbone.View.extend({
	el: $('#tracklist-pagination'),

	template: _.template($('#pagination-template').html()),

	initialize: function() {
		this.listenTo(Tracks, 'update', this.render)
	},

	events: {
		'click .pagination-page': 'gotoPage',
		'click .pagination-prev': 'gotoPrev',
		'click .pagination-next': 'gotoNext'
	},

	gotoNext: function(e){
		var link = e.target.hash;
		Tracks.page = parseInt(Tracks.page) +1;
		Tracks.fetch();
		history.pushState(null, null, link);
		this.setAnimationClasses('next');
		e.preventDefault();
	},

	gotoPrev: function(e){
		var link = e.target.hash;
		Tracks.page = parseInt(Tracks.page) -1;
		Tracks.fetch();
		history.pushState(null, null, link);
		this.setAnimationClasses('prev');
		e.preventDefault();
	},

	gotoPage: function(e) {
		var link = e.target.hash;
		var page = link.replace('#', '');

		if (parseInt(page) > parseInt(Tracks.page)) {
			this.setAnimationClasses('next');
		} else {
			this.setAnimationClasses('prev');
		}

		Tracks.page = page ? page : 1;
		Tracks.fetch();
		history.pushState(null, null, link);

		e.preventDefault();
	},

	setAnimationClasses: function(direction){
		var el = $('#tracklist')[0];
		el.className = el.className.replace(/(in|out)-(next|prev)/, '') + ' out-' + direction;
	},

	render: function(tracks) {
		var attr = tracks.apiProperties;

		// Create a sensible range of pages
		var rangeStart = attr.page-2;
		if (attr.page < 4) {
			rangeStart = 1;
		}	else if (attr.page > attr.totalPages-5) {
			rangeStart = totalPages-5;
		}

		// Create the range array
		var range = _.range(rangeStart, rangeStart+5);

		var pages = _.map(range, function(item){
			return {
				number: item,
				stateClass: (parseInt(attr.page) === item) ? 'active' : ''
			}
		});

		// Pass to the template
		this.$el.html(this.template({
			pages: pages,
			prevPage: parseInt(attr.page) - 1,
			nextPage: parseInt(attr.page) + 1,
			totalPages: parseInt(attr.totalPages)
		}));
	}
});

$(function() {
	var AppRouter = Backbone.Router.extend({
		routes: {
			"(:page)": "page",
			"test": "page"
		},

		page: function(page){
			Tracks.page = page ? page : 1;
			Tracks.fetch();
		}
	});

	var app = new TracksView;
	var Pagination = new PaginatorView;
	var router = new AppRouter;
	Backbone.history.start();
});
