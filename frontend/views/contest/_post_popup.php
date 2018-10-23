<?php
use yii\helpers\Url;
use yii\helpers\Html;

use common\models\Post;
?>
<div class="city" data-id="<?=($model && $model->status == Post::STATUS_ACTIVE) ?  $model->id : '';?>" style="<?=$model ?  'display: block;' : '';?>">
    <div class="close-popup"><i class="fa fa-close"></i></div>
    <div class="text_block <?=($model && $model->type == Post::TYPE_VIDEO) ? 'show-video' : '';?>">
        <div class="city_img">
            <div class="video" style="<?=($model && $model->status == Post::STATUS_ACTIVE) ?  'background-image: url('.$model->getSrcUrl(true).');' : '';?>">
                <div id="launch-video" class="play-video" data-id="<?=($model && $model->status == Post::STATUS_ACTIVE) ?  $model->yt_id : '';?>" style="<?=($model && $model->type !== Post::TYPE_VIDEO) ? 'display: none;' : '';?>"></div>
            </div>
        </div>
        <div class="text">
            <div class="wrap niceScroll"><?=($model && $model->status == Post::STATUS_ACTIVE) ?  $model->text : 'Работа находится на модерации';?></div>
        </div>
    </div>
    <div class="info_block row">
        <div class="characteristics row">
            <div class="link" style="text-transform: none;">
                <div class="skew-text">
                    Ссылка на историю:
                    <span><?=$model ?  Url::to($model->url, true) : '';?></span>
                </div>
            </div>
            <div></div>
            <div></div>
            <div class="score">
                <div class="skew-text">
                    Баллы: <span><?=$model ?  $model->score : '';?></span>
                    <br>
                    <?php if(Yii::$app->user->isGuest):?>
                        <?=Html::a('<i class="fa fa-heart"></i>Голосовать', null, [
                            'class' => 'login-modal-btn',
                        ]);?>
                    <?php else:?>
                        <?=Html::a('<i class="fa fa-heart"></i>Голосовать', null, [
                            'class' => 'vote-button',
                        ]);?>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <div class="peoples row sss">
            <div><?=$model ? $model->user->fullName : '';?></div>
        </div>
    </div>
</div>