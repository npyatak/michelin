<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Week */

$this->title = 'Добавить неделю';
$this->params['breadcrumbs'][] = ['label' => 'Недели', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="week-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
