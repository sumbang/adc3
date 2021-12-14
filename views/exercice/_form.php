<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Exercice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="exercice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ANNEEEXIGIBLE')->textInput() ?>

    <?php if($model->isNewRecord) { ?>

    <?php

     echo $form->field($model, 'DATEBEDUT')->textInput(['required' => true,'type'=>'date'])

/*echo '<label class="control-label">Date de debut</label>';

        echo DatePicker::widget([
            'model' => $model,
            'value' => $model->DATEBEDUT,
            'attribute' => 'DATEBEDUT',
            'language' => 'fr',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control input-sm', 'placeholder' => 'Choisir une date'],

        ]);*/

?><br>

<?php

/*echo '<label class="control-label">Date de fin</label>';

        echo DatePicker::widget([
            'model' => $model,
            'value' => $model->DATEFIN,
            'attribute' => 'DATEFIN',
            'language' => 'fr',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control input-sm', 'placeholder' => 'Choisir une date'],

        ]); */

        echo $form->field($model, 'DATEFIN')->textInput(['required' => true,'type'=>'date'])

?><br>

    <?php } ?>


    <div class="form-group">

         <?php
 echo Html::submitButton('ENREGISTRER', ['class' => 'btn btn-success']);
         ?>
    
    </div>

    <?php ActiveForm::end(); ?>

</div>
