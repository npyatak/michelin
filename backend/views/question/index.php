<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use common\models\Week;
use common\models\Question;

$this->title = 'Вопросы';
$this->params['breadcrumbs'][] = $this->title;

$weeks = Week::find()->all();
$weekArr = [];
foreach ($weeks as $week) {
    $weekArr[$week->id] = $week->name ? $week->name : $week->number;
}
?>

<div class="index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить вопрос', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'title',   
                [
                    'attribute' => 'week_id',
                    'format' => 'raw',
                    'value' => function($data) use($weekArr) {
                        return $weekArr[$data->week_id];
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'week_id', $weekArr, ['prompt'=>''])
                ], 
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => function($data) {
                        return $data->getStatusArray()[$data->status];
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'status', Question::getStatusArray(), ['prompt'=>''])
                ], 
                // [
                //     'attribute' => 'image',
                //     'header' => 'Изображение',
                //     'format' => 'raw',
                //     'value' => function($data) {
                //         return $data->image ? Html::img($data->imageUrl, ['width' => '200']) : '';
                //     },
                // ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
