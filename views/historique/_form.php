<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Historique */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="historique-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'LIBELLE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QUANTITE')->textInput() ?>

    <?= $form->field($model, 'FICHIER')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
