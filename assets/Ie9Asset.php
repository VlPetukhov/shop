<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Ie9Asset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/ie.css',
    ];
    public $cssOptions = ['condition' => 'lt IE9', 'position' => \yii\web\View::POS_HEAD];
    public $js = [
        'js/html5shiv.js'
    ];
    public $jsOptions = ['condition' => 'lt IE9', 'position' => \yii\web\View::POS_HEAD];
    public $depends = [
        'app\assets\LayoutAsset',
    ];
}