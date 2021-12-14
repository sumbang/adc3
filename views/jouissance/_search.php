<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\JouissanceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jouissance-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'IDNATURE') ?>

    <?= $form->field($model, 'TITRE') ?>

    <?= $form->field($model, 'NUMERO') ?>

    <?= $form->field($model, 'PERIODE') ?>

    <?= $form->field($model, 'MESSAGE') ?>

    <?php // echo $form->field($model, 'LIEU') ?>

    <?php // echo $form->field($model, 'JOUR') ?>

    <?php // echo $form->field($model, 'TYPES') ?>

    <?php // echo $form->field($model, 'DOCUMENT') ?>

    <?php // echo $form->field($model, 'IDDECISION') ?>

    <?php // echo $form->field($model, 'DATECREATION') ?>

    <?php // echo $form->field($model, 'USERCREATE') ?>

    <?php // echo $form->field($model, 'EXERCICE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
