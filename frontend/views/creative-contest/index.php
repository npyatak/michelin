<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
use kop\y2sp\ScrollPager;
?>

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