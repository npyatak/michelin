<?php
use yii\helpers\Url;
use yii\helpers\Html;

use frontend\assets\AppAsset;

use common\models\UserTest;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-TG6PTDF');</script>
    <!-- End Google Tag Manager -->

    <?php $this->head() ?>
</head>

<body class="<?=isset($this->params['bodyClass']) ? $this->params['bodyClass'] : '';?>">
    <?php $this->beginBody() ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TG6PTDF"
                height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <header>
        <a href="https://www.michelin.ru/" class="logo show-desktop" target="_blank"></a>
        <nav class="main_menu">
            <a href="<?=Url::toRoute(['site/index']);?>">
                Рули зимой
            </a>
            <a href="<?=Url::toRoute(['site/about']);?>">
                О шине
            </a>
            <a href="<?=Url::toRoute(['site/contest']);?>">
                Конкурс
            </a>
            <a href="<?=Url::toRoute(['pdf/rules_michelin.pdf'], true);?>">
                Правила
            </a>
            <a href="<?=Url::toRoute(['site/map']);?>">
                Карта
            </a>
        </nav>
        <div class="mobile-menu show-ipad-mobile">
            <div class="mobile-menu__top">
                <a href="<?=Url::home();?>" class="logo"></a>
                <a href="#" class="toggle-menu show-ipad-mobile">
                    <img src="<?=Url::toRoute('/img/helpers/menu-open.svg');?>" class="fa-bars now-active" />
                    <img src="<?=Url::toRoute('/img/helpers/menu-close.svg');?>" class="fa-times" />
                </a>
            </div>
            <div class="hidden-menu hidden">
                <div class="start">
                    <div>Старт конкурса <span class="number">17</span> <span>сентября!</span></div>
                </div>
                <?php if(!Yii::$app->user->isGuest):?>
                    <?php $userTest = UserTest::find()->where(['user_id' => Yii::$app->user->id])->one();?>
                    <?php if($userTest && $userTest->is_finished):?>
                        <a href="<?=Url::toRoute(['site/contest-result']);?>" class="user">
                            <div class="score"><?=Yii::$app->user->identity->score;?></div>
                            <div class="name"><?=Yii::$app->user->identity->fullName;?></div>
                        </a>
                    <?php else:?>
                        <div class="user">
                            <div class="score"><?=Yii::$app->user->identity->score;?></div>
                            <div class="name"><?=Yii::$app->user->identity->fullName;?></div>
                        </div>
                    <?php endif;?>
                <?php endif;?>
                <nav>
                    <a href="<?=Url::toRoute(['site/index']);?>">
                        Рули зимой
                    </a>
                    <a href="<?=Url::toRoute(['site/about']);?>">
                        О шине
                    </a>
                    <a href="<?=Url::toRoute(['site/contest']);?>">
                        Конкурс
                    </a>
                    <a href="<?=Url::toRoute(['pdf/rules_michelin.pdf'], true);?>">
                        Правила
                    </a>
                    <a href="<?=Url::toRoute(['site/map']);?>">
                        Карта
                    </a>
                </nav>
            </div>
        </div>
        <div class="start">
            <div>Старт конкурса <span class="number">17</span> <span>сентября!</span></div>
        </div>
        <?php if(!Yii::$app->user->isGuest):?>
            <?php $userTest = UserTest::find()->where(['user_id' => Yii::$app->user->id])->one();?>
                <?php if($userTest && $userTest->is_finished):?>
                <a href="<?=Url::toRoute(['site/contest-result']);?>" class="user">
                    <div class="score"><?=Yii::$app->user->identity->score;?></div>
                    <div class="name"><?=Yii::$app->user->identity->fullName;?></div>
                </a>
            <?php else:?>
                <div class="user">
                    <div class="score"><?=Yii::$app->user->identity->score;?></div>
                    <div class="name"><?=Yii::$app->user->identity->fullName;?></div>
                </div>
            <?php endif;?>
        <?php endif;?>
    </header>

    <?= $content;?>

    <?php $preUrl = Yii::$app->params['preUrl'];
    $script = "
            window.pre_url = '$preUrl';
        ";

        $this->registerJs($script, yii\web\View::POS_HEAD);
    ?>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>