<?php $this->params['bodyClass'] = 'about_page';?>

<div class="page_wrapper about">
    <div class="about_page_inner">
        <div class="_250_contacts"></div>
        <div class="text">
            <h1>Michelin X-Ice North 4 </h1>

            <div class="like-p">
                <div>Новая зимняя шипованная шина премиум-класса</div>
                <div><b>Michelin X-Ice North 4</b> предназначена для городских</div>
                <div>седанов, но позволяет не ограничивать себя улицами</div>
                <div>города. <b>250 стальных шипов</b> на каждой шине</div>
                <div>обеспечивают отличную управляемость на трассе.</div>
            </div>
            <div class="like-p">
                <div>Инновационная форма шипа улучшает тормозные</div>
                <div>характеристики, а новый рисунок протектора</div>
                <div>понижает шум и улучшает сцепление с дорогой.</div>
                <div>Теперь неважно, что впереди – лёд или асфальт. Все</div>
                <div>дороги русской зимы послушно лягут</div>
                <div>вам под колёса!</div>
            </div>
            <div class="actions-wrap">
                <a class="btn btn-oblique" target="_blank" href="https://xin4.michelin.ru?utm_source=match_tv&utm_medium=tyre_page&utm_campaign=rulizimoy"><span>Подробнее</span></a>
                <span class="btn btn-oblique play-video" id="about-play-video" data-id="VZNllpqMNCo"><span>Смотреть видео</span></span>
            </div>
        </div>
        <div class="about_tire"></div>
    </div>
</div>

<div class="video-modal" id="video">
    <div class="modalType2-content">
        <div class="video-modal-close"></div>
        <div id="ytplayer"></div>
    </div>
</div>

<div class="overlay"></div>

<?php $script = "
    $(document).ready(function() {
        window.page = true;
//        alert($('#about-play-video').data('id'));
//        $('.play-video').click();
    });
";?>
<?php $this->registerJs($script, yii\web\View::POS_END);?>