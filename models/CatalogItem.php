<?php
/**
 * @filename CatalogItem
 * @namespace app\models
 * @class CatalogItem
 *
 * @property integer $id
 * @property string $name
 * @property string $icon
 * @property integer $list_position
 * @property integer|null $parent_id
 * @property boolean $active
 */

namespace app\models;

use app\modules\backend\components\Catalog;
use Exception;
use yii\db\ActiveRecord;
use yii\db\Expression;

class CatalogItem extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%catalog_item}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'list_position'], 'required', 'on' => ['create', 'update']],
            [['name'], 'string', 'max' => 60, 'on' => ['create', 'update']],

            [['parent_id'], 'filter', 'filter' => [$this, 'parentIdFilter'], 'on' => ['create', 'update']],
            [['parent_id'], 'number', 'integerOnly' => true, 'min' => 0, 'on' => ['create', 'update']],
            [['parent_id'], 'ParentIdValidator', 'on' => ['create', 'update']],

            [['list_position'], 'number', 'integerOnly' => true, 'min' => 0, 'on' => ['create', 'update']],

            [['active'], 'boolean', 'on' => ['create', 'update']],
            [['active'], 'default', 'value' => true, 'on' => ['create', 'update']],
        ];
    }

    /**
     * Parent ID filter
     */

    /**
     * Parent_id validator
     *
     * @param string $attribute the attribute currently being validated
     * @param mixed $params the value of the "params" given in the rule
     */
    public function ParentIdValidator($attribute, $params)
    {
        if(isset($this->$attribute)){
            $isExists = self::find()
                ->select('id')
                ->where(['id' => $this->$attribute])
                ->exists();

            if(!$isExists){
                $this->addError($attribute, 'Parent ID is not exist.');
            }
        }
    }

    /**
     * Parent_id filter
     */
    public function parentIdFilter($value)
    {
        if('' == $value){

            return null;
        }

        return $value;
    }


    /**
     * Relations
     */

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getProductCards()
    {
        return $this->hasMany('Product',['catalog_id' => 'id']);
    }

    /**
     * Before delete
     *
     * @return boolean
     */
    public function beforeDelete(){

        if(null === $this->parent_id){
            ProductCard::deleteAll(
                ['catalog_id' => $this->id]
            );

            CatalogItem::deleteAll(
                ['parent_id' => $this->id]
            );
        }

        return parent::beforeDelete();
    }

    /**
     * Before save
     *
     * @param bool $insert
     * @return boolean
     */
    public function beforeSave($insert)
    {
        $listPositionExists = CatalogItem::find()
            ->select('id')
            ->where(['list_position' => $this->list_position])
            ->exists();

        //increase all list position of belowItems(if destined position is occupied and if any belowItems)
        if(
            (!$this->isNewRecord && $this->isAttributeChanged('list_position')) ||
            ($this->isNewRecord && $listPositionExists)
        ){
            CatalogItem::updateAllCounters(
                ['list_position' => 1],
                [
                    'and',
                    ['>=','list_position', $this->list_position],
                    ['parent_id' => $this->parent_id],
                ]
            );
        }

        if($this->isAttributeChanged('deleted') && $this->deleted){

            ProductCard::updateAll(
                ['deleted' => true, 'delete_date' => new Expression('NOW()')],
                ['catalog_id'  => $this->id]
            );

            if(null === $this->parent_id){
                CatalogItem::updateAll(
                    ['deleted' => true, 'delete_date' => new Expression('NOW()')],
                    ['parent_id'  => $this->id]
                );
            }
        }

        return parent::beforeSave($insert);
    }

}