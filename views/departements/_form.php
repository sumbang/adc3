<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Departements */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="departements-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'LIBELLE')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Enregistrer', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
