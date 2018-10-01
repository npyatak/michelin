<?php $this->title = 'Лидеры викторины';?>

<div class="page_wrapper">
    <div class="row text_center">
        <a href="#" class="main_title"></a>
    </div>

	<?php if($winners):?>
		<div class="winners">
			<h1 class="title text_center"><?=$this->title;?></h1>
			<?php foreach ($winners as $winner):?>
				<div class="elem">
					<div class="name"><?=$winner->user->fullName;?></div>
					<div class="week">Этап <?=$winner->week->number;?></div>
				</div>
			<?php endforeach;?>
		</div>
	<?php endif;?>
</div>