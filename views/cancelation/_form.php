<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Cancelation */
/* @var $form yii\widgets\ActiveForm */

if($model->isNewRecord){

    $model->JOUISSANCE = $_REQUEST["id"];

    $jouissance = \app\models\Jouissance::findOne($model->JOUISSANCE);

    if($jouissance->STATUT == "R") {

        $debut = $jouissance->DEBUTREPORT; $fin = $jouissance->FINREPORT;
    }

    else {

        $debut = $jouissance->DEBUT; $fin = $jouissance->FIN;
    }
}



?>

<div class="cancelation-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php

    echo $form->field($model, 'employe')->textInput(['type'=>'text','disabled'=>true]);

    echo $form->field($model, 'decision')->textInput(['type'=>'text','disabled'=>true]);

    echo $form->field($model, 'jouissances')->textInput(['type'=>'text','disabled'=>true]);

    if($model->isNewRecord) {

       /* echo '<label class="control-label">Date de suspension</label>';

        echo DatePicker::widget([
            'model' => $model,
            'value' => $model->DEBUT,
            'attribute' => 'DEBUT',
            'language' => 'fr',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control input-sm','placeholder' => 'Choisir une date','required'=>true],

        ]); */

        echo $form->field($model, 'DEBUT')->textInput(['required' => true,'type'=>'date']);


    }

    else {

        echo '<label class="control-label">Date de suspension</label>';
        echo '<input type="date" readonly class="form-control" value="'.$model->DEBUT.'"  />';
    }

    ?><br>

    <input type="hidden" name="jouissance" id="jouissance" value="<?= $_REQUEST["id"]; ?>" />

    <?= $form->field($model, 'PERIODE')->textInput(['type'=>'number','min'=>1,'readonly'=>$model->isNewRecord?false:true]) ?>

    <?= $form->field($model, 'COMMENTAIRE')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'DOCUMENTFILE')->fileInput()->label("DOCUMENT"); $model->getDOC(); ?>

    <div class="form-group">
        <?= Html::submitButton('Enregistrer', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
