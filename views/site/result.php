<?php

$this->title = \Yii::t('app','Url Shortener');
?>
<div class="site-index">

    <h1><?=\Yii::t('app','Congratulations!')?></h1>

    <h3><?=\Yii::t('app','You are successfully shorten your URL!')?></h3>

    <p>
    <?=\Yii::t('app','Link is:')?> <a href="/<?=$model->link?>" target="_blank"><?=Yii::$app->request->absoluteUrl?><?=$model->link?></a>
    </p>

    <p>
        <?=\Yii::t('app','See stats here:')?> <a href="/history/<?=$model->link?>" target="_blank"><?=Yii::$app->request->absoluteUrl?>history/<?=$model->link?></a>
    </p>

    <p>
        <?=\Yii::t('app','See overall stats here:')?> <a href="/stat" target="_blank"><?=Yii::$app->request->absoluteUrl?>stat</a>
    </p>


</div>