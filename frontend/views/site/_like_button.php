<?php 
use yii\helpers\Html;

use common\models\PostAction;
?>

<?php if(Yii::$app->user->isGuest):?>
    <?=Html::a('Голосовать', null, [
        'class' => 'login-modal-btn',
    ]);?>
<?php elseif($model->userCan(PostAction::TYPE_LIKE)):?>
    <?=Html::a('Голосовать', null, [
        'class' => 'vote-btn',
    ]);?>
<?php endif;?>