<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use unclead\multipleinput\TabularInput;
use common\components\ElfinderInput;

use common\models\Week;

$weeks = Week::find()->all();
$weekArr = [];
foreach ($weeks as $week) {
    $weekArr[$week->id] = $week->name ? $week->name : $week->number;
}
?>

<div class="form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?=$form->errorSummary($model);?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'week_id')->dropDownList($weekArr, ['class'=>'']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'status')->dropDownList($model->getStatusArray()) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'right_answer_points')->textInput() ?>
        </div>
        <div class="col-sm-3">
    		<?= $form->field($model, 'image')->widget(ElfinderInput::className());?>
    	</div>
    </div>

    <?= $form->field($model, 'comment')->textarea(['rows' => 4]) ?>

	<hr>

    <div class="tabular-input">
	    <h4>Ответы</h4>
		<?= TabularInput::widget([
			'min' => 2,
			'rendererClass' => '\common\components\CustomTableRenderer',
			'removeButtonOptions' => [
				'label' => 'X',
			],
	        'addButtonOptions' => [
	            'label' => 'Добавить',
	            'class' => 'btn btn-primary'
	        ],
	        'addButtonPosition' => TabularInput::POS_FOOTER,
		    'models' => $answerModels,
		    'columns' => [
		        [
		            'name'  => 'id',
		            'type'  => 'hiddenInput',
		        ],
		        [
		        	'title' => 'Текст',
		        	'name' => 'text',
	                'enableError' => true,
		            'options' => [
		            	'class' => 'w170px'
		        	],
		        ],
		        [
		        	'title' => 'Верный',
		        	'name' => 'is_right',
		            'type'  => 'checkbox',
		            'options' => [
		            	'class' => 'w40px'
		        	],
		        ],
		        // [
		        // 	'title' => 'Изображение',
		        //     'name'  => 'image',
		        //     'type'  => ElfinderInput::className(),
		        //     'options' => [
		        //     	'class' => 'w200px',
		        //     	'buttonName' => 'О',
		        // 	],
		        // ],
		    ],
		]) ?>
	</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
