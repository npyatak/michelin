<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Поделиться историей';
?>

<div class="upload-form">
    <div class="upload-inner">
        <div class="upload-title">Поделиться историей</div>
        <?php $form = ActiveForm::begin([
            'id' => 'creative-contest-form',
            'options' => [
                'method' => 'post',
                'enctype' => 'multipart/form-data',
            ]
        ]); ?>

            <?=$form->field($model, 'mediaFile')->widget(\dosamigos\fileinput\FileInput::className(), [
                'options' => [
                    'accept' => 'image/*', 'multiple' => false,
                ],
                'thumbnail' => false,
                'style' => \dosamigos\fileinput\FileInput::STYLE_CUSTOM,
                'customView' => '@frontend/views/creative-contest/_fileinput_custom_view.php',
            ])->label(false);?>

            <?= $form->field($model, 'yt_id', ['template' => '<div class="form-link">{label}<div>{input}</div></div>'])->textInput()->label('или ссылка на видео на youtube') ?>

            <?= $form->field($model, 'text', ['template' => '<div class="form-text">{label}<div>{input}</div></div>'])->textarea()->label('ваша история:') ?>

            <div class="form-bottom">
                <div>История будет опубликована  в течение 24 часов</div>
                <div>
                    <button type="submit" class="btn btn-oblique btn-yellow"><span>Отправить</span></button>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>



