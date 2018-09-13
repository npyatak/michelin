<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use common\models\Page;

$this->title = 'Страницы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="week-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить страницу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'=>function($model){
            if($model->status === Page::STATUS_INACTIVE) {
                return ['class' => 'danger'];
            }
        },
        'columns' => [
            'id',
            'url',
            'title',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($data) {
                    return $data->getStatusArray()[$data->status];
                },
                'filter' => Html::activeDropDownList($searchModel, 'status', Page::getStatusArray(), ['prompt'=>''])
            ], 
            [
                'attribute' => 'is_page',
                'format' => 'raw',
                'value' => function($data) {
                    return $data->getIsPageArray()[$data->is_page];
                },
                'filter' => Html::activeDropDownList($searchModel, 'is_page', Page::getIsPageArray(), ['prompt'=>''])
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        $url = Yii::$app->urlManagerFrontEnd->createUrl(['page/'.$model->url]);
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, []);
                    },
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>