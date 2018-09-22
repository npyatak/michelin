<div id="map" style="width: 100%; height: 100vh;"></div>

<div class="video-modal" id="video">
    <div class="modalType2-content">
        <div class="video-modal-close"></div>
        <div id="ytplayer"></div>
    </div>
</div>

<div class="overlay"></div>

<script src="//api-maps.yandex.ru/2.1/?lang=en_RU" type="text/javascript"></script>

<?php $coords = [];
$videoIds = [];
foreach ($cities as $city) {
	$coords[] = '['.$city->coord.']';
	$videoIds[] = '"'.$city->video_yt_id.'"';
}
$coords = implode(', ', $coords);
$videoIds = implode(', ', $videoIds);
$script = "
	var videoIds = [
		$videoIds
	];

    ymaps.ready(function () {
	    map = new ymaps.Map('map', {
	            center: [66.4167, 94.2500],
	            zoom: 3
	        }, {
	            searchControlProvider: 'yandex#search'
	        });

	    var coords = [
		    $coords
		],

	    myCollection = new ymaps.GeoObjectCollection({}, {

	    });

		for (var i = 0; i < coords.length; i++) {
		    myCollection.add(new ymaps.Placemark(coords[i], {
		    	hasBaloon: false,
		    	videoId: videoIds[i],
		    }));
		}

		map.geoObjects.add(myCollection);

		myCollection.events.add('click', function (e) {
			playVideo(e.get('target').properties.get('videoId'));
		});
	});
";?>

<?php $this->registerJs($script, yii\web\View::POS_END);?>