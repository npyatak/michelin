<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="city" data-id="">
    <div class="close-popup"><i class="fa fa-close"></i></div>
    <div class="text_block">
        <div class="city_img">
            <div class="video" data-id="">
                <div id="launch-video" class="play-video" data-id=""></div>
            </div>
        </div>
        <div class="city-title"></div>
        <div class="text">
            <div class="wrap niceScroll"></div>
        </div>
    </div>
    <div class="info_block row">
        <div class="characteristics row">
            <div class="link"> 
                <div>
                    <div class="copy-wrap">
                    </div>  
                </div>
            </div>
            <div>
            </div>
            <div>
            </div>
            <div class="score">
                Баллы: <span></span>
                <?php if(Yii::$app->user->isGuest):?>
                    <?=Html::a('Голосовать', null, [
                        'class' => 'login-modal-btn',
                    ]);?>
                <?php else:?>
                    <?=Html::a('Голосовать', null, [
                        'class' => 'vote-button',
                    ]);?>
                <?php endif;?>
            </div>
        </div>
        <div class="peoples row sss">
            <div></div>
        </div>
    </div>
</div>