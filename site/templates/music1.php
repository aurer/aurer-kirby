<!DOCTYPE html>
<html lang="en" ng-app="lastFmApp">
    <head>
        <?= snippet('head') ?>
    </head>
    <body class="<?= $page->template() ?>">
        
        <?= snippet('mast') ?>
    	
        <section class="main">
      		<div class="row">
                <div class="content">
                    <h1><?= html($page->title()) ?></h1>
                    <?= kirbytext($page->text()) ?>

                    <div class="music-tracks" ng-controller="lastController">
                        <div ng-show="loading">Loading...</div>
                        <ul ng-repeat="track in tracks">
                            <li class="track">
                                <a href="{{track.url}}" title="View this track on Last.FM" target="_blank">
                                    <img src="{{track.thumbnail.url}}" width="{{track.thumbnail.width}}" height="{{track.thumbnail.height}}" alt="{{track.name}} album image">
                                    <b class="trackname">{{track.name}}</b>
                                    <span class="trackartist">{{track.artist}}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular.min.js"></script>
        <script>window.angular || document.write('<script src="/assets/src/js/vendor/angular-1.2.18.min.js"><\/script>')</script>
        <script>
            var lastFmApi = "http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user=philmau&api_key=ccfce33b35f8480c2413f2a642fa2c6a&format=json";
            var app = angular.module('lastFmApp', []);

            app.controller('lastController', function($scope, $http){
                $scope.loading = true;
                $http.get(lastFmApi).success(function(data, status, headers, config){
                    var tracks = []
                    angular.forEach(data.recenttracks.track, function(track){
                        var newTrack = {};
                        newTrack.name = track.name;
                        newTrack.artist = track.artist['#text'];
                        newTrack.album = track.album['#text'];
                        newTrack.url = track.url;
                        newTrack.thumbnail = thumbnail(track.image, 'large', newTrack.album);
                        tracks.push(newTrack);
                    });
                    $scope.loading = false;
                    $scope.tracks = tracks;
                });
            });
            
            // Return image and attributes for a lastFM track image
            function thumbnail(images, size, album){
                var newImages = [];
                var sizes = {'extralarge': 300, 'large': 126, 'medium': 64, 'small': 43};
                angular.forEach(images, function(image){
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
        </script>

        <?= snippet('foot') ?>
    
    </body>
</html>