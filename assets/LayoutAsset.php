<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LayoutAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
    ];
    public $cssOptions = ['position' => \yii\web\View::POS_HEAD];
    public $js = [
        'js/jquery-migrate-1.1.1.js',
        'js/jquery.easing.1.3.js',
        'js/script.js',
        'js/superfish.js',
        'js/jquery.equalheights.js',
        'js/jquery.mobilemenu.js',
        'js/tmStickUp.js',
        'js/jquery.ui.totop.js',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}