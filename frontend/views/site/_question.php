<?php
use yii\helpers\Html;
?>

<div class="question" data-qid="<?=$question->id;?>">
	<?=$question->title;?>
	<ul>
		<?php foreach ($question->answers as $a):?>
			<li>
				<?=Html::a($a->text, '', ['class' => 'answer', 'data-aid' => $a->id]);?>
			</li>
		<?php endforeach;?>
	</ul>
</div>