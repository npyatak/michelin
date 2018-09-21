<?php

use yii\helpers\Html;

$this->title = 'Изменить город' .': '. $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Города', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>

<div class="page-update">

    <h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
	    'model' => $model,
	]) ?>
</div>