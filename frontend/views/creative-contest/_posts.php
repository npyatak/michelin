<?php
use yii\helpers\Url;

use common\models\Post;
?>

<?php foreach ($dataProvider->models as $model):?>
	<div class="item" data-id="<?=$model->id;?>" style="background-image: url('<?=$model->srcUrl;?>')">
		<div class="item-user">
			<?php if($model->type == Post::TYPE_IMAGE):?>
				<?php $model->srcUrl;?>
			<?php else:?>
				<?php $model->srcUrl;?>
			<?php endif;?>
		    <span><span class="snow blue"></span><?=$model->user->fullName;?></span>
		    <span><?=$model->score;?></span>
		</div>
	</div>
<?php endforeach;?>