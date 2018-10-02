<?php
use yii\helpers\Url;
?>

<?php $this->title = 'Лидеры викторины';?>

<div class="page_wrapper">
	<div class="container">
	    <div class="row text-center">
	        <a href="#" class="main_title"></a>
	    </div>
	</div>

	<?php if($weekWinners):?>
		<div class="winners">
			<h1 class="title text-center"><?=$this->title;?></h1>
			<?php foreach ($weekWinners as $w):?>
				<div class="elem">
					<div class="name"><?=$w->winner->fullName;?></div>
					<div class="week">Этап <?=$w->number;?></div>
				</div>
			<?php endforeach;?>
		</div>
	<?php endif;?>
	<div class="text-center mt-5"><a class="btn btn-oblique" href="<?=Url::toRoute(['site/index']);?>"><span>На главную</span></a></div>
</div>