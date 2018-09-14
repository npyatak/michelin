<?php
use yii\helpers\Html;
?>

<div class="question" data-question="<?=$question->id;?>">
    <div class="question-number">Вопрос <?=$question->id;?></div>
	<div class="question-title"><?=$question->title;?></div>
	<ul>
		<?php foreach ($question->answers as $a):?>
			<li>
				<?=Html::a($a->text, '', ['class' => 'answer', 'data-answer' => $a->id]);?>
			</li>
		<?php endforeach;?>
	</ul>
</div>