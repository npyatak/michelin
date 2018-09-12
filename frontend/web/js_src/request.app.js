/**
 * Request
 * Модуль содержит функционал запроса данных приложения с сервера
 *
 * @module request
 */

window.App = (function (app) {

    app.request = {};

    app.request.getCurrentPlayerData = function (success_callback, error_callback) {
        return jQuery.ajax({
            type: 'get',
            cache: false,
            url: app.state.request_pre_url + '/quiz/get_current_player_data',
            success: success_callback,
            error: error_callback
        });
    };

    app.request.getRandomQuestion = function (success_callback, error_callback) {
        var url = app.state.request_pre_url + '/quiz/get_random_question';

        return jQuery.ajax({
            cache: false,
            type: 'get',
            url: url,
            success: function (response_data) {
                if (response_data.status == 'error') {
                    error_callback(response_data);
                    return;
                }
                success_callback(response_data);
            },
            error: error_callback
        });
    };

    app.request.answerQuestion = function (answer_id, success_callback, error_callback) {
        if (!error_callback) {
            error_callback = function (response_data) {
                alert(response_data.message)
            }
        }
        return jQuery.ajax({
            type: 'post',
            cache: false,
            url: app.state.request_pre_url + '/quiz/answer_question/' + answer_id,
            success: function (response_data) {
                if (response_data.status == 'error') {
                    error_callback(response_data);
                    return;
                }
                success_callback(response_data);
            },
            error: error_callback
        });
    };


    app.request.getTopPlayerList = function (success_callback, error_callback) {
        if (!error_callback) {
            error_callback = function (response_data) {
                alert(response_data.message)
            }
        }

        var url = app.state.request_pre_url + '/quiz/get_top10_players';

        return jQuery.ajax({
            type: 'get',
            cache: false,
            url: url,
            success: function (response_data) {
                if (!success_callback) {
                    return;
                }
                if (response_data.status == 'error') {
                    error_callback(response_data);
                    return;
                }
                success_callback(response_data);
            },
            error: error_callback
        });
    };

    app.request.getOverallRatingList = function (success_callback, error_callback) {
        if (!error_callback) {
            error_callback = function (response_data) {
                alert(response_data.message)
            }
        }

        return jQuery.ajax({
            type: 'get',
            cache: false,
            url: app.state.request_pre_url + '/quiz/get_overall_rating_results',
            success: function (response_data) {
                if (!success_callback) {
                    return;
                }
                if (response_data.status == 'error') {
                    error_callback(response_data);
                    return;
                }
                success_callback(response_data);
            },
            error: error_callback
        });
    };

    app.request.saveEmail = function (email, callback, failCallback) {
        return $.ajax({
            url: app.state.request_pre_url + '/save_email',
            cache: false,
            method: "POST",
            data: {email: email}
        }).done(callback).fail(failCallback);
    };

    app.request.questionTimeout = function (callback, failCallback) {

        return $.ajax({
            url: app.state.request_pre_url + '/quiz/question_timeout'
        }).done(callback).fail(failCallback);

    };

    app.request.getCityNames = function (callback, failCallback) {

        return $.ajax({
            url: app.state.request_pre_url + '/get_city_list'
        }).done(callback).fail(failCallback);

    };
    app.request.getCityData = function (city_id, callback, failCallback) {

        return $.ajax({
            url: app.state.request_pre_url + '/get_city_data/' + city_id
        }).done(callback).fail(failCallback);

    };

    return app;

})(App || {});