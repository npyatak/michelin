<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<?php $this->params['bodyClass'] = 'about_page';?>

<div class="page_wrapper ">
    <div class="row text_center">
        <a href="#" class="main_title"></a>
    </div>
    <div class="row text_center">
        <div class="col ruli_zimoi_label">
            <p>Чтобы стать лучшим, смотри видео <strong>в этом разделе</strong>,</p>
    	    <p>выполняй условия и получай крутые призы</p>
        </div>
    </div>
    <div class="row contast-cards">
        <div class="col-xs-offset-1 col-sm-offset-0 col-xs-10 col-sm-6 col-md-4 col-lg-4 contast-card" data-toggle="modal" data-target="#contest-video-1">
            <div class="contast-card-play-icon"></div>
            <div class="contest-image"></div>
            <div class="contest-text text_center">Снегоходы</div>
        </div>
        <div class="col-xs-offset-1 col-sm-offset-0 col-xs-10 col-sm-6 col-md-4 col-lg-4 contast-card" data-toggle="modal" data-target="#contest-video-2">
            <div class="contast-card-play-icon"></div>
            <div class="contest-image"></div>
            <div class="contest-text text_center">Музей РЖД</div>
        </div>
        <div class="col-xs-offset-1 col-sm-offset-0 col-xs-10 col-sm-6 col-md-4 col-lg-4 contast-card" data-toggle="modal" data-target="#contest-video-3">
            <div class="contast-card-play-icon"></div>
            <div class="contest-image"></div>
            <div class="contest-text text_center">Рудники</div>
        </div>
        <div class="col-xs-offset-1 col-sm-offset-0 col-xs-10 col-sm-6 col-md-4 col-lg-4 contast-card" data-toggle="modal" data-target="#contest-video-4">
            <div class="contast-card-play-icon"></div>
            <div class="contest-image"></div>
            <div class="contest-text text_center">Снегоходы</div>
        </div>
        <div class="mcol-xs-offset-1 col-sm-offset-0 col-xs-10 col-sm-6 col-md-4  col-lg-4 contast-card" data-toggle="modal" data-target="#contest-video-5">
            <div class="contast-card-play-icon"></div>
            <div class="contest-image"></div>
            <div class="contest-text text_center">Снегоходы</div>
        </div>
        <div class="col-xs-offset-1 col-sm-offset-0 col-xs-10 col-sm-6 col-md-4 col-lg-4 contast-card" data-toggle="modal" data-target="#contest-video-6">
            <div class="contast-card-play-icon"></div>
            <div class="contest-image"></div>
            <div class="contest-text text_center">Снегоходы</div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="contest-video-1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

    <?php if(Yii::$app->user->isGuest):?>
        <!--<div class="auth" style="display: block">
            <div><span>Авторизуйся</span></div>
            <div>для участия в викторине необходимо авторизоваться с использованием аккаунта социальной сети</div>
            <?=\frontend\widgets\social\SocialWidget::widget(['action' => 'site/login']);?>
        </div>
        <div class="overlay" style="display: block"></div>-->
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
