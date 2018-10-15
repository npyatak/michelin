<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Поделиться историей';
?>

<div class="confirm-upload">
    <div class="confirm-title">Ссылка на историю</div>
    <div class="confirm-link"><a href="">https://special.matchtv.spb.ru/michelin2018/123241325</a></div>
    <a class="btn btn-oblique" target="_blank" href=""><span>ok</span></a>
</div>

<div class="upload-form">
    <div class="upload-inner">
        <div class="upload-title">Поделиться историей</div>
        <form action="">
            <div class="image"></div>
            <div class="form-link">
                <label for="form-link">или ссылка на видео на youtube</label>
                <div>
                    <input id="form-link" type="text" class="form-control">
                </div>
            </div>
            <div class="form-text">
                <label for="form-text">ваша история:</label>
                <div>
                    <textarea name="" id="form-text" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-bottom">
                <div>История будет опубликована  в течение 24 часов</div>
                <div>
                    <button type="submit" class="btn btn-oblique btn-yellow"><span>Отправить</span></button>
                </div>
            </div>
        </form>
    </div>
</div>

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