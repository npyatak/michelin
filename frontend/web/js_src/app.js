"use strict";

window.$ = require('jquery');
window.jQuery = $;


var tire = require('./tire.module');

require("babel-polyfill");

window.App = (function (app) {
    app.conf = {
        template_pre_url: '/Michelin2018/templates/',
        project_url: '/michelin2018',
        question_limit: 10,
        time_limit_sec: 30,
        templates: {
            game_start_screen: "game_start_screen.html",
            game_warning_screen: "game_warning_screen.html",
            game_question_screen: "game_question_screen.html",
            game_result_screen: "game_result_screen.html",
            game_timeout_popup: "game_timeout_popup.html",
            popup_upload: "popup_upload.html",
            auth_popup: 'popup_auth.html',
            auth_popup_email: 'popup_auth_email.html'
        }
    };

    app.state = {
        social_auth_window_obj: null,
        counter_interval: 0,
        counter_ms_interval: 0,
        request_pre_url: '/michelin2018'
    };

    app.elem = {
        quiz_wrapper: "#quiz_wrapper",
    };

    app.init = function () {
        $.when(app.request.getCityNames()).then(function (city_names) {
            jQuery(function () {
                tire.init(city_names)
            });
        });


        $(document).on('click', ' .text-label ', function () {
            console.log(this);
        });


        $(function () {
            $(".main_menu a[href='" + location.pathname + "']").addClass('active');
        });
    };
    return app;
})({});


//= controller.app.js
//= events.app.js
//= helper.app.js
//= model.app.js
//= request.app.js
// = collection.app.js


App.init();
