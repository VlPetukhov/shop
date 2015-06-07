<?php
/**
 * @filename ProductController
 * @namespace app\modules\backend\controllers
 * @class ProductController
 */

namespace app\modules\backend\controllers;

use yii\web\Controller;

class ProductController extends Controller
{
    /**
     * Products list
     *
     * @param integer $id
     */
    public function actionIndex($id = null)
    {
        echo('Products for category ' . $id);
    }
}