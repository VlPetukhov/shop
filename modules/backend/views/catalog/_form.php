<?php
/**
 * @var \app\modules\backend\components\Catalog $catalog
 * @var \app\models\CatalogItem $catalogItem
 */
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

?>
<? $form = ActiveForm::begin([
    'id' => 'catalog-item',
])?>
    <div>
        <?= $form->field($catalogItem, 'name')->textInput() ?>
    </div>
    <div>
        <?php
            $parents = $catalog->getParents();
            $options = [
                'disabled' => empty($parents),
            ];
            $parents = ['' => 'Root element'] + $parents;
        ?>
        <?= $form->field($catalogItem, 'parent_id')->dropDownList($parents, $options)?>
    </div>
    <div>
        <?= $form->field($catalogItem, 'list_position')->textInput()?>
    </div>
    <div>
        <?= Html::submitButton()?>
    </div>

<? $form->end()?>