<?php $this->title = 'Лидеры викторины';?>

<div class="leaders-page">
    <div class="leaders-title"><?=$this->title;?></div>
    <?php if($leaders):?>
	    <div class="leaders">
	    	<?php foreach ($leaders as $leader):?>
		        <div class="leader">
		            <div class="leader-name"><?=$leader->user->fullName;?></div>
		            <div class="leader-info">
		                <span><?=$leader->score;?></span>
		                <span><?=date('i:s:ms', $leader->time);?></span>
		            </div>
		        </div>
		    <?php endforeach;?>
	    </div>
	<?php endif;?>
    <div class="text-center">
        <a href="" class="go-to-page">На главную</a>
    </div>
</div>