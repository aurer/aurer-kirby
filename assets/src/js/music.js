(function(){
    var lastFm = "http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user=philmau&api_key=ccfce33b35f8480c2413f2a642fa2c6a&format=json";
    var template = "/assets/views/track.html";
    var tracklist = document.querySelector('.track-list');
    var loadingIcon = document.querySelector('.load-icon');
    var currentPage = 1;
    var totalPages = 1;
    
    document.addEventListener('DOMContentLoaded', init, false);

    // Load the track template html
    function init(){
        qwest.get(template, {}, {type: 'html'}).success(function(templateData){
            template = templateData;
            getTracks(templateData);   
        });
    }

    // Fetch paged tracks from LastFM API and render on page
    function getTracks(template, page){
        var page = page || 1;
        loadingIcon.className = loadingIcon.className.replace(' loaded', '');
        loadingIcon.className += ' loading';
        qwest.get(lastFm, {page: page}, {type: 'json'}).success(function(trackData){
            // Remove the loading icon
            loadingIcon.className = loadingIcon.className.replace(' loading', '');
            loadingIcon.className += ' loaded';
            setTimeout(function(){
                loadingIcon.className = loadingIcon.className.replace(' loaded', '');
            }, 500);

            // Empty the tracklist
            tracklist.innerHTML = '';

            totalPages = trackData.recenttracks['@attr'].totalPages;

            // Add in all the tracks
            var tracks = [];
            _.each(trackData.recenttracks.track, function(item){
                var track = {};
                track.name = item.name;
                track.artist = item.artist['#text'];
                track.album = item.album['#text'];
                track.url = item.url;
                track.thumbnail = thumbnail(item.image, 'large', track.artist);
                track.searchparam = encodeURIComponent(track.artist +  " " + track.name);
                tracks.push(track);
                
            });
            var compiled = _.template(template);
            var html = compiled({tracks: tracks});
            tracklist.innerHTML += html;
            addPagination();
            scrollToTracks();
            handleImageLoadErrors();
            if (currentPage <= 1) {
                document.querySelector('#prev-page').disabled = true;
            }
            if (currentPage >= totalPages) {
                document.querySelector('#next-page').disabled = true;
            }
        });
    }

    // Add pagination for tracks
    function addPagination(){
        var pagination = document.createElement('div')
            pagination.className = 'pagination';
        
        var nextButton = document.createElement('button')
            nextButton.className = 'btn';
            nextButton.id = 'next-page';
            nextButton.textContent = 'Older';
            nextButton.onclick = function(){getTracks(template, ++currentPage)}

        var prevButton = document.createElement('button')
            prevButton.className = 'btn';
            prevButton.id = 'prev-page';
            prevButton.textContent = 'Newer';
            prevButton.onclick = function(){getTracks(template, --currentPage)}
        
        pagination.appendChild(prevButton)
        pagination.appendChild(nextButton);
        tracklist.appendChild(pagination);
    }

    // Image often fail to load :( so I'm adding a fallback
    function handleImageLoadErrors(){
        var images = document.querySelectorAll('.track img');
        _.each(images, function(image){
            image.onerror = function(){
                image.src = 'http://placehold.it/128x128/333/eee&text=Image Missing';
            }
        });

    }

    // Scroll to the top of the tracklist
    function scrollToTracks(){
        if( screen.width < 800){
            var top = tracklist.offsetTop - 60;
            window.scrollTo(0, top);
        }
    }

    // Return image and attributes for a lastFM track image
    function thumbnail(images, size, text){
        var newImages = [];
        var sizes = {'extralarge': 300, 'large': 126, 'medium': 64, 'small': 43};
        _.each(images, function(image){
            var width = sizes[image.size];
            var height = sizes[image.size];
            var scale = sizes[image.size] + 'x' + sizes[image.size]; 
            var url = (image['#text'] == '') ? 'http://placehold.it/'+scale+'/333/eee/&text='+encodeURIComponent(text) : image['#text'];
            newImages[image.size] = {
                url: url,
                width: width,
                height: height,
                scale: scale
            }
        });
        return newImages[size];
    }

}());