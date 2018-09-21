<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Week */

$this->title = 'Обновить неделю ' . $model->number. ' ('.$model->name.')';
$this->params['breadcrumbs'][] = ['label' => 'Недели', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->number. ' ('.$model->name.')', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="week-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
