<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HabilitationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="habilitation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'CODEMENU') ?>

    <?= $form->field($model, 'CODEROLE') ?>

    <?= $form->field($model, 'ACREATE') ?>

    <?= $form->field($model, 'AREAD') ?>

    <?php // echo $form->field($model, 'AUPDATE') ?>

    <?php // echo $form->field($model, 'ADELETE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
