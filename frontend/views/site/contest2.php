<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<?php $this->params['bodyClass'] = 'about_page';?>

<div class="page_wrapper ">
    <div class="row text_center">
        <a href="#" class="main_title"></a>
    </div>
</div>
<?php if(Yii::$app->user->isGuest):?>
	<div class="auth" style="display: block">
	    <div><span>Авторизуйся</span></div>
	    <div>для участия в викторине необходимо авторизоваться с использованием аккаунта социальной сети</div>
		<?=\frontend\widgets\social\SocialWidget::widget(['action' => 'site/login']);?>
	</div>
	<div class="overlay" style="display: block"></div>
<?php else:?>

<!-- Лидеры  -->

<!--    <div class="leaders-page">-->
<!--        <div class="leaders-title">Лидеры викторины</div>-->
<!--        <div class="leaders">-->
<!--            <div class="leader">-->
<!--                <div class="leader-name">Иван Иванов</div>-->
<!--                <div class="leader-info">-->
<!--                    <span>10</span>-->
<!--                    <span>0'21'723</span>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="leader">-->
<!--                <div class="leader-name">Иван Иванов</div>-->
<!--                <div class="leader-info">-->
<!--                    <span>10</span>-->
<!--                    <span>0'21'723</span>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="leader">-->
<!--                <div class="leader-name">Иван Иванов</div>-->
<!--                <div class="leader-info">-->
<!--                    <span>10</span>-->
<!--                    <span>0'21'723</span>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="leader">-->
<!--                <div class="leader-name">Иван Иванов</div>-->
<!--                <div class="leader-info">-->
<!--                    <span>10</span>-->
<!--                    <span>0'21'723</span>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="leader">-->
<!--                <div class="leader-name">Иван Иванов</div>-->
<!--                <div class="leader-info">-->
<!--                    <span>10</span>-->
<!--                    <span>0'21'723</span>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="leader">-->
<!--                <div class="leader-name">Иван Иванов</div>-->
<!--                <div class="leader-info">-->
<!--                    <span>10</span>-->
<!--                    <span>0'21'723</span>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="text-center">-->
<!--            <a href="" class="go-to-page">На главную</a>-->
<!--        </div>-->
<!--    </div>-->

<!--    -->



<!--  Результаты  -->

<!--    <div class="result-page">-->
<!--        <div class="points">-->
<!--            <span>72.00</span>-->
<!--        </div>-->
<!--        <div class="result-title">Результат</div>-->
<!--        <div class="result-text">-->
<!--            <p>Ты ответил правильно на 25 вопросов из 30.</p>-->
<!--            <p>Отличный результат!</p>-->
<!--        </div>-->
<!--        <div class="result-share">-->
<!--            <div>Поделись с друзьями</div>-->
<!--            <a href="" class="result-facebook"><i class="fa fa-facebook-f"></i></a>-->
<!--            <a href="" class="result-vk"><i class="fa fa-vk"></i></a>-->
<!--        </div>-->
<!--    </div>-->

<!--    -->




<!--  НАЧАТЬ  -->

<!--    <div class="start-question">-->
<!--        <div class="start-question-text">-->
<!--            <p>Прими участие в викторине и получи фору при старте второго этапа! Отвечай на вопросы правильно и не затягивай со временем. Первые топ-10 игроков получат приятный бонус в творческом конкурсе!</p>-->
<!--            <p>Лучшие результаты каждой недели будут награждены памятными сувенирами: абонементы, чемоданы, навигаторы, пледы и кружки!</p>-->
<!--        </div>-->
<!--        <div class="text-center">-->
<!--            <a href="" class="start-question-btn">Начать</a>-->
<!--        </div>-->
<!--    </div>-->

<!--    -->



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
	";

	$this->registerJs($script, yii\web\View::POS_END);?>
<?php endif;?>