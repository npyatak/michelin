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

    <?php $this->head() ?>

    <?php if($_SERVER['HTTP_HOST'] != 'michelin.local'):?>
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

        <img style="display: none;" src="https://ads.adfox.ru/243543/getCode?p1=bwtla&p2=fohy&pfc=bwpaj&pfb=fydog&puid1=&puid2=&puid3=&puid4=&puid5=&puid6=&puid7=&puid8=&puid9=&puid10=&puid11=&puid12=&puid13=&puid16=&puid19=&puid20=&puid21=&puid22=&puid23=&puid24=&puid25=&puid60=&puid62=&puid63=&pr=[RANDOM]&ptrc=b">
    <?php endif;?>
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
            <a href="<?=Url::toRoute(['site/rules']);?>" target="_blank">
                Правила
            </a>
            <a href="<?=Url::toRoute(['site/map']);?>">
                Карта
            </a>
            <a href="<?=Url::toRoute(['site/winners']);?>">
                Победители
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
                <!-- <div class="start">
                    <div>Старт конкурса <span class="number">17</span> <span>сентября!</span></div>
                </div> -->
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
                    <a href="<?=Url::toRoute(['site/rules']);?>" target="_blank">
                        Правила
                    </a>
                    <a href="<?=Url::toRoute(['site/map']);?>">
                        Карта
                    </a>
                    <a href="<?=Url::toRoute(['site/winners']);?>">
                        Победители
                    </a>
                </nav>
            </div>
        </div>
        <!-- <div class="start">
            <div>Старт конкурса <span class="number">17</span> <span>сентября!</span></div>
        </div> -->
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

<?php if($_SERVER['HTTP_HOST'] != 'michelin.local'):?>
<!-- DMP CODE -->
<script type='text/javascript'>
  (function (window, document) {
    var elem = document.createElement('script');
    elem.src = '//x01.aidata.io/pixel.js?pixel=4974832&v=' + Date.now();
    elem.type='text/javascript';elem.async = true;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(elem, s);
  })(window, window.document);
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-126451207-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-126451207-1');
</script>
<?php endif;?>

</body>
</html>
<?php $this->endPage() ?>