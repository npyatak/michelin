<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use common\models\City;

$this->title = 'Города';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="week-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить город', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'source',
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function($data) {
                    return $data->getTypeArray()[$data->type];
                },
                'filter' => Html::activeDropDownList($searchModel, 'type', City::getTypeArray(), ['prompt'=>''])
            ], 
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php 
//$ids = [14, 8, 63, 19, 101, 6, 18, 12, 89, 100, 102, 40, 104, 31, 87, 47, 10, 23, 30, 68, 37, 2, 95, 55, 81, 91, 5, 11, 33, 32, 86, 24, 78, 99, 42, 29, 3, 51, 70, 34, 4, 50, 57, 77, 27, 53, 67, 94, 74, 98, 85, 43, 62, 79, 7, 82, 21, 93, 41, 56, 13, 83, 71, 73, 46, 28, 84, 16, 60, 26, 25, 20, 52, 1, 48, 61, 36, 72, 75, 17, 90, 80, 105, 9, 44, 65, 97, 39, 15, 69, 49, 38, 22, 92, 64, 45, 54, 76, 88, 59, 103, 35, 66, 96, 58];
$ids = [9, 44, 97];

$script = "";

foreach ($ids as $id) {
    $script .= "
        setTimeout(function(){
            $.ajax({
                type: 'GET',
                url: 'https://special.matchtv.ru/michelin2018/get_city_data/'+$id,
                // headers: {
                //     'Access-Control-Allow-Origin': '*'
                // },
                success: function (data) {
                    console.log($id);
                    console.log(data);
                }
            });
        }, 500);
    ";
}

$script .= "
        // var ids = [14, 8, 63, 19, 101, 6, 18, 12, 89, 100, 102, 40, 104, 31, 87, 47, 10, 23, 30, 68, 37, 2, 95, 55, 81, 91, 5, 11, 33, 32, 86, 24, 78, 99, 42, 29, 3, 51, 70, 34, 4, 50, 57, 77, 27, 53, 67, 94, 74, 98, 85, 43, 62, 79, 7, 82, 21, 93, 41, 56, 13, 83, 71, 73, 46, 28, 84, 16, 60, 26, 25, 20, 52, 1, 48, 61, 36, 72, 75, 17, 90, 80, 105, 9, 44, 65, 97, 39, 15, 69, 49, 38, 22, 92, 64, 45, 54, 76, 88, 59, 103, 35, 66, 96, 58];

        // $.ajax({
        //     type: 'GET',
        //     //url: 'https://special.matchtv.ru/michelin2018/get_city_data/22',
        //     url: 'https://special.matchtv.ru/michelin2018/get_city_list',
        //     success: function (data) {
        //         for (var i = 0; i < data.length; i++) { 
        //             ids.push(data[i].id);
        //             console.log(data[i].id);
        //         }
        //     }
        // });

        //         console.log(ids.length);
            // $.ajax({
            //     type: 'GET',
            //     url: 'https://special.matchtv.ru/michelin2018/get_city_data/66',
            //     success: function (data) {
            //         console.log(data);
            //     }
            // });


        //https://special.matchtv.ru/michelin2018/get_city_data/32
";
?>
<?php $this->registerJs($script, yii\web\View::POS_END);?>
