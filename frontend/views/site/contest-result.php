Результат: <?=$userTest->score;?>
<br>
ответил правильно на <?=$userTest->right_answers;?> <?=$userTest->questionsText;?> из <?=count($userTest->answersArr);?>

<?=\frontend\widgets\share\ShareWidget::widget(['share' => [
	'text' => 'Пройди викторину и расскажи свою историю путешествия',
	'title' => '#РУЛИЗИМОЙ вместе с MICHELIN-ICE NORTH4!',
]]);?>