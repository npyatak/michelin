<?php
use yii\helpers\Url;
use yii\helpers\Html;

use frontend\assets\AppAsset;

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
        <a href="<?=Url::home();?>" class="logo show-desktop"></a>
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
            <a href="http://michelin.promo-group.org/pdf/rules_michelin_31.08.2018_v8.pdf">
                Правила
            </a>
        </nav>
        <div class="mobile-menu show-ipad-mobile">
            <div class="mobile-menu__top">
                <a href="<?=Url::home();?>" class="logo"></a>
                <a href="#" class="toggle-menu show-ipad-mobile">
                    <img src="./img/helpers/menu-open.svg" class="fa-bars now-active" />
                    <img src="./img/helpers/menu-close.svg" class="fa-times" />
                </a>
            </div>
            <div class="hidden-menu hidden">
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
                    <a href="http://michelin.promo-group.org/pdf/rules_michelin_31.08.2018_v8.pdf">
                        Правила
                    </a>
                </nav>
            </div>
        </div>
        <div class="start">
            <div>Старт конкурса <span class="number">17</span> <span>сентября!</span></div>
        </div>
        <?php if(!Yii::$app->user->isGuest):?>
            <div class="user">
                <div class="score"><?=Yii::$app->user->identity->score;?></div>
                <div class="name"><?=Yii::$app->user->identity->fullName;?></div>
            </div>
        <?php endif;?>
    </header>

    <?= $content;?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>