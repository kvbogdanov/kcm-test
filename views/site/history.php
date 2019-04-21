<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = \Yii::t('app','Url Shortener');
?>
<div>
    <h3><?=\Yii::t('app','Redirects history for: ')?><?=$link->link?></h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'date',
                'value'=>function($model){return date("d.m.Y H:i", $model->date);},
            ],
            [
                'attribute'=>'ip',
                'value'=>function($model){return long2ip($model->ip);},
            ],

        ],
    ]); ?>
</div>