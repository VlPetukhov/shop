<?php
/**
 * @filename SiteController
 * @namespace app\modules\frontend\controllers
 * @class SiteController
 */

namespace app\modules\frontend\controllers;

use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}