<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Typedocument;

/* @var $this yii\web\View */
/* @var $model app\models\Documents */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="documents-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);  ?>

    <?= $form->field($model, 'NATURE')->dropDownList(ArrayHelper::map(Typedocument::find()->all(),"ID","LIBELLE"),['prompt'=>'choisir'])?>

    <?= $form->field($model, 'LIBELLE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fichier2')->fileInput()->label("Fichier joint");  $model->getFichier(); ?>

    <div class="form-group">
        <?= Html::submitButton('Enregistrer', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
