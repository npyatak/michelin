<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\CustomCKEditor;
use kartik\datetime\DateTimePicker;
use common\components\ElfinderInput;
?>

<div class="week-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'number')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?php $startDate = date('d.m.Y H:i', time());?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'image')->widget(ElfinderInput::className());?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'dateStartFormatted')->widget(
                DateTimePicker::className(), [
                    'removeButton' => false,
                    'pluginOptions' => [
                        'format' => 'dd.mm.yyyy hh.ii',
                        'todayHighlight' => true,
                        'autoclose' => true,
                    ]
                ]
            );?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'dateEndFormatted')->widget(
                DateTimePicker::className(), [
                    'removeButton' => false,
                    'pluginOptions' => [
                        'format' => 'dd.mm.yyyy hh.ii',
                        'todayHighlight' => true,
                        'autoclose' => true,
                    ]
                ]
            );?>
        </div>
    </div>

    <?= $form->field($model, 'description')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
