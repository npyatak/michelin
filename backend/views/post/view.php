<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

use common\models\Post;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Посты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Опубликовать', ['status', 'id' => $model->id, 'status' => Post::STATUS_ACTIVE], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Забанить', ['status', 'id' => $model->id, 'status' => Post::STATUS_BANNED], ['class' => 'btn btn-danger']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'user_id',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a($model->user->name ? $model->user->fullName : $model->user_id, Url::toRoute(['/user/view', 'id'=>$model->user_id]));
                }
            ],  
            [
                'attribute' => 'contest_stage_id',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a($model->contestStage->name, Url::toRoute(['contest_stage/view', 'id' => $model->contest_stage_id]));
                },
            ],
            [
                'attribute' => 'media',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::img($model->srcUrl, ['width' => '140px']);
                }
            ],
            'yt_id',
            'text:ntext',
            [
                'attribute' => 'score',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a($model->score, Url::toRoute(['post-action/index', 'PostActionSearch[post_id]' => $model->id]));
                },
            ],            
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($model) {
                    return $model->statusLabel;
                }
            ],
            [
                'attribute' => 'created_at',
                'value' => function($model) {
                    return date('d.m.Y H:i', $model->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function($model) {
                    return date('d.m.Y H:i', $model->updated_at);
                }
            ],
        ],
    ]) ?>

</div>
