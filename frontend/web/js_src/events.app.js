/**
 * Events
 * Модуль описывает функционал работы с событиями: нажатие на кнопку, окончание работы таймера и т.д.
 *
 * @module events
 */

window.App = (function (app) {

    app.events = {};

    app.events.commonEvents = function () {


        app.auth.emailBinds(function () {
            location.reload();
        });

        $(".auth_only_link").click(function (e) {
            e.preventDefault();
            let $this = $(this);

            app.helper.authUser(function () {
                location.href = $this.attr('href');
            });
        });
    };

    app.events.startScreenEventHandlers = function () {

        // кнопка старта
        app.events.startButtonHandler($('.start_quiz'));
    };

    app.events.startButtonHandler = function (elem_obj) {

        elem_obj.click(function () {
            if ($(this).is('.disabled')) {
                return;
            }
            $(this).addClass('disabled');
            app.helper.authUser(function () {
                if (elem_obj.is('.get_question')) {
                    app.controller.quizQuestionScreen();
                    return;
                }
                app.controller.quizWarningScreen();
            });
        });

    };

    app.events.questionScreenEvents = function () {

        let question_screen_html_jobj = $('#question-page');

        question_screen_html_jobj.find('.answer-item').click(app.controller.quizAnswerScreen);

        let init_time_seconds = app.conf.time_limit_sec;

        app.helper.initSimpleCounter(question_screen_html_jobj, init_time_seconds);

    };

    app.events.answerScreen = function () {


        app.$elem.quiz_wrapper.find('.next-question-button').click(function () {
            if ($(this).is('.disabled')) {
                return;
            }
            $(this).addClass('disabled');

            if ($(this).is('.finish-button')) {
                $.when(app.model.player.fetch()).then(function () {
                    app.controller.quizResultsScreen();
                });
                return;
            }

            //ga('Rexona2018.send', 'pageview', {'dimension2': "next_question"});
            app.controller.quizQuestionScreen();
        });

    };

    return app;

})(App || {});