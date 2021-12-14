<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Typeabsence */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="typeabsence-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CODEABS')->textInput(['maxlength' => true,'disabled'=>$model->isNewRecord?false:true]) ?>

    <?= $form->field($model, 'LIBELLE')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Enregistrer', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
