<?php
/**
 * @filename CatalogController
 * @namespace app\modules\backend\controllers
 * @class CatalogController
 */

namespace app\modules\backend\controllers;

use app\models\CatalogItem;
use app\modules\backend\components\Catalog;
use HttpInvalidParamException;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\HttpException;

class CatalogController extends Controller
{
    /**
     * @return array
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
     * Shows shop catalog
     * @return string
     */
    public function actionIndex()
    {
        $catalog = new Catalog();
        $highLightId = \Yii::$app->request->get('highlight_id');

        return $this->render(
            'index',
            [
                'catalog' => $catalog->getFullCatalog(),
                'highlightId' => $highLightId,
            ]
        );
    }

    /**
     * Creates new catalog element and adds it after element with id = $id
     *
     * @return string
     */
    public function actionCreateItem()
    {
        $catalogItem = new CatalogItem(['scenario' => 'create']);

        if($catalogItem->load(Yii::$app->request->post()) && $catalogItem->save())
        {
            $this->redirect(['/admin/catalog/index', 'id' => $catalogItem->id]);
        }

        $catalog = new Catalog();

        return $this->render(
            'create',
            [
                'catalog' => $catalog,
                'catalogItem' => $catalogItem,
            ]
        );
    }

    /**
     * Deletes catalog item
     *
     * @param integer $id
     *
     * @throws HttpException
     * return string
     */
    public function actionDeleteItem($id = null)
    {
        $catalog = new Catalog();

        if(!$catalog->deleteItem($id)){
            throw new HttpException(500, 'Can\'t delete item.');
        }
        $this->redirect(['/admin/catalog/index']);
    }

    /**
     * Updates catalog item
     * '
     *
     * @param integer $id
     *
     * @throws BadRequestHttpException
     * @return string
     */
    public function actionEditItem($id = null)
    {
        /** @var CatalogItem $catalogItem */
        $catalogItem = CatalogItem::findOne($id);

        if(!$catalogItem){
            throw new BadRequestHttpException();
        }

        $catalogItem->scenario = 'update';

        if($catalogItem->load(Yii::$app->request->post()) && $catalogItem->save())
        {
            $this->redirect(['/admin/catalog/index', 'id' => $catalogItem->id]);
        }

        $catalog = new Catalog();

        return $this->render(
            'edit',
            [
                'catalog' => $catalog,
                'catalogItem' => $catalogItem,
            ]
        );
    }
}