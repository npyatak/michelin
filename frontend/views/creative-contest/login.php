<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<?php $this->params['bodyClass'] = 'about_page';?>

<div class="page_wrapper ">
    <div class="row text_center">
        <a href="#" class="main_title"></a>
    </div>

    <div class="auth" style="display: block;">
        <div class="close-popup"><i class="fa fa-close"></i></div>
        <div><span>Авторизуйся</span></div>
        <div>для участия в викторине необходимо авторизоваться с использованием аккаунта социальной сети</div>
        <?=\frontend\widgets\social\SocialWidget::widget(['action' => 'site/login']);?>
    </div>
    <div class="overlay" style="display: block"></div>
</div>