<?php

namespace frontend\widgets\share;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class ShareAsset extends AssetBundle
{
    
    public $sourcePath = __DIR__ . '/assets';
    //public $basePath = '@webroot';
    //public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/share.js',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
