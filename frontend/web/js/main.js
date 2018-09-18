function playVideo(id) {
    $('body').addClass('overflow');
    $(document).find('.overlay').fadeIn(100);
    var modal = $(document).find('.video-modal');
    modal.fadeIn(100);

    window.player.loadVideoById(id);
    window.player.playVideo();
}

$(document).ready(function () {

    $(this)
        .on('click', '.map-modal-close', function (e) {
            e.preventDefault();
            $(this).closest('.map-modal').fadeOut(100);
            $('body').removeClass('overflow');
            $(document).find('.overlay').fadeOut(100);
        })
        .on('click', '.play-video', function (e) {
            e.preventDefault();
            $('.city').hide();
            $('.main_screen, .main_top').show();
            playVideo($(this).data('id'));
        })
        .on('click', '.video-modal-close', function (e) {
            e.preventDefault();
            $(this).closest('.video-modal').fadeOut(100);
            $('body').removeClass('overflow');
            $(document).find('.overlay').fadeOut(100);
            window.player.stopVideo();
        })
        .on('click', '.show-map-link', function(e) {
            e.preventDefault();
            openMap($(this).data('coord'));
        });
});

$(window).on('load', function() {
    var tag = document.createElement('script');
    tag.src = "//www.youtube.com/player_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    window.player = '';

    window.onYouTubePlayerAPIReady = function() {
        player = new YT.Player('ytplayer', {
            height: '360',
            width: '640',
            videoId: '3K76Y5qBzfw',
            playerVars: {
                controls: 0,
                rel: 0,
                modestbranding: 1,
                showinfo: 0,
            }
        });
    };
});
 

function openMap(coord) {
    $('body').addClass('overflow');
    $(document).find('.overlay').fadeIn(100);
    $('.map-modal').fadeIn(100);
    $('.city').hide();
    $('.main_screen, .main_top').show();

    coords = coord.split(',');

    var myMap = new ymaps.Map('map', {
            center: coords,
            zoom: 10
        }, {
            searchControlProvider: 'yandex#search'
        }),
        MyIconContentLayout = ymaps.templateLayoutFactory.createClass(
            '<div style="color: #FFFFFF; font-weight: bold;">$[properties.iconContent]</div>'
        ),

        myPlacemark = new ymaps.Placemark(myMap.getCenter());

    myMap.geoObjects
        .add(myPlacemark);
    myMap.behaviors.disable('scrollZoom', 'Drag');
}

$(".niceScroll").slimScroll({
    size: '5px',
    position: 'right',
    color: '#fff',
    alwaysVisible: true,
    railVisible: true,
    railColor: '#5D84BD',
    railOpacity: 0.3,
    wheelStep: 10,
    allowPageScroll: true,
    disableFadeOut: false
});

$('.close-popup').click(function () {
    $('.main_screen, .main_top').show();
    $(".marker").removeClass('active');
    $(".city").hide();
});