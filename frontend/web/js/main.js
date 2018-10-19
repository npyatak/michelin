var map;

function playVideo(id) {
    $('body').addClass('overflow');
    $(document).find('.overlay').fadeIn(100);
    var modal = $(document).find('.video-modal');
    modal.fadeIn(100);

    window.player.loadVideoById(id);
    window.player.playVideo();
}

function loadCityData(city_id) {
    $.when(window.App.request.getCityData(city_id)).then(function (data) {
        $(".marker").removeClass('active');

        if (data.type == 1) {
            $('.city').find('.play-video').attr('data-id', data.yt_id).trigger("refresh").show();
            $('.city').find('.text_block').addClass('show-video');
            //window.player.loadVideoById(data.yt_id);
            //playVideo(data.yt_id);
            //video_url = 'https://www.youtube.com/embed/' + data.yt_id + '?rel=0&amp;controls=0&amp;showinfo=0';
        } else {
            $('.city').find('.play-video').hide();
            $('.city').find('.text_block').removeClass('show-video');
        }

        $('.main_screen, .main_top').css("opacity","0");
        $(".city").show();

        $(".city").attr('data-type', data.type);


        $('.text_block').find(".city-title").html(data.name);
        $('.text_block').find(".wrap").html(data.descr);
        $('.text_block').find(".city_img .video").css("background-image", "url('"+window.pre_url+"/img/city/" + city_id + ".jpg')");
        $('.text_block').find(".text").attr('ss-container', true);

        var str = '';
        if(!$.isEmptyObject(data.people)) {
            $.each(data.people, function(index, value){
                str += '<div class="'+value.class+'">'+value.name+'</div>';
            });
        }
        $('.city .peoples').html(str);

        $('.scores.scores_1').attr('data-score', data.score1);
        $('.scores.scores_2').attr('data-score', data.score2);
        $('.scores.scores_3').attr('data-score', data.score3);

        $('.show-map-link').attr('data-coord', data.coord);

        SimpleScrollbar.initAll();
    });

    $(".niceScroll").slimScroll({
        destroy: true
    });
    $(".niceScroll").css("height","auto");
    
    setTimeout(function() { 
        if( $(".niceScroll").height() > "130" ){
            $('.city').find(".niceScroll").slimScroll({
                height: "140px",
                size: '5px',
                position: 'right',
                color: '#fff',
                alwaysVisible: true,
                railVisible: true,
                railColor: '#5D84BD',
                railOpacity: 0.3,
                wheelStep: 10,
                allowPageScroll: true,
                disableFadeOut: true
            });
        }
    }, 200);

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
            // $('.main_screen, .main_top').css("opacity","1");
            playVideo($(this).attr('data-id'));
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
            openMap($(this).attr('data-coord'));
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
            videoId: '042UyeWlC5I',
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
    },2000);

    $('.fileinput').find('span.fileinput-new')
        .html('Прикрепить фото +')
        .css({'display':'block'});

    $(document).on('click','.confirm-btn',function (e) {
        e.preventDefault();
        $('.confirm-upload').css({'display': 'none'});
        $('.overlay').css({'display': 'none'});
    })
});

// let map = 'undefined';

function openMap(coord) {
    if(typeof map !== 'undefined') {
        try {
            map.destroy();
        } catch (err) {
          console.log("Не получилось удалить карту или она не существуетж");
        }
    }
    //$('#map').html('');
    $('body').addClass('overflow');
    $(document).find('.overlay').fadeIn(100);
    $('.map-modal').fadeIn(100);
    // $('.main_screen, .main_top').show();
    // $('.main_screen, .main_top').css("opacity","1");

    coords = coord.split(',');

    map = new ymaps.Map('map', {
            center: coords,
            zoom: 10,
            controls: ['zoomControl', 'fullscreenControl']
        });

    myPlacemark = new ymaps.Placemark(map.getCenter());

    map.geoObjects.add(myPlacemark);
}


$('.close-popup').click(function () {
    // $('.main_screen, .main_top').show();
    $('.main_screen, .main_top').css("opacity","1");
    $(".marker").removeClass('active');
    $(".city").hide();
});
$(document).on('click', '.auth .close-popup', function(e) {
    $('.start-question').show();
    $('.auth').hide();
    $('.overlay').hide();

    return false;
});