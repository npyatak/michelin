<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
use kop\y2sp\ScrollPager;
?>

<?=\frontend\widgets\share\ShareWidget::widget([
    'share' => [
        'text' => 'Голосуй за историю моего путешествия! Увеличь мои шансы на победу!',
        'title' => '#РУЛИЗИМОЙ вместе с MICHELIN X-Ice North 4!',
        'image' => ($model && $model->getSrcUrl(true)) ? $model->getSrcUrl(true) : '/img/share-michelin.jpg',
    ], 
    'showButtons' => false,
]);

$videoArr = [
    ['id' => 'jB4MyAc2ujQ', 'title' => 'Скажите сыыыр! Ферма-сыроварня, Матокса', 'image' => '', 'cityId' => 105],
    ['id' => 'gtqMyLBQfJE', 'title' => 'Саблинские пещеры', 'image' => ''],
    ['id' => 'wRSDnBc-4-w', 'title' => 'Арт-парк "Таинственный лес"', 'image' => ''],
    ['id' => 'e7pYgyx7cWM', 'title' => 'Музей железных дорог России', 'image' => '', 'cityId' => 100],
    ['id' => 'tCY8VXOZhK8', 'title' => 'Трек, Хибины', 'image' => ''],
    ['id' => 'b4j0uABIbBc', 'title' => 'Кировский рудник, Хибины', 'image' => '/img/video/7.jpg', 'cityId' => 101],
    ['id' => 'WBMPt-EqKLo', 'title' => 'Гольф-клуб "Дюны", Сестрорецк', 'image' => '', 'cityId' => 102],
    ['id' => 'xajxxDJUNxQ', 'title' => 'Ретро-дайвинг, Семиозерье', 'image' => '/img/video/9.jpg', 'cityId' => 103],
    ['id' => 'pjLmtZViw8k', 'title' => 'По законам севера. Этническая деревня', 'image' => '/img/video/10.jpg', 'cityId' => 104],
    ['id' => 'W0awU596rNo', 'title' => 'Горячий снег. Тур на снегоходах', 'image' => '/img/video/11.jpg'],
];
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
    <div class="confirm-upload" style="display: block;">
        <div class="confirm-title">Ссылка на историю</div>
        <div class="confirm-link"><a href=""><?=Url::to($newPost->url, true);?></a></div>
        <a class="btn btn-oblique confirm-btn" href=""><span>ok</span></a>
    </div>
    <div class="overlay" style="display: block"></div>
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
        <a class="btn btn-oblique btn-yellow" target="_blank" href="<?=Url::toRoute(['contest/participate']);?>"><span>Поделиться историей</span></a>
    </div>

    <div class="row text_center text"><b class="like-p" style="transform: none;">Смотри крутые путешествия  наших ведущих и делись своими</b></div>
    <div class="row">
        <?php foreach ($videoArr as $key => $v):?>
            <?php $image = $v['image'] ? Url::toRoute($v['image']) : "https://img.youtube.com/vi/".$v['id']."/maxresdefault.jpg";?>
            <div class="col-xs-offset-1 col-sm-offset-0 col-xs-10 col-sm-6 col-md-4 col-lg-4 contast-card"">
                <div class="contast-card-play-icon play-video" data-id="<?=$v['id']?>"></div>
                <div class="contest-image" style="background: url(<?=$image;?>) 0 0/cover;">
                    <?php if(isset($v['cityId'])):?>
                        <a href="<?=Url::toRoute(['site/index', 'cityId' => $v['cityId']]);?>" class="contest-link">Подробнее..</a>
                    <?php endif;?>

                    <div class="contest-image-shadow"></div>
                </div>
                <div class="contest-text text_center"><?=$v['title'];?></div>
            </div>
        <?php endforeach;?>
    </div>

    <div class="gallery">
        <div class="row text_center text"><b class="like-p" style="transform: none;">Истории участников</b></div>
        <div class="container">
            <?=$this->render('_posts', ['dataProvider' => $dataProvider]);?>
        </div>
    </div>
    <?php if($pageSize < $dataProvider->totalCount):?>
        <div class="more">
            <a href="" data-page="1">Больше работ</a>
        </div>
    <?php endif;?>
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
    niceScrollUpdate(250);
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
            url: '".Url::toRoute(['contest/post-data'])."',
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
                $('.link .skew-text span').html(data.url);

                $('.text_block').find('.city_img .video').css('background-image', 'url('+data.srcUrl+')');
                $('.text_block').find('.text').attr('ss-container', true);

                $('.city .peoples').html('<div>'+data.fullName+'</div>');

                $('.score span').html(data.score);

                history.pushState(null, null, '".Url::toRoute(['contest/index'])."?id='+id);

                niceScrollUpdate(250);
            }
        });

        return false;
    });

    $(document).on('click', '.vote-button', function(e) {
        var link = $(this);
        var id = link.closest('.city').data('id');
        $.ajax({
            data: 'id='+id,
            url: '".Url::toRoute(['contest/user-action'])."',
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

    $(document).on('click', '.close-popup', function(e) {
        history.pushState(null, null, '".Url::toRoute(['contest/index'])."');
    });
";
?>
        

<?php $this->registerJs($script, yii\web\View::POS_END);?>