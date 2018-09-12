"use strict";

let $ = require('jquery');

module.exports = function (popup_wrapper_el) {


    let scrollTop_after_close = 0;

    let wrapper_el = $(popup_wrapper_el);

    if (wrapper_el.length == 0) {
        throw  new Error("No popup wrapper el");
    }

    function show(html, callback, hide_callback) {

        let body = $('body');
        scrollTop_after_close = body.scrollTop();
        body.addClass('popup-show');

        wrapper_el.html(html).addClass('render');
        setTimeout(function () {

            // let height = _this.wrapper_el.find(' > .popup-content').height();
            // if ((_this.wrapper_el.height() - 100) > height) {
            //     _this.wrapper_el.find(' > * ').height(height);
            // } else {
            //     _this.wrapper_el.find(' > * ').height(_this.wrapper_el.height() - 100);
            // }

            wrapper_el.addClass('show');
            wrapper_el.find(' > * ').on('click', function (e) {
                e.stopPropagation();
            });

            wrapper_el.unbind('click').one('click', function () {
                hide(hide_callback);
            });

            addCloseBtn();

            if (callback) {
                callback();
            }
        }, 100);
    }

    function hide(callback) {
        wrapper_el.html('').removeClass('render show');
        $('body').removeClass('popup-show').scrollTop(scrollTop_after_close);
        if (callback) {
            callback();
        }
    }

    function addCloseBtn() {
        //var $btn = $('<svg class="popup-close svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="50px" height="50px"><circle cx="256" cy="256" r="253.44"/><path d="M350.019,144.066l17.521,17.522c6.047,6.047,6.047,15.852,0,21.9L183.607,367.419c-6.047,6.048-15.852,6.047-21.9,0l-17.521-17.522c-6.047-6.047-6.047-15.852,0-21.9l183.932-183.933C334.166,138.018,343.971,138.018,350.019,144.066z"/><path d="M367.54,349.899l-17.522,17.522c-6.047,6.047-15.852,6.047-21.9,0L144.186,183.488c-6.047-6.047-6.047-15.852,0-21.9l17.522-17.522c6.047-6.047,15.852-6.047,21.9,0L367.54,327.999C373.588,334.047,373.588,343.852,367.54,349.899z"/></svg>');
        let $btn = $('.close-modal');
        $btn.on('click', function () {
            hide();
        }); //.appendTo(this.wrapper_el.find('.popup-content'));
    }

    return {
        show: show,
        hide: hide,
        addCloseBtn: addCloseBtn
    }
};
