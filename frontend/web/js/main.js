var map;

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
            $('.marker').removeClass('active');
        })
        .on('click', '.play-video', function (e) {
            e.preventDefault();
            // $('.main_screen, .main_top').show();
            $('.main_screen, .main_top').css("opacity","1");
            playVideo($(this).data('id'));
        })
        .on('click', '.video-modal-close', function (e) {
            e.preventDefault();
            $(this).closest('.video-modal').fadeOut(100);
            $('body').removeClass('overflow');
            $(document).find('.overlay').fadeOut(100);
            window.player.stopVideo();
            $('.marker').removeClass('active');
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
            videoId: 'VZNllpqMNCo',
            playerVars: {
                controls: 0,
                rel: 0,
                modestbranding: 1,
                showinfo: 0,
            }
        });
    };

    setTimeout(function () {
        if(window.page !== 'undefined'){
            $('#about-play-video').click()
            // playVideo($(this).data('id'));
        }
    },2000)
});
 

function openMap(coord) {
    if(typeof map !== 'undefined') {
        map.destroy();
    }
    //$('#map').html('');
    $('body').addClass('overflow');
    $(document).find('.overlay').fadeIn(100);
    $('.map-modal').fadeIn(100);
    // $('.main_screen, .main_top').show();
    $('.main_screen, .main_top').css("opacity","1");

    coords = coord.split(',');

    map = new ymaps.Map('map', {
            center: coords,
            zoom: 10
        }, {
            searchControlProvider: 'yandex#search'
        });

    myPlacemark = new ymaps.Placemark(map.getCenter());

    map.geoObjects.add(myPlacemark);
}

$('.city').find(".niceScroll").slimScroll({
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
    // $('.main_screen, .main_top').show();
    $('.main_screen, .main_top').css("opacity","1");
    $(".marker").removeClass('active');
    $(".city").hide();
});