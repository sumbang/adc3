<?php

use app\models\Habilitation;
use yii\jui\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Employe;
use app\models\Exercice;
use yii\helpers\ArrayHelper;
use app\models\Nature;
use yii\jui\AutoComplete;
use app\models\Roles;
use app\models\Menus;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Suspension */
/* @var $form yii\widgets\ActiveForm */

$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M10";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

$data = Employe::find()
    ->select(['CONCAT(NOM, \' \', PRENOM) as value', 'CONCAT(NOM, \' \', PRENOM) as  label','MATRICULE as id'])
    ->asArray()
    ->all();

?>

<div class="suspension-form">

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

     <?php if($model->isNewRecord){


         $data = array();
         $query = "SELECT * FROM employe WHERE STATUT = 1 "; $d = array();

     if(Yii::$app->user->identity->ROLE == "R3") {

         $direction = "(";

         if(Yii::$app->user->identity->DIRECTION != null) {
             $emps = Employe::find()->where(["DIRECTION" => Yii::$app->user->identity->DIRECTION])->all();
             foreach($emps as $emp) {
                 if(!in_array($emp->MATRICULE,$d)) {
                     if(count($d) == 0 ) $direction.= "'".$emp->MATRICULE."'";
                     else $direction.= ",'".$emp->MATRICULE."'";
                     $d[] = $emp->MATRICULE;
                 }
             }
         }

         if(Yii::$app->user->identity->DEPARTEMENT != null) {
             $emps = Employe::find()->where(["CODEDPT" => Yii::$app->user->identity->DEPARTEMENT])->all();
             foreach($emps as $emp) {
                 if(!in_array($emp->MATRICULE,$d)) {
                     if(count($d) == 0 ) $direction.= "'".$emp->MATRICULE."'";
                     else $direction.= ",'".$emp->MATRICULE."'";
                     $d[] = $emp->MATRICULE;
                 }
             }
         }

         if(Yii::$app->user->identity->SERVICE != null) {
             $emps = Employe::find()->where(["SERVICE" => Yii::$app->user->identity->SERVICE])->all();
             foreach($emps as $emp) {
                 if(!in_array($emp->MATRICULE,$d)) {
                     if(count($d) == 0 ) $direction.= "'".$emp->MATRICULE."'";
                     else $direction.= ",'".$emp->MATRICULE."'";
                     $d[] = $emp->MATRICULE;
                 }
             }
         }

         $direction.=")"; }

         if(count($d) != 0) $query.=" AND MATRICULE IN $direction";

         $emps = Employe::findBySql($query)->orderBy(["NOM"=>SORT_ASC])->all();

         foreach ($emps as $emp) {
             $data[$emp->MATRICULE] = $emp->NOM . " " . $emp->PRENOM;
         }

         echo $form->field($model, 'MATICULE')->widget(Select2::classname(), [
             'data' => $data,
             'language' => 'fr',
             'options' => ['placeholder' => 'Choisir une personne ...'],
             'pluginOptions' => [
                 'allowClear' => true
             ],
         ]);


     } else echo $form->field($model, 'MATICULE')->dropDownList(ArrayHelper::map(Employe::find()->where(['STATUT'=>0])->all(),"MATRICULE","fullname"),['prompt'=>'choisir','disabled'=>($model->STATUT=="V")?true:false]);  ?>

    <?php echo $form->field($model, 'ANNEEEXIGIBLE')->dropDownList(ArrayHelper::map(Exercice::find()->where(['STATUT'=>'O'])->all(),"ANNEEEXIGIBLE","ANNEEEXIGIBLE"),['prompt'=>'choisir','disabled'=>($model->STATUT=="V")?true:false]); ?>

<?php if($model->isNewRecord) echo $form->field($model, 'NATURE')->dropDownList(ArrayHelper::map(Nature::find()->all(),"ID","LIBELLE"),['prompt'=>'choisir']); else echo $form->field($model, 'NATURE')->dropDownList(ArrayHelper::map(Nature::find()->all(),"ID","LIBELLE"),['prompt'=>'choisir','disabled'=>($model->STATUTLEVE == 2)?false:true]);  ?>


<?php


if ($model->STATUT == "V") {
   /*echo '<label class="control-label">Date de debut</label>'; echo DatePicker::widget([
        'model' => $model,
        'value' => $model->DATEDEBUT,
        'attribute' => 'DATEDEBUT',
        'language' => 'fr',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control input-sm','placeholder' => 'Choisir une date','required'=>true,'disabled'=>true],

    ]);*/

    echo $form->field($model, 'DATEDEBUT')->textInput(['required' => true,'type'=>'date','disabled'=>true]);

}

else {
  /*  echo DatePicker::widget([
        'model' => $model,
        'value' => $model->DATEDEBUT,
        'attribute' => 'DATEDEBUT',
        'language' => 'fr',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control input-sm','placeholder' => 'Choisir une date','required'=>true],

    ]);*/

    echo $form->field($model, 'DATEDEBUT')->textInput(['required' => true,'type'=>'date']);

}


?><br>

    <?php

    if ($model->STATUT == "V") {
        if ($model->STATUTLEVE == 1) {


          /*  echo '<label class="control-label">Date de fin</label>';
            echo DatePicker::widget([
                'model' => $model,
                'value' => $model->DATEFIN,
                'attribute' => 'DATEFIN',
                'language' => 'fr',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control input-sm','placeholder' => 'Choisir une date','required'=>true],

            ]); */

            echo $form->field($model, 'DATEFIN')->textInput(['required' => true,'type'=>'date']);
        }

        else {

           /* echo '<label class="control-label">Date de fin</label>';
            echo DatePicker::widget([
                'model' => $model,
                'value' => $model->DATEFIN,
                'attribute' => 'DATEFIN',
                'language' => 'fr',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control input-sm','placeholder' => 'Choisir une date','required'=>true,'disabled'=>($model->STATUTLEVE == 2)?false:true],

            ]); */

            echo $form->field($model, 'DATEFIN')->textInput(['required' => true,'type'=>'date','disabled'=>($model->STATUTLEVE == 2)?false:true]);

        }
    }

    ?><br>

<?php  //echo $form->field($model, 'DATEDEBUT')->textInput(['type'=>'date','required'=>true]); ?>

    <?php //echo $form->field($model, 'DATEFIN')->textInput(['type'=>'date','required'=>true,'disabled'=>$model->STATUTLEVE==2?true:false]); ?>

    <?= $form->field($model, 'COMMENTAIRE')->textarea(['rows' => 6]) ?>

<?php echo $form->field($model, 'DOCUMENTFILE')->fileInput()->label("Attestion de suspension");  $model->getDOC(); ?>


<?php if($model->STATUT == "V") { if($model->STATUTLEVE == 1) echo $form->field($model, 'DOCUMENTFILE2')->fileInput()->label("Attestion de levee de suspension"); $model->getDOC(); } ?>



<?php
        
        if($model->isNewRecord) echo Html::submitButton('Enregistrer', ['class' => 'btn btn-success']);
        
        else {

            if($model->STATUT == "E") {

                echo Html::submitButton('Enregistrer', ['class' => 'btn btn-success'])." ";

                if ($habilation->ADELETE == 1)  echo Html::a('Valider',['suspension/valider','id'=>$model->ID_SUSPENSION], ['class' => 'btn btn-primary'])." ". Html::a('Supprimer',['suspension/annuler','id'=>$model->ID_SUSPENSION], ['class' => 'btn btn-danger']);

            }

            else if($model->STATUT == "V"){

                echo '<input type="hidden" name="lever" id="lever" value="1" />';

                echo Html::submitButton('Enregistrer et Lever la suspension', ['class' => 'btn btn-success'])." ";

                /*echo Html::a('Lever la suspension',['suspension/lever','id'=>$model->ID_SUSPENSION], ['class' => 'btn btn-primary']);*/

            }



        }
        
        
        ?>

    <?php ActiveForm::end(); ?>

</div>
