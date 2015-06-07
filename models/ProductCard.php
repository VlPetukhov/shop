<?php
/**
 * @filename ProductCard
 * @namespace app\models
 * @class ProductCard
 *
 * @property integer $id
 * @property integer $catalog_id
 * @property string $header
 * @property string $main_photo
 * @property string $max_price
 * @property string $min_price
 * @property boolean $negotiated_price
 * @property boolean $show
 */

namespace app\models;

use yii\db\ActiveRecord;

class ProductCard extends ActiveRecord
{
    /**
     * @property \yii\web\UploadedFile $userFile
     */
    public $userFile;

    /**
     * Default max image file size in bytes
     * @var integer $_imageFileSize
     */
    protected $_imageFileSize = 2621440; // 2.5 MB

    /**
     * Default minimum image size in pixels
     * @var integer $_imageSize
     */
    protected $_imageSize = 350;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%product_card}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['header', 'catalog_id', 'userFile'], 'required', 'on' => ['create', 'update']],

            [['header'], 'string', 'max' => 255, 'on' => ['create', 'update']],

            [['catalog_id'], 'number', 'integerOnly' => true, 'min' => 0, 'on' => ['create', 'update']],
            [['catalog_id'], 'CatalogIdValidator', 'on' => ['create', 'update']],

            [
                ['userFile'],
                'image',
                'mimeTypes' => 'image/png, image/jpeg, image/bmp',
                'maxSize' => $this->_imageFileSize,
                'minWidth' => $this->_imageSize,
                'minHeight' => $this->_imageSize,
                'on' => ['create', 'update']
            ],

            [['negotiated_price', 'show'], 'boolean', 'on' => ['create', 'update']],
        ];
    }

    /**
     * Catalog_id validator
     *
     * @param string $attribute the attribute currently being validated
     * @param mixed $params the value of the "params" given in the rule
     */
    public function CatalogIdValidator($attribute, $params)
    {
        if(isset($this->$attribute)){
            $isExists = CatalogItem::find()->select('id')->where(['id' => $this->$attribute])->exists();

            if(!$isExists){
                $this->addError($attribute, 'Catalog ID is not exist.');
            }
        }
    }

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        if(isset(\Yii::$app->params['ProductCardImageMinSize'])){
            $this->_imageSize  = \Yii::$app->params['ProductCardImageMinSize'];
        }

        if(isset(\Yii::$app->params['ProductCardImageFileMaxSize'])){
            $this->_imageFileSize  = \Yii::$app->params['ProductCardImageFileMaxSize'];
        }
    }

    /**
     * Relations
     */

}