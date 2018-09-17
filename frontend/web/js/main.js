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
        .on('click', '.video-modal-close', function (e) {
            e.preventDefault();
            $(this).closest('.video-modal').fadeOut(100);
            $('body').removeClass('overflow');
            $(document).find('.overlay').fadeOut(100);
            window.player.stopVideo();
        })
        .on('click', '.play-video', function (e) {
            e.preventDefault();
            $('.city').hide();
            $('.main_screen, .main_top').show();
            playVideo($(this).data('id'));
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