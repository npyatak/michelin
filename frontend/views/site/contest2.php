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
	<div id="question">
		<?=$this->render('_question', ['question' => $question]);?>
	</div>

	<?php
	$script = "
		$(document).on('click', '.answer', function(e) {
			var question = $(this).closest('.question').data('qid');
			var answer = $(this).data('aid');
	        $.ajax({
	            type: 'GET',
	            data: 'q_id='+question+'&a_id='+answer,
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