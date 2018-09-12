var SimpleScrollbar = require('simple-scrollbar');


module.exports = (function () {


    var marker_el_count = 15;
    var marker_count = 130;


    var tire_div = "#tire";

    var tire_offset = 0;
    var frame_count = 13;

    var initial_tire_div_width = 0;

    function init(city_names) {

        tire_div = $(tire_div);
        tire_div.addClass('frame-0000');

        initial_tire_div_width = tire_div.width();
        updateTireDivScale();
        createMarkers(city_names);
        bindEvents();
    };

    function createMarkers(city_names) {

        var markers_added = 0;

        $.each(city_names, function (city_id, city_name) {

            markers_added++;
            var i = markers_added;
            tire_div.append('<div class="marker marker' + i + ' marker_type_' + this.type + '" data-index="' + i + '" data-city_id="' + this.id + '"><span>' + this.name + '</span></div>');

            if (markers_added >= marker_el_count) {
                return false;
            }

        });
    }

    function updateTireDivScale() {
        var scale = $(window).width() / initial_tire_div_width;
        tire_div.css('transform', 'scale(' + scale + ')');
    }

    function changeRotation(offset) {

        tire_offset += offset;


        if (tire_offset < 0) {
            tire_offset = frame_count;
        }

        tire_div.removeAttr('class');

        var frame_num = tire_offset % frame_count;

        if (frame_num < 10) {
            frame_num = "0" + frame_num;
        }

        if (frame_num > frame_count) {
            frame_num = "00";
        }


        tire_div.addClass("frame-00" + frame_num);
    }

    function bindEvents() {

        $(document).on('wheel', function (e) {
            if (e.originalEvent.deltaY > 0) {
                changeRotation(1);
            }
            else if (e.originalEvent.deltaY < 0) {
                changeRotation(-1);
            }
        });

        $('body').on('click', function (e) {
            e.stopPropagation();
            $('.main_screen').show();
            $(".marker").removeClass('active');
            $(".city").hide();
            $(".city").find(".city_img iframe").attr("src", '');


        });

        $(".city").on('click', function (e) {
            e.stopPropagation();
        });

        var isDragging = false;
        var previousMousePositionY = 0;

        tire_div.on('mousedown', function (e) {
            isDragging = true;
        }).on('mousemove', function (e) {

            e.offsetY = e.pageY - tire_div.offset().top;

            var deltaMoveY = e.offsetY - previousMousePositionY;

            if (isDragging) {

                if (deltaMoveY > 25) {
                    changeRotation(1);
                }
                else if (deltaMoveY < -25) {
                    changeRotation(-1);
                }
                else {
                    return;
                }
            }

            previousMousePositionY = e.offsetY;

        });
        $(document).on('mouseup', function () {
            isDragging = false;
        });
        // $(window).on('resize', updateTireDivScale);

        tire_div.find('.marker').on('click', onMarkerClick);

    }


    function onMarkerClick(e) {

        e.preventDefault();
        e.stopPropagation();

        var marker_el = $(this);

        var city_id = marker_el.data('city_id');

        $('.main_screen').hide();

        var text_block = $(".text_block");


        $.when(App.request.getCityData(city_id)).then(function (data) {

            $(".marker").removeClass('active');
            marker_el.addClass('active');

            $(".city").show();

            $(".city").attr('data-type', data.type);

            var video_url = '';

            if (data.type == 1) {
                video_url = 'https://www.youtube.com/embed/' + data.yt_id + '?rel=0&amp;controls=0&amp;showinfo=0';
            }

            text_block.find(".city-title").html(data.name);
            text_block.find(".text").html(data.descr);
            text_block.find(".city_img div").css("background-image", "url('/Michelin2018/assets/img/city/" + city_id + ".jpg')");
            text_block.find(".city_img iframe").attr("src", video_url);
            text_block.find(".text").attr('ss-container', true);

            $('.scores.scores_1').attr('data-score', data.score1);
            $('.scores.scores_2').attr('data-score', data.score2);
            $('.scores.scores_3').attr('data-score', data.score3);

            SimpleScrollbar.initAll();
        });

    }

    return {
        init: init
    }

})();