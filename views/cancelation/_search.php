<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CancelationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cancelation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'JOUISSANCE') ?>

    <?= $form->field($model, 'DEBUT') ?>

    <?= $form->field($model, 'PERIODE') ?>

    <?= $form->field($model, 'COMMENTAIRE') ?>

    <?php // echo $form->field($model, 'FICHIER') ?>

    <?php // echo $form->field($model, 'IDUSER') ?>

    <?php // echo $form->field($model, 'DATECREATION') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
