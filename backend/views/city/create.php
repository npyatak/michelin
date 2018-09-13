<?php

use yii\helpers\Html;

$this->title = 'Добавить город';
$this->params['breadcrumbs'][] = ['label' => 'Города', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-create">

    <h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
	    'model' => $model,
	]) ?>
</div>