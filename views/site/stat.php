<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = \Yii::t('app','Url Shortener');
?>
<div>
    <h3><?=\Yii::t('app','Overall stat for 2 weeks')?></h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'url',
            'link',
            [
                'attribute'=>'cnt',
                'label' => \Yii::t('app','Redirects count')
            ],
        ],
    ]); ?>
</div>