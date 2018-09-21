<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use common\models\Week;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\WeekSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Недели';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="week-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить неделю', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions'=>function($model){
                if($model->isCurrent()) {
                    return ['class' => 'success'];
                }
            },
            'columns' => [
                'number',
                'name',  
                // [
                //     'attribute' => 'image',
                //     'format' => 'raw',
                //     'value' => function($data) {
                //         return Html::img($data->imageUrl, ['width' => '200px']);
                //     }
                // ],

                [
                    'attribute' => 'date_start',
                    'value' => function($data) {
                        return date('d.m.Y H:i', $data->date_start);
                    }
                ],
                [
                    'attribute' => 'date_end',
                    'value' => function($data) {
                        return date('d.m.Y H:i', $data->date_end);
                    }
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
