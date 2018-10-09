<?php
use yii\helpers\Url;

use common\models\Post;
?>

<div class="field-points-label score"><?=$model->score;?></div>
<?php if($model->type == Post::TYPE_IMAGE):?>
	<img src="<?=$model->srcUrl;?>" alt="">
<?php else:?>
	<?=$model->srcUrl;?><!-- video -->
<?php endif;?>

<div class="copy-wrap">
	<a href="<?=Url::toRoute(['site/index', 'id' => $model->id], true);?>" class="copy-link" title="Скопировать ссылку на работу"></a>
	<div class="link-copied">Ссылка скопирована</div>
</div>
<?php if($model->user->name):?>
<div class="field-name">
    <?=$model->user->fullName;?>
</div>
<?php endif;?>
<div class="field-points">
    Баллы: <span class="score"><?=$model->score;?></span>
</div>

<div class="field-vote">
	<?//=$this->render('_like_button', ['model' => $model]);?>
</div>