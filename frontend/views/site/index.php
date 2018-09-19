<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<?php $this->params['bodyClass'] = 'index_page';?>

<?=\frontend\widgets\share\ShareWidget::widget([
    'share' => [
        'text' => 'Пройди викторину и расскажи свою историю путешествия',
        'title' => '#РУЛИЗИМОЙ вместе с MICHELIN-ICE NORTH4!',
        'image' => '/img/share-michelin.jpg',
    ], 
    'showButtons' => false,
]);?>

<script src="//api-maps.yandex.ru/2.1/?lang=en_RU" type="text/javascript"></script>

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
            <div id="launch-video" class="play-video" data-id="3K76Y5qBzfw"></div>
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
    <div class="city">
        <div class="close-popup"><i class="fa fa-close"></i></div>
        <div class="text_block">
            <div class="city_img">
                <!-- <iframe frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe> -->
                <div class="video" data-id="">
                    <div id="launch-video" class="play-video" data-id=""></div>
                </div>
            </div>
            <div class="show_on_map">
                <a href="" class="show-map-link" data-coord="">Показать на карте</a>
            </div>
            <div class="city-title">Байкал. остров ольхон</div>
            <div class="text">
                <div class="wrap niceScroll">
                    <p>
                        Ольхон – одна из жемчужин Байкала, древний мистический остров шаманов. Зимой дорога сюда от Иркутска
                        займёт несколько часов, причём часть её пройдёт по льду Байкала. Всё как на обычной трассе –
                        разметка,
                        знаки,ограничение скорости, но стоит отойти на несколько метров в сторону – и сквозь прозрачную
                        толщу
                        льда ты увидишь камни на дне и поймешь, что под тобой глубина в несколько десятков метров. Зимой
                        туристический поток спадает, и остров предстаёт в первозданной суровой красоте.
                    </p>
                    <p>
                        Вы можете свободно посетить священные места шаманов, увидеть причудливые скульптуры из льда,
                        покрывающие
                        прибрежные скалы, и, конечно отведать знаменитого копчёного омуля – легенду байкальской кухни.
                    </p>
                </div>
            </div>
        </div>
        <div class="info_block row">
            <div class="characteristics row">
                <div> 
                    <div class="skew-text">особенности </div>
                    <div class="skew-text">дорожного покрытия</div>
                    <div class="skew-text">в данной точке</div>
                </div>
                <div>
                    <div class="scores scores_1"></div>
                    <div class="skew-text">СЦЕПЛЕНИЕ</div>
                    <div class="skew-text">С АСФАЛЬТОМ</div>
                </div>
                <div>
                    <div class="scores scores_2"></div>
                    <div class="skew-text">КОНТРОЛЬ</div>
                    <div class="skew-text">НА ЛЬДУ</div>
                </div>
                <div>
                    <div class="scores scores_3"></div>
                    <div class="skew-text">УПРАВЛЯЕМОСТЬ</div>
                    <div class="skew-text">НА СНЕГУ</div>
                </div>
            </div>
            <div class="peoples row sss">
                <div class="chesnokova">Ирина Чеснокова</div>
                <div class="chebatkov">Жека Чебатков</div>
            </div>
        </div>
    </div>
<!--    <div class="city show-ipad-mobile">-->
<!--        <div class="city-inner">-->
<!--            <div class="text_block">-->
<!--                <div class="left">-->
<!--                    <div class="city_img">-->
<!--                        <div></div>-->
<!--                        <iframe frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="right">-->
<!--                <div class="city-title">Байкал. остров ольхон</div>-->
<!--                    <div class="text">-->
<!--                        <div class="wrap">-->
<!--                            <p>-->
<!--                                Ольхон – одна из жемчужин Байкала, древний мистический остров шаманов. Зимой дорога сюда от Иркутска-->
<!--                                займёт несколько часов, причём часть её пройдёт по льду Байкала. Всё как на обычной трассе –-->
<!--                                разметка,-->
<!--                                знаки,ограничение скорости, но стоит отойти на несколько метров в сторону – и сквозь прозрачную-->
<!--                                толщу-->
<!--                                льда ты увидишь камни на дне и поймешь, что под тобой глубина в несколько десятков метров. Зимой-->
<!--                                туристический поток спадает, и остров предстаёт в первозданной суровой красоте.-->
<!--                            </p>-->
<!--                            <p>-->
<!--                                Вы можете свободно посетить священные места шаманов, увидеть причудливые скульптуры из льда,-->
<!--                                покрывающие-->
<!--                                прибрежные скалы, и, конечно отведать знаменитого копчёного омуля – легенду байкальской кухни.-->
<!--                            </p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="show_on_map">-->
<!--                    <a href="">Показать на карте</a>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="info_block row">-->
<!--                <div class="characteristics row">-->
<!--                    <div>-->
<!--                        <div class="skew-text">характеристики шины,</div>-->
<!--                        <div class="skew-text">которые проявятся</div>-->
<!--                        <div class="skew-text">в этой точке</div>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <div class="scores scores_1"></div>-->
<!--                        <div class="skew-text">СЦЕПЛЕНИЕ</div>-->
<!--                        <div class="skew-text">С АСФАЛЬТОМ</div>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <div class="scores scores_2"></div>-->
<!--                        <div class="skew-text">КОНТРОЛЬ</div>-->
<!--                        <div class="skew-text">НА ЛЬДУ</div>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <div class="scores scores_3"></div>-->
<!--                        <div class="skew-text">УПРАВЛЯЕМОСТЬ</div>-->
<!--                        <div class="skew-text">НА СНЕГУ</div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="peoples row">-->
<!--                    <div class="chesnokova">Ирина Чеснокова</div>-->
<!--                    <div class="chebatkov">Жека Чебатков</div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="close-info-modal">-->
<!--                <img src="./img/helpers/menu-close-blue.svg" class="fa-times" />-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
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