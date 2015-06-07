<?php
/**
 * @var array $catalog
 */
    use yii\helpers\Html;
    use yii\helpers\Url;

?>
<div>
    <?= Html::a('Create new item', ['/admin/catalog/create-item'],['class' => 'btn btn-primary'])?>
</div>

<h2>Shop's catalog</h2>

<?php
    $editButtonsClass = 'btn btn-default btn-xs';
    $deleteButtonsClass = 'btn text-danger btn-default btn-xs';

    $prettyUrlTemplate =
        '<p>
            <a href="/admin/product/{url}/index">{label}</a>
            &nbsp;&nbsp;
            <a class="' . $editButtonsClass . '" href="/admin/catalog/{url}/edit-item">Edit</a>
            <a class="' . $deleteButtonsClass . '" href="/admin/catalog/{url}/delete-item">Delete</a>
        </p>';

    $ordinalUrlTemplate =
        '<p>
            <a href="' . Url::to(['/admin/product/index']) . '&id={url}">{label}</a>
            &nbsp;&nbsp;
            <a class="' . $editButtonsClass . '" href="' . Url::to(['/admin/catalog/edit-item']) . '&id={url}">Edit</a>
            <a class="' . $deleteButtonsClass . '" href="' . Url::to(['/admin/catalog/delete-item']) . '&id={url}">Delete item</a>
        </p>';
?>

<?= \yii\widgets\Menu::widget([
    'items' => $catalog,
    'linkTemplate' => (Yii::$app->urlManager->enablePrettyUrl) ? $prettyUrlTemplate : $ordinalUrlTemplate,

])?>
