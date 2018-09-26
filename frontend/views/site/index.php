<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<?php $this->params['bodyClass'] = 'index_page';?>
<?php //$this->registerJsFile('/js/jquery.mobile-1.5.0-alpha.1.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);?>
<?php $this->registerCssFile(Url::toRoute('css/tire.css'));?>

<?=\frontend\widgets\share\ShareWidget::widget([
    'share' => [
        'text' => 'Пройди викторину и расскажи свою историю путешествия',
        'title' => '#РУЛИЗИМОЙ вместе с MICHELIN-ICE NORTH4!',
        'image' => '/img/share-michelin.jpg',
    ], 
    'showButtons' => false,
]);?>

<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>

<div class="page_wrapper">

    <div class="row text_center main_top">
        <a href="#" class="main_title main"></a>
        <div class="mans">
            <div class="savin">Евгений Савин</div>
            <div class="chesnokova">Ирина Чеснокова</div>
            <div class="chebatkov">Жека Чебатков</div>
            <div class="kovinov">Дмитрий Ковинов</div>
        </div>
    </div>
    <div class="row main_screen">
        <div class="video">
            <div id="launch-video" class="play-video" data-id="042UyeWlC5I"></div>
        </div>
        <div class="about">
            <div class="title">О проекте</div>
            <div class="descr">
                <!-- <div>Поддержи любимую команду даже на выездных матчах!</div>
                <div>Смотри уникальные видео о самых красивых местах России,</div>
                <div>отвечай на вопросы Викторины и получи шанс</div>
                <div> выиграть стильные призы от Michelin,</div>
                <div>а также годовой абонемент на матчи своего любимого клуба!</div>
                <div>Путешествуй со своей командой, путешествуй с Michlein!</div> -->
                <div>Вместе с шипованными шинами Michelin X-Ice North4 мы берёмся</div>
                <div>доказать, что Россия – лучшая в мире страна для зимних</div>
                <div>путешествий! В проекте «Рули зимой» популярные телеведущие</div>
                <div>и блогеры проложат для вас новые маршруты на зимней карте</div>
                <div>России. 250 уникальных точек – столько же, сколько и шипов на</div>
                <div>шине. Мы начинаем, а вы подхватываете!</div>
                <div><a class="btn btn-oblique" href="<?=Url::toRoute(['site/contest']);?>"><span>Участвовать в конкурсе!</span></a></div>
            </div>
        </div>
    </div>

    <?=$this->render('_city_popup_block', ['showMap' => true]);?>
</div>
<div id="tire">
    <div class="arrows">
        <div class="arrow-up"></div>
        <div class="arrow-down"></div>
    </div>
</div>

<div class="video-modal" id="video">
    <div class="modalType2-content">
        <div class="video-modal-close"></div>
        <div id="ytplayer"></div>
    </div>
</div>
<div class="map-modal" id="map-modal">
    <div class="modalType2-content">
        <div class="map-modal-close"></div>
        <div id="map"></div>
    </div>
</div>
<div class="overlay"></div>


<?php if($cityId) {
    $script = "
        loadCityData($cityId);
    ";

    $this->registerJs($script, yii\web\View::POS_END);
}?>
