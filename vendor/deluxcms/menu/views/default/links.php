<?php

use yii\widgets\ListView;

$dataProvider = $menuLinkSearch->search($params);
$queryParams = Yii::$app->request->getQueryParams();
$menuId = isset($queryParams['MenuLinkSearch']['menu_id']) ? (int) $queryParams['MenuLinkSearch']['menu_id'] : 0;
$parentId = isset($params['parent_id']) ? (int)$params['parent_id'] : 0;

?>

<?php if (empty($menuId)):?>
    <h4>点击菜单查看数据</h4>
<?php elseif($parentId == 0 && $dataProvider->count == 0):?>
    <h4>找不到任何数据</h4>
<?php else:?>

<?= ListView::widget([
    'id' => 'menu-link-grid',
    'dataProvider' => $dataProvider,
    'layout' => '{items}',
    'showOnEmpty' => true,
    'options' => [
        'tag' => 'ul',
        'class' => 'sortable ui-sortable',
        'data-parentid' => empty($params['parent_id']) ? null : $params['parent_id'],
    ],
    'itemOptions' => [
        'tag' => 'li',
        'class' => 'sortable-item ui-sortable-handle',
    ],
    'itemView' => function ($model, $key, $index, $widget) use ($menuLinkSearch) {
        return $this->render('link', [
            'model' => $model,
            'menuLinkSearch' => $menuLinkSearch,
        ]);
    }
])?>
<?php endif;?>