<?php
/**
 * @filename Catalog
 * @namespace app\components
 * @class Catalog
 *
 */

namespace app\components;

use app\models\CatalogItem;
use app\models\ProductCard;
use Exception;
use Yii;
use yii\base\Object;
use yii\db\Expression;

class Catalog extends Object
{
    /**
     * @property array $_catalog
     *
     * Formatted array that contains shop catalog
     */
    protected $_catalog = [];

    /**
     * @property \app\models\CatalogItem $currentItem
     */
    public $currentItem;

    /**
     * Catalog initialization
     */
    public function init()
    {
        parent::init();

        $items = CatalogItem::find()
            ->orderBy(['parent_id' => SORT_ASC, 'list_position' => SORT_ASC])
            ->asArray()
            ->all();

        foreach($items as $item){

            if(true == $item['deleted']){
                continue;
            }

            $itemId = (int)$item['id'];
            $parentId = (isset($item['parent_id']) && null !== $item['parent_id']) ? (int)$item['parent_id'] : null;

            if(!$parentId){
                $this->_catalog[$itemId] = [
                    'label'  => $item['name'],
                    'active' => (bool)$item['active'],
                    'url'    => $itemId,
                ];
                continue;
            }

            if(isset($this->_catalog[$parentId])){
                $this->_catalog[$parentId]['items'][$itemId] = [
                    'label'  => $item['name'],
                    'active' => (bool)$item['active'],
                    'url'    => $itemId,
                ];
            } else {
                //fix catalog integrity - delete lost items
                $this->deleteItem($itemId);
            }
        }
    }

     /**
     * Delete catalog item
     *
     * @param integer $itemId
     * @return boolean
     */
    public function deleteItem($itemId)
    {
        /** @var CatalogItem $item */
        $item = CatalogItem::findOne($itemId);

        if (!$item) {

            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if (true === (bool)$item->deleted) {
                CatalogItem::updateAllCounters(
                    ['list_position' => -1],
                    [
                        'and',
                        ['>=', 'list_position', $item->list_position],
                        ['parent_id' => $item->parent_id],
                    ]
                );

                if (!$item->delete()) {
                    throw new Exception('Can\' delete item!');
                }

            } else {
                $item->deleted     = true;
                $item->delete_date = new Expression('NOW()');

                if (!$item->save()) {
                    throw new Exception('Can\' update item during delete operation!');
                }

            }
        } catch (Exception $e) {

            $transaction->rollBack();

            return false;
        }

        $transaction->commit();

        return true;
    }

    /**
     * Gets full Catalog (with deleted items)
     * return array
     */
    public function getFullCatalog()
    {
        //@TODO Add deleted items
        return $this->_catalog;
    }

    /**
     * @return array
     */
    public function getCatalog()
    {
        return $this->_catalog;
    }

    /**
     * Gets available parents
     */
    public function getParents()
    {
        $parents = [];
        foreach($this->_catalog as  $key => $value){
            $parents[$key] = $value['label'];
        }

        return $parents;
    }

}