<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = \Yii::t('app','Url Shortener');
?>
<div class="site-index">

    <?php
        $form = ActiveForm::begin([
            'layout' => 'horizontal',
            'action' => ['index'],
            'method' => 'post',
            'class' => 'form-horizontal',
        ]);

        echo $form->field($model, 'url')->textInput(['maxlength' => true]);

        echo $form->field($model, 'link')->textInput(['maxlength' => true, 'placeholder' => \Yii::t('app', 'leave empty for autogeneration')]);

        echo $form->field($model, 'date_to')->input('date');

        echo Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-primary pull-right']) ;

        ActiveForm::end();
    ?>


</div>
