/**
 * Controller
 * Модуль контроллеров
 *
 * @module controller
 */


window.App = (function (app) {

    app.controller = {};

    app.controller.index = function () {

        app.events.commonEvents();
    };

    /**
     * Начальный экран игры
     */
    app.controller.quizStartScreen = function () {
        if (app.model.player.last_game_result.place) {
            app.controller.quizResultsScreen();
            return;
        }
        app.helper.showTemplate('game_start_screen', {});

        app.events.startScreenEventHandlers();
    };

    /**
     * Начальный с предупреждением перед началом
     */
    app.controller.quizWarningScreen = function () {

        app.helper.showTemplate('game_warning_screen');

        app.events.startScreenEventHandlers();
    };

    /**
     * Экран с вопросом
     *
     */
    app.controller.quizQuestionScreen = function () {

        app.request.getRandomQuestion(function (question_response) {

            app.model.question.setFromJSON(question_response.data);
            app.helper.showTemplate('game_question_screen', question_response.data);
            app.events.questionScreenEvents();


        }, function (response) {
            alert(response.message);
        });

    };

    /**
     * Экран с ответом на вопрос
     */
    app.controller.quizAnswerScreen = function () {

        clearInterval(app.helper.simpleCounter.state.counter_interval);
        clearInterval(app.helper.simpleCounter.state.counter_ms_interval);
        var clickElem = $(this);

        app.request.answerQuestion($(this).attr('data-answer-id'), function (answer_response) {

            $('#question-page').find('.answer-item').unbind();

            if (answer_response.data.is_right_answer) {
                clickElem.addClass('right');
            } else {
                clickElem.addClass('wrong');
            }

            if (answer_response.data.game_is_finished) {
                $('.answers-list').append('<div class="finish-button next-question-button">Далее</div>');
            } else {
                $('.answers-list').append('<div class="next-question-button">Далее</div>');
            }

            app.events.answerScreen();

        });


    };

    app.controller.quizResultsScreen = function () {


        $.when(
            app.request.getTopPlayerList()
        ).then(function (player_list) {

            let allow_replay = false;

            // TODO
            //if (app.model.stage.status == 'active' && !app.model.stage.played) {
            //    allow_replay = true;
            //}
            app.helper.showTemplate('game_result_screen', {
                result: app.model.player.last_logger_result,
                player_list: player_list.rating_arr,
                allow_replay: allow_replay
            });
            app.events.startButtonHandler($('.play_again_link'));
        });

    };

    return app;

})(App || {});