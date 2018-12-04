<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\editable\Editable;

use common\models\Post;
use common\models\ContestStage;

$this->title = 'Посты';
$this->params['breadcrumbs'][] = $this->title;

$contestStageArr = [];
foreach (ContestStage::find()->all() as $cs) {
    $contestStageArr[$cs->id] = mb_substr($cs->name, 0, 7).'...';
}
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Выгрузить в Excel', ['excel-export'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['id' => 'grid-pjax']); ?>  
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => function($model) {
                if($model->status === Post::STATUS_BANNED) {
                    return ['class' => 'danger'];
                } elseif($model->status === Post::STATUS_ACTIVE) {
                    return ['class' => 'success'];
                }
            },
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],

                'id',
                [
                    'attribute' => 'contest_stage_id',
                    'format' => 'raw',
                    'value' => function($data) {
                        return Html::a(mb_substr($data->contestStage->name, 0, 7).'...', Url::toRoute(['contest_stage/view', 'id' => $data->contest_stage_id]));
                    },
                    'width' => '50px',
                    'filter' => Html::activeDropDownList($searchModel, 'contest_stage_id', $contestStageArr, ['prompt'=>'']),
                ],
                [
                    'attribute' => 'user_id',
                    'format' => 'raw',
                    'value' => function($data) {
                        return Html::a($data->user->name ? $data->user->fullName : $data->user_id, Url::toRoute(['user/view', 'id' => $data->user_id]));
                    }
                ],
                [
                    'attribute' => 'media',
                    'format' => 'raw',
                    'value' => function($data) {
                        //if($data->type == Post::TYPE_IMAGE) {
                            return Html::img($data->srcUrl, ['width' => '150px']);
                        //}
                        //return $data->media;
                    }
                ],
                'yt_id',
                [
                    'attribute' => 'score',
                    'format' => 'raw',
                    'value' => function($data) {
                        return Html::a($data->score, Url::toRoute(['post-action/index', 'PostActionSearch[post_id]' => $data->id]));
                    },
                ], 
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'status',
                    'headerOptions'=>['class'=>'kv-sticky-column'],
                    'contentOptions'=>['class'=>'kv-sticky-column'],
                    'value' => function($data) {
                        return $data->statusLabel;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'status', Post::getStatusArray(), ['prompt'=>'']),
                    'editableOptions' => [
                        'inputType' => kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                        'data' => Post::getStatusArray(),
                        'displayValueConfig' => Post::getStatusArray(),
                    ],
                ],
                [
                    'attribute' => 'type',
                    'value' => function($data) {
                        return $data->typeLabel;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'type', Post::getTypeArray(), ['prompt'=>'']),
                ],
                'city',
                [
                    'attribute' => 'created_at',
                    'value' => function($data) {
                        return date('d.m.Y H:i', $data->created_at);
                    }
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {approve} {ban} {update} {delete}',
                    'buttons' => [
                        'approve' => function ($url, $model) {
                            $url = Url::toRoute(['/post/status', 'id'=>$model->id, 'status' => Post::STATUS_ACTIVE]);
                            if($model->status == Post::STATUS_ACTIVE) {
                                return '';
                            }
                            return Html::a('<span class="glyphicon glyphicon-ok-sign"></span>', $url, [
                                'class' => 'status-toggle', 
                                'title' => 'Одобрить',
                                'data-pjax' => 0,
                            ]);
                        },
                        'ban' => function ($url, $model) {
                            $url = Url::toRoute(['/post/status', 'id'=>$model->id, 'status' => Post::STATUS_BANNED]);
                            if($model->status == Post::STATUS_BANNED) {
                                return '';
                            }
                            return Html::a('<span class="glyphicon glyphicon-remove-sign"></span>', $url, [
                                'class' => 'status-toggle', 
                                'title' => 'Забанить',
                                'data-pjax' => 0,
                            ]);
                        },
                    ],
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php
$script = "
    $(document).on('click', '.status-toggle', function(e) {
        var obj = $(this);

        $.ajax({
            url: obj.attr('href'),
            type: 'POST',
            success: function(result) {
                $.pjax.reload({container:'#grid-pjax'});
            }
        });

        return false;
    });
";

$this->registerJs($script, yii\web\View::POS_END);?>