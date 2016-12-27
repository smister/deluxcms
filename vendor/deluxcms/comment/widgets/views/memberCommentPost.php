<?= \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'showOnEmpty' => true,
    'layout' => '{items}',
    'options' => [
        'tag' => 'div',
    ],
    'itemOptions' => [
        'tag' => 'div',
        'class' => 'media pd0',
    ],
    'itemView' => function ($model, $key, $index, $widget) use ($isFirst){
        return $this->renderFile('@vendor/deluxcms/comment/widgets/views/memberComment.php', ['model' => $model, 'isFirst' => $isFirst]);
    }
])?>