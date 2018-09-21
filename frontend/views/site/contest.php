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
        <div class="start-question text">
            <div class="like-p">
                <p><span> Поддержи любимую команду даже на выездных</span>
                <span> матчах! <b><a href="<?=Url::toRoute(['site/video']);?>" style="text-transform: uppercase;">Смотри</a></b> уникальные видео о самых</span>
                <span> красивых местах России, отвечай на вопросы</span>
                <span> Викторины и получи шанс выиграть стильные</span>
                <span> призы от Michelin, а также годовой абонемент на</span>
                <span> матчи своего любимого клуба!</span>
                </p>
                <p><span>Путешествуй со своей командой, путешествуй с</span>
                <span>Michlein!</span></p>
                <!-- <p>Прими участие в викторине и получи фору при старте второго этапа! Отвечай на вопросы правильно и не затягивай со временем. Первые топ-10 игроков получат приятный бонус в творческом конкурсе!</p>
                <p>Лучшие результаты каждой недели будут награждены памятными сувенирами: абонементы, чемоданы, навигаторы, пледы и кружки!</p> -->
            </div>
            <div class="text-center">
                <a href="" class="start-question-btn"><span>Начать</span></a>
            </div>
        </div>

        <div class="auth" style="display: none;">
            <div><span>Авторизуйся</span></div>
            <div>для участия в викторине необходимо авторизоваться с использованием аккаунта социальной сети</div>
            <?=\frontend\widgets\social\SocialWidget::widget(['action' => 'site/login']);?>
        </div>
        <div class="overlay" style="display: none"></div>

        <?php
        $script = "
            $(document).on('click', '.start-question-btn', function(e) {
                $('.start-question').hide();
                $('.auth').show();
                $('.overlay').show();

                return false;
            })
        ";?>
    <?php else:?>
        <div id="question">
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
    	";?>
    <?php endif;?>
</div>

<?php $this->registerJs($script, yii\web\View::POS_END);?>
