/**
 * Helper
 * Вспомогательные функции для работы с приложением
 *
 * @module helper
 */

window.App = (function (app) {

    app.helper = {};


    app.helper.authPopupClosed = function () {

        // TODO

        $(document).one('cbox_closed ', function () {
            app.init(global_cache_killer_pre_url, global_request_pre_url);
        });

    };

    app.helper.assetLink = function (asset_url) {

        return app.state.cache_killer_pre_url + asset_url;

    };

    app.helper.convertMillitsToFormatedString = function (milliseconds) {

        milliseconds = parseInt(milliseconds);
        var result_date_obj = new Date(milliseconds);
        var result_time_string = result_date_obj.getMinutes() + '\'' + result_date_obj.getSeconds() + '\'\'' + result_date_obj.getMilliseconds();
        return result_time_string;

    };

    app.helper.showTimeoutPopup = function () {

        let social_popup_html = app.helper.getPartialTemplateHTML('game_timeout_popup');
        app.model.player.fetch();
        app.Popup.show(social_popup_html, null,
            function () {
                if (app.model.question.get('counter') == app.conf.question_limit) {
                    app.controller.quizResultsScreen();
                } else {
                    app.controller.quizQuestionScreen();
                }
            });

    };

    app.helper.format_plural = function (n, pluralForms) {
        if (n % 10 == 1 && n % 100 != 11) {
            return pluralForms[0];
        }
        if (n % 10 >= 2 && n % 10 <= 4 && (n % 100 < 10 || n % 100 >= 20)) {
            return pluralForms[1];
        }
        return pluralForms[2];
    };

    /**
     * Обратный счетчик, выдающий 2 цифры секунд и 2 цифры миллисекунд
     *
     *
     * @param question_screen_html_jobj
     * @param init_time_seconds
     */
    app.helper.initSimpleCounter = function (question_screen_html_jobj, init_time_seconds) {

        app.helper.simpleCounter.init(question_screen_html_jobj.find('.timer'), init_time_seconds, app.helper.showTimeoutPopup);

    };

    app.helper.simpleCounter = {

        conf: {
            container_jquery_obj: '',
            initial_seconds: 30,
            initial_millisec: 99,
            timeout_callback: {}
        },

        state: {
            counter_ms_interval: 0,
            counter_interval: 0,
            seconds: 30,
            millisec: 0
        },

        init: function (container_jquery_obj, initial_seconds, timeout_callback) {

            app.helper.simpleCounter.conf.container_jquery_obj = container_jquery_obj;
            app.helper.simpleCounter.conf.initial_seconds = initial_seconds;
            app.helper.simpleCounter.conf.timeout_callback = timeout_callback;
            app.helper.simpleCounter.conf.initial_millisec = app.helper.simpleCounter.conf.initial_seconds * 1000;

            app.helper.simpleCounter.state.seconds = app.helper.simpleCounter.conf.initial_seconds;
            app.helper.simpleCounter.state.millisec = app.helper.simpleCounter.conf.initial_millisec;

            app.helper.simpleCounter.setCounterToHTML(app.helper.simpleCounter.conf.initial_seconds, app.helper.simpleCounter.conf.initial_millisec);

            app.helper.simpleCounter.state.counter_interval = setInterval(app.helper.simpleCounter.counter_interval_iteration, 1000);
            app.helper.simpleCounter.state.counter_ms_interval = setInterval(app.helper.simpleCounter.millisec_counter_iteration, 130);

            app.helper.simpleCounter.counter_interval_iteration();

        },

        // запись данных в dom
        setCounterToHTML: function (seconds, milliseconds) {

            if ((seconds || seconds == 0) && (milliseconds || milliseconds == 0)) {
                var html = '<span class="time-s">' + seconds + '.</span><span class="time-ms">' + app.helper.simpleCounter.getTwoDigitsFromMillisec(milliseconds) + '</span>';
                app.helper.simpleCounter.conf.container_jquery_obj.html(html);
            }

            if (!seconds && milliseconds) {
                app.helper.simpleCounter.conf.container_jquery_obj.find('.time-ms').html(app.helper.simpleCounter.getTwoDigitsFromMillisec(milliseconds));
            }
            if (seconds && !milliseconds) {
                app.helper.simpleCounter.conf.container_jquery_obj.html(seconds);
            }
        },

        // итерация секунд
        counter_interval_iteration: function () {
            app.helper.simpleCounter.state.seconds--;
            var output_seconds = app.helper.simpleCounter.state.seconds;
            if (app.helper.simpleCounter.state.seconds < 10) {
                output_seconds = '0' + app.helper.simpleCounter.state.seconds;
            }
            app.helper.simpleCounter.setCounterToHTML(output_seconds, app.helper.simpleCounter.state.millisec);
            if (app.helper.simpleCounter.state.seconds == 0) {
                clearInterval(app.helper.simpleCounter.state.counter_interval);
                clearInterval(app.helper.simpleCounter.state.counter_ms_interval);
                app.helper.simpleCounter.setCounterToHTML('00', '00');
                app.helper.simpleCounter.conf.timeout_callback();
            }
        },

        // итерация миллисекунд
        millisec_counter_iteration: function () {
            app.helper.simpleCounter.state.millisec -= 13;
            app.helper.simpleCounter.setCounterToHTML(null, app.helper.simpleCounter.state.millisec);
        },

        // форматирование миллисекунд до 2х цифр
        getTwoDigitsFromMillisec: function (millisec) {
            var output_millisec = '' + millisec;
            if (millisec < 10) {
                output_millisec = '0' + millisec;
            }
            return output_millisec.substr(output_millisec.length - 2);
        }

    };

    app.helper.getIEVersion = function () {
        var myNav = navigator.userAgent.toLowerCase();
        return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
    };

    app.helper.getMobile = function () {
        return window.matchMedia('(max-width: 1023px)').matches;
    };


    app.helper.showTemplate = function (templateName, params) {

        var html = $(app.template.render(templateName, params));

        app.$elem.quiz_wrapper.html(html);
    };

    app.helper.getPartialTemplateHTML = function (templateName, params) {
        return app.template.render(templateName, params);
    };


    app.helper.authUser = function (callback) {

        if (!app.model.player.id) {
            app.auth.showAuthPopup(function () {
                location.reload()
            });
            return;
        }

        //if (!app.model.player.email) {
        //    app.auth.showEnterEmailPopup(function () {
        //        location.reload()
        //    });
        //    return;
        //}

        callback();

    };

    app.auth = {};

    app.auth.showAuthPopup = function (end_callback) {
        let html = $(app.helper.getPartialTemplateHTML('auth_popup'));
        app.auth.binds(html, end_callback);
        app.Popup.show(html);
    };

    app.auth.showEnterEmailPopup = function (end_callback) {
        let html = $(app.helper.getPartialTemplateHTML('auth_popup_email'));
        app.auth.emailBinds(html, end_callback);
        app.Popup.show(html);
    };

    app.auth.emailBinds = function ( success_callback) {

        $('.enter_email_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '/rexona2018/auth/save_email',
                method: "POST",
                data: {email: $(".enter_email_form").find('[name=email]').val()}
            }).done(function (data) {
                if (data.status == 'success') {
                    $.when(app.model.player.fetch()).done(function () {
                        success_callback();
                    });
                }

                if (data.status == 'error' && data.code == 1) {
                    $(".enter_email_form").find('.email_error').text('Введите свой e-mail');
                }
                if (data.status == 'error' && data.code == 2) {
                    $(".enter_email_form").find('.email_error').text('Введите корректный e-mail');
                }
                if (data.status == 'error' && data.code == 3) {
                    $(".enter_email_form").find('.email_error').text('Произошла ошибка');
                }
            });
        });
    };

    app.auth.binds = function (html, end_callback) {

        html.find('.auth-popup-links li').click(function () {
            var providerName = $(this).attr('data-provider-name');
            var url = '/rexona2018/auth/gate?Provider=' + providerName + '&destination=http://matchtv.ru/rexona2018/auth/finish_page';
            app.state.social_auth_window_obj = window.open(url, 'Авторизация', "width=656, height=480");
            if (app.state.social_auth_window_obj) {

                if (app.auth.check_cookie_interval) {
                    clearInterval(app.auth.check_cookie_interval);
                }

                app.auth.check_cookie_interval = setInterval(function () {

                    if (document.cookie.match('popup_auth_success')) {
                        document.cookie = 'popup_auth_success=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                        $.when(app.model.player.fetch()).done(function () {
                            end_callback();
                        });

                        clearInterval(app.auth.check_cookie_interval);
                    }

                }, 1000);
            }
        });

    };


    app.helper.uploadBarcode = function (e) {
        e.preventDefault();

        let url = app.conf.project_url + "/ajax/upload_barcode";

        let img_input = $(".upload-form .upload-img-file");
        let text_unput = $(".upload-form .enter_manual");
        let send_btn = $(".upload-form .upload-send-btn");
        let upload_inner = $(".upload-inner");

        if (!img_input.val() && !text_unput.val()) {
            return;
        }

        if (!img_input.val() && text_unput.val()) {
            $.post(url, {enter_manual: text_unput.val()}, onSuccess);
            return;
        }

        send_btn.attr("disabled", "disabled");

        img_input.simpleUpload(app.conf.project_url + "/ajax/upload_barcode", {
            data: {enter_manual: text_unput.val()},
            success: onSuccess
        });

        function onSuccess(data) {
            if (data.status === "ok") {
                upload_inner.html(data.text);
            }
            else {
                upload_inner.html(data.message);
            }
        }

    };


    return app;

})(App || {});