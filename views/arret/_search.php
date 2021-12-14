<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ArretSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="arret-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID_SUSPENSION') ?>

    <?= $form->field($model, 'JOUISSANCE') ?>

    <?= $form->field($model, 'DATEDEBUT') ?>

    <?= $form->field($model, 'DATEFIN') ?>

    <?= $form->field($model, 'STATUT') ?>

    <?php // echo $form->field($model, 'DATEEMIS') ?>

    <?php // echo $form->field($model, 'DATEVAL') ?>

    <?php // echo $form->field($model, 'DATEANN') ?>

    <?php // echo $form->field($model, 'COMMENTAIRE') ?>

    <?php // echo $form->field($model, 'DOCUMENT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
