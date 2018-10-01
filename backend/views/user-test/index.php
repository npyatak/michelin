<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use common\models\Week;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\WeekSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Недели';
$this->params['breadcrumbs'][] = $this->title;

$arr = [0 => 'Нет', 1 => 'Да'];

$weeks = Week::find()->all();
$weekArr = [];
foreach ($weeks as $week) {
    $weekArr[$week->id] = $week->name ? $week->name : $week->number;
}
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
                if($model->is_finished) {
                    return ['class' => 'success'];
                }
            },
            'columns' => [
                [
                    'attribute' => 'week_id',
                    'format' => 'raw',
                    'value' => function($data) {
                        return $data->week->name ? $data->week->name : $data->week->number;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'week_id', $weekArr, ['prompt'=>''])
                ],
                [
                    'attribute' => 'user_id',
                    'format' => 'raw',
                    'value' => function($data) {
                        return Html::a($data->user->name ? $data->user->fullName : $data->user_id, Url::toRoute(['user/view', 'id' => $data->user_id]));
                    }
                ],
                [
                    'attribute' => 'is_finished',
                    'value' => function($data) use($arr) {
                        return $arr[$data->is_finished];
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'is_finished', $arr, ['prompt'=>'']),
                ],
                'score',
                'right_answers',
                [
                    'attribute' => 'time',
                    'value' => function($data) {
                        if($data->time) {
                            //return $data->time;
                            return date('i:s:ms', $data->time);
                        }
                    }
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
