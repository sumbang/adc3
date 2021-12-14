<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Roles;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'EMAIL')->textInput(['maxlength' => true]) ?>

    <?php if($model->isNewRecord) echo $form->field($model, 'PASSWORD')->passwordInput(['maxlength' => true,'required'=>true]) ?>
    
    <?= $form->field($model, 'NOM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ROLE')->dropDownList(ArrayHelper::map(Roles::find()->orderBy(['LIBELLE'=>SORT_ASC])->all(),"CODE","LIBELLE")) ?>

    <?= $form->field($model, 'INITIAL')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'NIVEAU')->dropDownList([1 => 'Niveau 1', 2=> 'Niveau 2']) ?>

    <?= $form->field($model, 'DIRECTION')->dropDownList(ArrayHelper::map(\app\models\Direction::find()->orderBy(['LIBELLE'=>SORT_ASC])->all(),"ID","LIBELLE"),["prompt"=>"Choisir"]) ?>

    <?= $form->field($model, 'DEPARTEMENT')->dropDownList(ArrayHelper::map(\app\models\Departements::find()->orderBy(['LIBELLE'=>SORT_ASC])->all(),"CODEDPT","LIBELLE"),["prompt"=>"Choisir"]) ?>

    <?= $form->field($model, 'SERVICE')->dropDownList(ArrayHelper::map(\app\models\Service::find()->orderBy(['LIBELLE'=>SORT_ASC])->all(),"ID","LIBELLE"),["prompt"=>"Choisir"]) ?>


    <div class="form-group">
        <?= Html::submitButton('Enregistrer', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
