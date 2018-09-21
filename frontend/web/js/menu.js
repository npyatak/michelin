$(document).ready(function () {
    console.log('Menu is ready');
    $('.toggle-menu').click(function (e) {
        e.preventDefault();
        var element = $(this).children('img.fa-bars');
        var condition = element.hasClass('now-active');
        toggleMenu();
        var action = condition ? showMenu() : hideMenu();
    });
    var toggleMenu = function toggleMenu() {
        var iconOpen = $('.toggle-menu').children('img.fa-bars');
        var iconClose = $('.toggle-menu').children('img.fa-times');
        iconOpen.toggleClass('now-active');
        iconClose.toggleClass('now-active');
        $('html').toggleClass('not-scrollable');
        $('body').toggleClass('not-scrollable');
    };
    var hideMenu = function hideMenu() {
        var hiddenMenu = $('.hidden-menu');
        hiddenMenu.fadeOut('fast', function () {
            hiddenMenu.addClass('hidden');
        });
    };
    var showMenu = function showMenu() {
        var hiddenMenu = $('.hidden-menu');
        hiddenMenu.fadeIn('fast', function () {
            hiddenMenu.removeClass('hidden');
        });
    };
})