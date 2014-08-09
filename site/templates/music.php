<?php c::set('html-attr', 'ng-app="lastFmApp"') ?>
<?= snippet('header') ?>
    	
        <section class="main">
      		<div class="row">
                <div class="content">
                    <h1><?= html($page->title()) ?></h1>
                    <?= kirbytext($page->text()) ?>

                    <div class="music-tracks" ng-controller="lastController">
                        <div class="load-icon"><?= snippet('loading') ?></div>
                        <div class="track-list"><!-- Tracks loaded here --></div>
                    </div>

                </div>
            </div>
        </section>
        <script src="/assets/src/js/vendor/quest.js"></script>
        <script src="/assets/src/js/vendor/underscore.js"></script>
        <script>
        (function(window){
            var lastFm = "http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user=philmau&api_key=ccfce33b35f8480c2413f2a642fa2c6a&format=json";
            var template = "/assets/views/track.html";
            var tracklist = document.querySelector('.track-list');
            var loadingIcon = document.querySelector('.load-icon');
            var currentPage = 1;
            var totalPages = 1;
            
            // Load the track template html
            qwest.get(template, {}, {type: 'html'}).success(function(templateData){
                template = templateData;
                getTracks(templateData);   
            });

            // Fetch paged tracks from LastFM API and render on page
            function getTracks(template, page){
                var page = page || 1;
                loadingIcon.className = loadingIcon.className.replace(' hidden', '');
                qwest.get(lastFm, {page: page}, {type: 'json'}).success(function(trackData){
                    // Remove the loading icon
                    loadingIcon.className += ' hidden';

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
                        track.thumbnail = thumbnail(item.image, 'large', track.album);
                        tracks.push(track);
                        
                    });
                    var compiled = _.template(template);
                    var html = compiled({tracks: tracks});
                    tracklist.innerHTML += html;
                    addPagination();
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
                    nextButton.textContent = 'Next';
                    nextButton.onclick = function(){getTracks(template, ++currentPage)}

                var prevButton = document.createElement('button')
                    prevButton.className = 'btn';
                    prevButton.id = 'prev-page';
                    prevButton.textContent = 'Prev';
                    prevButton.onclick = function(){getTracks(template, --currentPage)}
                
                pagination.appendChild(prevButton)
                pagination.appendChild(nextButton);
                tracklist.appendChild(pagination);
            }

            // Return image and attributes for a lastFM track image
            function thumbnail(images, size, album){
                var newImages = [];
                var sizes = {'extralarge': 300, 'large': 126, 'medium': 64, 'small': 43};
                _.each(images, function(image){
                    var width = sizes[image.size];
                    var height = sizes[image.size];
                    var scale = sizes[image.size] + 'x' + sizes[image.size]; 
                    var url = (image['#text'] == '') ? 'http://placehold.it/'+scale+'/333/eee/&text='+encodeURIComponent(album) : image['#text'];
                    newImages[image.size] = {
                        url: url,
                        width: width,
                        height: height,
                        scale: scale
                    }
                });
                return newImages[size];
            }

        }(window));
        </script>

<?= snippet('footer') ?>