<?php $this->title = 'Лидеры викторины';?>

<div class="page_wrapper">
	<div class="container">
	    <div class="row text-center">
	        <a href="#" class="main_title"></a>
	    </div>
	</div>

	<?php if($winners):?>
		<div class="winners">
			<h1 class="title text-center"><?=$this->title;?></h1>
			<?php foreach ($winners as $winner):?>
				<div class="elem">
					<div class="name"><?=$winner->user->fullName;?></div>
					<div class="week">Этап <?=$winner->week->number;?></div>
				</div>
			<?php endforeach;?>
		</div>
	<?php endif;?>
	<div class="text-center mt-5"><a class="btn btn-oblique" href="/"><span>На главную</span></a></div>
</div>