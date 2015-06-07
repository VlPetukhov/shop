<?php
/**
 *Catalog item creation view
 */

    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;

?>
<div>
    <?= Html::a('To catalog', ['/admin/catalog/index'],['class' => 'btn btn-primary'])?>
</div>
    <h2>Current catalog tree</h2>
<div>
    <?= \yii\widgets\Menu::widget([
        'items' => $catalog->getCatalog(),
    ])?>
</div>
    <h2>Create new catalog item</h2>

<?php include('_form.php');?>