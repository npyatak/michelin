<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Поделиться историей';
?>

<?php $form = ActiveForm::begin([
    'id' => 'creative-contest-form',
    'options' => [
        'method' => 'post',
        'enctype' => 'multipart/form-data',
    ]
    ]); ?>

    <?= $form->field($model, 'mediaFile')->fileInput() ?>

    <?= $form->field($model, 'yt_id')->textInput() ?>

    <?= $form->field($model, 'text')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'creative-contest-button']) ?>
    </div>

<?php ActiveForm::end(); ?>