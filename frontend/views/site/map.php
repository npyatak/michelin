<?php 
use common\models\City;
?>

<div class="page_wrapper">
    <?=$this->render('_city_popup_block', ['showMap' => false]);?>

	<div id="big-map" style="width: 100%; height: 100vh;"></div>

	<div class="video-modal" id="video">
	    <div class="modalType2-content">
	        <div class="video-modal-close"></div>
	        <div id="ytplayer"></div>
	    </div>
	</div>

	<div class="overlay"></div>

<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>

<?php 
$videoCitiesCoords = [];
$videoIds = [];
$imageCitiesCoords = [];
$cityIds = [];

foreach ($cities as $city) {
	if($city->type == City::TYPE_VIDEO) {
		$videoCitiesCoords[] = '['.$city->coord.']';
		$videoIds[] = '"'.$city->video_yt_id.'"';
	} else {
		$imageCitiesCoords[] = '['.$city->coord.']';
		$cityIds[] = '"'.$city->id.'"';
	}
}
$videoCitiesCoords = implode(', ', $videoCitiesCoords);
$videoIds = implode(', ', $videoIds);
$imageCitiesCoords = implode(', ', $imageCitiesCoords);
$cityIds = implode(', ', $cityIds);

$script = "
	var videoIds = [
		$videoIds
	];
	var cityIds = [
		$cityIds
	];
    var videoCitiesCoords = [
	    $videoCitiesCoords
	];
    var imageCitiesCoords = [
	    $imageCitiesCoords
	];

    ymaps.ready(function () {
	    map = new ymaps.Map('big-map', {
	            center: [66.4167, 94.2500],
	            zoom: 3,
	            controls: ['zoomControl', 'fullscreenControl']
	    	});
	    
	    imageCities = new ymaps.GeoObjectCollection();

		for (var i = 0; i < imageCitiesCoords.length; i++) {
		    imageCities.add(new ymaps.Placemark(imageCitiesCoords[i], 
		    	{
			    	hasBaloon: false,
			    	iconColor: 'yellow',
			    	cityId: cityIds[i],
			    }, 
			    {
			    	iconColor: 'yellow'
				}
			));
		}

		map.geoObjects.add(imageCities);

		imageCities.events.add('click', function (e) {
			loadCityData(e.get('target').properties.get('cityId'));
		});

	    videoCities = new ymaps.GeoObjectCollection();

		for (var i = 0; i < videoCitiesCoords.length; i++) {
		    videoCities.add(new ymaps.Placemark(videoCitiesCoords[i], {
		    	hasBaloon: false,
		    	videoId: videoIds[i],
		    }));
		}

		map.geoObjects.add(videoCities);

		videoCities.events.add('click', function (e) {
			$('.city').hide();
			playVideo(e.get('target').properties.get('videoId'));
		});
	});
";?>

<?php $this->registerJs($script, yii\web\View::POS_END);?>