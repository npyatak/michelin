<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
use kop\y2sp\ScrollPager;
?>

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
        <a class="btn btn-oblique btn-yellow" target="_blank" href=""><span>Поделиться историей</span></a>
    </div>
    <div class="gallery">
        <div class="container">
            <div class="item">
                <div class="item-user" style="background-image: url('')">
                    <span><span class="snow blue"></span>Иван Иванов</span>
                    <span>1234</span>
                </div>
            </div>
            <div class="item" style="background-image: url('')">
                <div class="item-user">
                    <span><span class="snow yellow"></span>Иван Иванов</span>
                    <span>1234</span>
                </div>
            </div>
            <div class="item" style="background-image: url('')">
                <div class="item-user">
                    <span><span class="snow yellow"></span>Иван Иванов</span>
                    <span>1234</span>
                </div>
            </div>
            <div class="item" style="background-image: url('')">
                <div class="item-user">
                    <span><span class="snow yellow"></span>Иван Иванов</span>
                    <span>1234</span>
                </div>
            </div>
        </div>
    </div>
    <div class="more">
        <a href="">Больше работ</a>
    </div>
</div>

<?php if($dataProvider->models):?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items} {pager}",
        'itemOptions' => ['class' => ''],
        'itemView' => '_post',
        'options' => ['class' => ''],
        'pager' => [
            'class' => ScrollPager::className(), 
            'container' => '.',
            'item' => '.',
            'negativeMargin' => 100,
            'delay' => 10,
            'paginationSelector' => '.pagination',
            'enabledExtensions' => [
                //ScrollPager::EXTENSION_TRIGGER,
                //ScrollPager::EXTENSION_SPINNER,
                ScrollPager::EXTENSION_NONE_LEFT,
                //ScrollPager::EXTENSION_PAGING,
                //ScrollPager::EXTENSION_HISTORY
            ]
        ],
    ]);?>
<?php endif;?>