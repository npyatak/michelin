<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<?php $this->params['bodyClass'] = 'about_page';?>

<div class="page_wrapper ">
    <div class="row text_center">
        <a href="#" class="main_title"></a>
    </div>
    <?php if(Yii::$app->user->isGuest):?>
        <div class="auth" style="display: block">
            <div><span>Авторизуйся</span></div>
            <div>для участия в викторине необходимо авторизоваться с использованием аккаунта социальной сети</div>
            <?=\frontend\widgets\social\SocialWidget::widget(['action' => 'site/login']);?>
        </div>
        <div class="overlay" style="display: block"></div>
    <?php else:?>
        <div class="start-question">
            <div class="start-question-text">
                <p>Прими участие в викторине и получи фору при старте второго этапа! Отвечай на вопросы правильно и не затягивай со временем. Первые топ-10 игроков получат приятный бонус в творческом конкурсе!</p>
                <p>Лучшие результаты каждой недели будут награждены памятными сувенирами: абонементы, чемоданы, навигаторы, пледы и кружки!</p>
            </div>
            <div class="text-center">
                <a href="" class="start-question-btn">Начать</a>
            </div>
        </div>

        <div id="question" style="display: none;">
            <?=$this->render('_question', ['question' => $question]);?>
        </div>

        <?php
        $script = "
		$(document).on('click', '.answer', function(e) {
			var question = $(this).closest('.question').data('question');
			var answer = $(this).data('answer');
	        $.ajax({
	            type: 'GET',
	            url: '".Url::toRoute(['site/contest-ajax'])."',
	            data: 'question='+question+'&answer='+answer,
	            success: function (data) {
	            	if(data.status == 'redirect') {
	                    window.location.href = '".Url::toRoute(['site/contest-result'])."';
	                }
	                $('#question').html(data);
	            }
	        });

	        return false;
	    });

	    $(document).on('click', '.start-question-btn', function(e) {
	    	$('.start-question').hide();
	    	$('#question').show();

	    	return false;
	    })
	";

        $this->registerJs($script, yii\web\View::POS_END);?>
    <?php endif;?>
</div>