<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'IDUSER') ?>

    <?= $form->field($model, 'EMAIL') ?>

    <?= $form->field($model, 'PASSWORD') ?>

    <?= $form->field($model, 'DATECREATION') ?>

    <?= $form->field($model, 'TOKEN') ?>

    <?php // echo $form->field($model, 'AUTHKEY') ?>

    <?php // echo $form->field($model, 'NOM') ?>

    <?php // echo $form->field($model, 'ROLE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
