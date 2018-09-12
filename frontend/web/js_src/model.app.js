/**
 * Model
 * Модуль работы с моделями приложения
 *
 * @module model
 */

window.App = (function (app) {

    app.model = {};

    app.model.question = {
        title: '',
        counter: 0,
        answers: {},
        setFromJSON: function (json_data) {
            app.model.question.set('title', json_data.title);
            app.model.question.set('counter', json_data.counter);
            var answer_collection = [];
            json_data.answers.forEach(function (answer_data) {
                app.model.answer.setFromJSON(answer_data);
                answer_collection[app.model.answer.get('id')] = jQuery.extend(true, {}, app.model.answer);
            });
            app.model.question.set('answers', answer_collection);
        },
        set: function (field_name, value) {
            if (app.model.question[field_name] === undefined) {
                alert('поля ' + field_name + ' не существует (question)');
                return;
            }
            if (field_name == 'answers') {
                app.model.question[field_name] = value;
                return;
            }
            app.model.question[field_name] = value;
        },
        get: function (field_name) {
            if (app.model.question[field_name] === undefined) {
                alert('поля ' + field_name + ' не существует (question)');
                return;
            }
            return app.model.question[field_name];
        }
    };

    app.model.answer = {
        id: 0,
        answer_text: '',
        setFromJSON: function (json_data) {
            this.set('id', json_data.id);
            this.set('answer_text', json_data.answer_text);
        },
        set: function (field_name, value) {
            if (this[field_name] === undefined) {
                alert('поля ' + field_name + ' не существует (answer)');
                return;
            }
            this[field_name] = value;
        },
        get: function (field_name) {
            if (this[field_name] === undefined) {
                alert('поля ' + field_name + ' не существует (answer)');
                return;
            }
            return this[field_name];
        }
    };

    app.model.player = {
        id: 0,
        name: '',
        email: '',
        can_play: false,
        last_game_result: {},
        last_logger_result: {},

        setFromJSON: function (json_data) {
            this.set('id', json_data.id);
            this.set('name', json_data.name);
            this.set('email', json_data.email);
            this.set('can_play', json_data.can_play);
            this.set('last_game_result', json_data.last_game_result);
            this.set('last_logger_result', json_data.last_logger_result);
        },
        set: function (field_name, value) {
            if (this[field_name] === undefined) {
                alert('поля ' + field_name + ' не существует (player)');
                return;
            }
            this[field_name] = value;
        },
        get: function (field_name) {
            if (this[field_name] === undefined) {
                alert('поля ' + field_name + ' не существует (player)');
                return;
            }
            return this[field_name];
        },
        fetch: function () {
            return app.request.getCurrentPlayerData(function (response_data) {
                if (response_data.status == 'error') {
                    return;
                }
                app.model.player.setFromJSON(response_data.player);
            });
        }
    };

    return app;

})(App || {});