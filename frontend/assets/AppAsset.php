<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/font-awesome.min.css',
        'css/style.css?v=17.09_v3',
        'css/responsive.css?v=16.09_v1',
        'css/menu.css?v=16.09_v1'
    ];
    public $js = [
        'js/app.js?v=17.09_v3',
        'js/main.js?v=16.09_v3',
        'js/menu.js?v=16.09_v1'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
