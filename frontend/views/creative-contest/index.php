<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
use kop\y2sp\ScrollPager;
?>

<?php if(Yii::$app->user->isGuest):?>
    <div class="auth" style="display: none;">
        <div class="close-popup"><i class="fa fa-close"></i></div>
        <div><span>Авторизуйся</span></div>
        <div>для голосования необходимо авторизоваться с использованием аккаунта социальной сети</div>
        <?=\frontend\widgets\social\SocialWidget::widget(['action' => 'site/login']);?>
    </div>
    <div class="overlay" style="display: none"></div>
<?php endif;?>

<?php if($newPost):?>
<div class="confirm-upload">
    <div class="confirm-title">Ссылка на историю</div>
    <div class="confirm-link"><a href=""><?=$newPost->url;?></a></div>
    <a class="btn btn-oblique" target="_blank" href=""><span>ok</span></a>
</div>
<?php endif;?>

<div class="page_wrapper history">
    <div class="row text_center">
        <a href="#" class="main_title"></a>
    </div>

    <div class="text text_center">
        <div class="like-p">
            <div><b>Расскажи</b> свою захватывающую историю путешествия</div>
            <div>и <b>поделись</b> ею в социальных сетях</div>
            <div><b>собирай</b> голоса и выигрывай новые</div>
            <div>революционные шины <b>Michelin X-Ice North 4</b></div>
        </div>
    </div>
    <div class="action">
        <a class="btn btn-oblique btn-yellow" target="_blank" href="<?=Url::toRoute(['creative-contest/participate']);?>"><span>Поделиться историей</span></a>
    </div>
    <div class="gallery">
        <div class="container">
            <?=$this->render('_posts', ['dataProvider' => $dataProvider]);?>
        </div>
    </div>
    <div class="more">
        <a href="" data-page="1">Больше работ</a>
    </div>
</div>
    
<?=$this->render('_post_popup', ['model' => $model, 'showMap' => false]);?>

<div class="video-modal" id="video">
    <div class="modalType2-content">
        <div class="video-modal-close"></div>
        <div id="ytplayer"></div>
    </div>
</div>
<div class="overlay"></div>

<?php
$script = "
    $(document).on('click', '.more a', function(e) {
        var page = $(this).data('page');
        var link = $(this);
        $.ajax({
            data: 'page='+page, 
            type: 'get',
            success: function(data) {
                $('.gallery .container').append(data);
                link.data('page', page + 1);
                if(data.length <= 1) {
                    link.hide();
                }
            }
        });

        return false;
    });

    $(document).on('click', '.item', function(e) {
        var id = $(this).attr('data-id');
        var item = $(this);
        $.ajax({
            data: 'id='+id,
            url: '".Url::toRoute(['creative-contest/post-data'])."',
            type: 'get',
            success: function(data) {
                $('.city').data('id', data.id);
                if (data.type == 2) {
                    $('.city').find('.play-video').attr('data-id', data.yt_id).show();
                    $('.city').find('.text_block').addClass('show-video');
                } else {
                    $('.city').find('.play-video').hide();
                    $('.city').find('.text_block').removeClass('show-video');
                }
                $('.main_screen, .main_top').css('opacity','0');
                $('.city').show();

                $('.text_block .wrap').html(data.text);
                $('.link').html(data.url);

                $('.text_block').find('.city_img .video').css('background-image', 'url('+data.srcUrl+')');
                $('.text_block').find('.text').attr('ss-container', true);

                $('.city .peoples').html('<div>'+data.fullName+'</div>');

                $('.score span').html(data.score);

                history.pushState(null, null, '".Url::toRoute(['creative-contest/index'])."?id='+id);
            }
        });

        return false;
    });

    $(document).on('click', '.vote-button', function(e) {
        var link = $(this);
        var id = link.closest('.city').data('id');
        $.ajax({
            data: 'id='+id,
            url: '".Url::toRoute(['creative-contest/user-action'])."',
            type: 'get',
            success: function(data) {
                $('.score span').html(data.score);
            }
        });
    });

    $(document).on('click', '.login-modal-btn', function(e) {
        $('.auth').show();
        $('.overlay').show();
    });
";
?>
        

<?php $this->registerJs($script, yii\web\View::POS_END);?>