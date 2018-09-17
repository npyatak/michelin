<?php
use yii\helpers\Url;
?>

<div class="result-page">
    <div class="points">
        <span><?=$userTest->score;?></span>
    </div>
    <div class="result-title">Результат</div>
    <div class="result-text">
        <p>Ты ответил правильно на <?=$userTest->right_answers;?> <?=$userTest->questionsText;?> из <?=count($userTest->answersArr);?>.</p>
        <p>Отличный результат!</p>
    </div>
    <div class="result-share">
        <div>Поделись с друзьями</div>
		<?=\frontend\widgets\share\ShareWidget::widget(['share' => [
			'text' => 'Пройди викторину и расскажи свою историю путешествия',
			'title' => '#РУЛИЗИМОЙ вместе с MICHELIN-ICE NORTH4!',
			'url' => Url::home(),
		]]);?>
    </div>
</div>