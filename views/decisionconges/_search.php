<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DecisioncongesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="decisionconges-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID_DECISION') ?>

    <?= $form->field($model, 'MATICULE') ?>

    <?= $form->field($model, 'ANNEEEXIGIBLE') ?>

    <?= $form->field($model, 'REF_DECISION') ?>

    <?= $form->field($model, 'DEBUTPERIODE') ?>

    <?php // echo $form->field($model, 'FINPERIODE') ?>

    <?php // echo $form->field($model, 'DEBUTPLANIF') ?>

    <?php // echo $form->field($model, 'FINPLANIF') ?>

    <?php // echo $form->field($model, 'DEBUTREELL') ?>

    <?php // echo $form->field($model, 'FINREEL') ?>

    <?php // echo $form->field($model, 'STATUT') ?>

    <?php // echo $form->field($model, 'DATEEMIS') ?>

    <?php // echo $form->field($model, 'DATEVAL') ?>

    <?php // echo $form->field($model, 'DATESUSP') ?>

    <?php // echo $form->field($model, 'DATEANN') ?>

    <?php // echo $form->field($model, 'DATEREPRISE') ?>

    <?php // echo $form->field($model, 'DATECLOTURE') ?>

    <?php // echo $form->field($model, 'SITUTATIONFAMILIALE') ?>

    <?php // echo $form->field($model, 'MODETRANSPORT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
