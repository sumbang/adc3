<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmployeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employe-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'MATRICULE') ?>

    <?= $form->field($model, 'CODECAT') ?>

    <?= $form->field($model, 'CODEECH') ?>

    <?= $form->field($model, 'CODEEMP') ?>

    <?= $form->field($model, 'CODEETS') ?>

    <?php // echo $form->field($model, 'CODECIV') ?>

    <?php // echo $form->field($model, 'CODECONT') ?>

    <?php // echo $form->field($model, 'CODEETS_EMB') ?>

    <?php // echo $form->field($model, 'NOM') ?>

    <?php // echo $form->field($model, 'PRENOM') ?>

    <?php // echo $form->field($model, 'DATEEMBAUCHE') ?>

    <?php // echo $form->field($model, 'SOLDECREDIT') ?>

    <?php // echo $form->field($model, 'SOLDEAVANCE') ?>

    <?php // echo $form->field($model, 'DATECALCUL') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
