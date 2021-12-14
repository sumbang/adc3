<?php

use app\models\Habilitation;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\Alert;
use app\models\Employe;
use app\models\Exercice;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use app\models\Typeabsence;
use yii\jui\AutoComplete;
use app\models\Roles;
use app\models\Menus;
use yii\web\View;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Absenceponctuel */
/* @var $form yii\widgets\ActiveForm */

$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M5";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>

<div class="absenceponctuel-form">

<?= Alert::widget() ?>

 <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php if($model->isNewRecord) {

        $data = array();

        $query = "SELECT * FROM EMPLOYE WHERE STATUT = 1 "; $d = array();

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

            $direction.=")";
        }

        if(count($d) != 0) $query.=" AND MATRICULE IN $direction";

        $emps = Employe::findBySql($query)->orderBy(["NOM"=>SORT_ASC])->all();

        foreach ($emps as $emp){
            $data[$emp->MATRICULE] = $emp->NOM." ".$emp->PRENOM;
        }

        echo $form->field($model, 'MATICULE')->widget(Select2::classname(), [
            'data' => $data,
            'language' => 'fr',
            'options' => ['placeholder' => 'Choisir une personne ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

       } else echo $form->field($model, 'MATICULE')->dropDownList(ArrayHelper::map(Employe::find()->all(),"MATRICULE","fullname"),['prompt'=>'choisir','disabled'=>true])  ?>

    <?= $form->field($model, 'ANNEEEXIGIBLE')->dropDownList(ArrayHelper::map(Exercice::find()->where(['STATUT'=>'O'])->all(),"ANNEEEXIGIBLE","ANNEEEXIGIBLE"),['prompt'=>'choisir','id'=>'exercice','disabled'=>$model->isNewRecord?false:true]) ?>

  <?= $form->field($model, 'CODEABS')->dropDownList(ArrayHelper::map(Typeabsence::find()->all(),"CODEABS","LIBELLE"),['prompt'=>'choisir','disabled'=>!$model->isNewRecord]) ?>

    <?php if($model->isNewRecord) echo $form->field($model, 'TYPE_DEMANDE')->dropDownList([0=>"Jour",1=>"Heure"],['prompt'=>'choisir','onchange'=>'changement()']); else echo $form->field($model, 'TYPE_DEMANDE')->dropDownList([0=>"Jour",1=>"Heure"],['disabled'=>true]); ?>

    <?php

    if($model->isNewRecord){

        echo '<div id="jours" style="display: none">';

      /*  echo '<label class="control-label">Date de départ</label>';

        echo DatePicker::widget([
            'model' => $model,
            'value' => $model->DATEDEBUT,
            'attribute' => 'DATEDEBUT',
            'language' => 'fr',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control input-sm','placeholder' => 'Choisir une date','required'=>true],

        ]); */

        echo $form->field($model, 'DATEDEBUT')->textInput(['required' => true,'type'=>'date']);


       /* echo '<br><label class="control-label">Date de retour</label>';


        echo DatePicker::widget([
            'model' => $model,
            'value' => $model->DATEFIN,
            'attribute' => 'DATEFIN',
            'language' => 'fr',
            //'dateFormat' => 'yyyy-MM-dd',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control input-sm','placeholder' => 'Choisir une date','required'=>true],

        ]); */

        echo $form->field($model, 'DATEFIN')->textInput(['required' => true,'type'=>'date']);


        echo '</div>';

        echo '<div id="heure" style="display: none">';

        echo $form->field($model, 'DUREE')->textInput(['type' => 'number']);

        echo '</div>';

    }

    else {

        if($model->CODEABS != "A003") {

            if ($model->TYPE_DEMANDE == 0) {

                echo '<div id="jours">';

                $exo = \app\models\Exercice::findOne($model->ANNEEEXIGIBLE);

                /*  echo '<label class="control-label">Date de départ</label>';


                  echo DatePicker::widget([
                      'model' => $model,
                      'value' => $model->DATEDEBUT,
                      'attribute' => 'DATEDEBUT',
                      'language' => 'fr',
                      'dateFormat' => 'yyyy-MM-dd',
                      'options' => ['class' => 'form-control input-sm', 'placeholder' => 'Choisir une date', 'required' => true,'disabled'=>!($model->STATUT == 'E')],

                  ]);*/

                echo $form->field($model, 'DATEDEBUT')->textInput(['required' => true,'type'=>'date','disabled'=>!($model->STATUT == 'E')]);


            /*    echo '<br><label class="control-label">Date de retour</label>';


                echo DatePicker::widget([
                    'model' => $model,
                    'value' => $model->DATEFIN,
                    'attribute' => 'DATEFIN',
                    'language' => 'fr',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control input-sm', 'placeholder' => 'Choisir une date', 'required' => true,'disabled'=>!($model->STATUT == 'E')],

                ]); */

                echo $form->field($model, 'DATEFIN')->textInput(['required' => true,'type'=>'date','disabled'=>!($model->STATUT == 'E')]);


                echo '</div>';

            } else {

                echo '<div id="heure">';

                echo $form->field($model, 'DUREE')->textInput(['type' => 'number','disabled'=>!($model->STATUT == 'E')]);

                echo '</div>';

            }

        }

        else {

            echo '<div id="jours">';

            echo '<label class="control-label">Date de départ</label>';

            $exo = \app\models\Exercice::findOne($model->ANNEEEXIGIBLE);


            echo DatePicker::widget([
                'model' => $model,
                'value' => $model->DATEDEBUT,
                'attribute' => 'DATEDEBUT',
                'language' => 'fr',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control input-sm', 'placeholder' => 'Choisir une date', 'disabled' => true],

            ]);

            echo '<br><label class="control-label">Date de fin</label>';


            echo DatePicker::widget([
                'model' => $model,
                'value' => $model->DATEFIN,
                'attribute' => 'DATEFIN',
                'language' => 'fr',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control input-sm', 'placeholder' => 'Choisir une date', 'disabled' => true],

            ]);

            echo '</div>';

        }

    }

    ?><br>

 <?php if($model->isNewRecord) echo $form->field($model, 'IMPUTERCONGES')->dropDownList([1=>"Oui",2=>"Non"],['prompt'=>'choisir']); else echo $form->field($model, 'IMPUTERCONGES')->dropDownList([1=>"Oui",2=>"Non"],['prompt'=>'choisir','disabled'=>!($model->STATUT == 'E')]); ?>

<?php if(!$model->isNewRecord) echo $form->field($model, 'STATUT')->dropDownList(["E"=>"Emise","A"=>"Annule","V"=>"Valide"],['disabled'=>'disabled']); ?>

  <?php if($model->isNewRecord) echo $form->field($model, 'COMMENTAIRE')->textarea(['rows' => 6]); else {  $form->field($model, 'COMMENTAIRE')->textarea(['rows' => 6,'disabled'=>!($model->STATUT == 'E')]); }  ?>

<?php if($model->isNewRecord) echo $form->field($model, 'DOCUMENTFILE')->fileInput()->label("DOCUMENT"); else { if($model->STATUT == 'E') echo $form->field($model, 'DOCUMENTFILE')->fileInput()->label("DOCUMENT"); $model->getDOC(); } ?>



    <div class="form-group">
        <?php
        
        if($model->isNewRecord) echo Html::submitButton('Enregistrer', ['class' => 'btn btn-success']);
        
        else {

            if($model->STATUT == "E") {

                echo Html::submitButton('Enregistrer', ['class' => 'btn btn-success'])." ";

                if($habilation->ADELETE == 1) echo Html::a('Valider',['absenceponctuel/valider','id'=>$model->ID_ABSENCE], ['class' => 'btn btn-primary'])." ". Html::a('Annuler',['absenceponctuel/annuler','id'=>$model->ID_ABSENCE], ['class' => 'btn btn-danger']);

            }



        }
        
        
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$lien2 = Yii::$app->getUrlManager()->createUrl('exercice/check');

$script = <<< JS

 
function myexo(){

    var exo = $("#exercice").val();
    
    
      $.ajax({
     url: "$lien2",
     data: {'exercice':exo},
        success: function(data) {
            var tab = data.split(":");

            console.log(tab[0]+" : "+tab[1]);
            
            $('#jour').kvDatepicker({"format": "yyyy-mm-dd", "startDate" : tab[0],"endDate" : tab[1] });
            
            $('#jour2').kvDatepicker({"format": "yyyy-mm-dd", "startDate" : tab[0],"endDate" : tab[1] });
            
         }
        });

}

function changement() {
    
    var option = $("#absenceponctuel-type_demande").val();
    
    if(option == 0) {
        
        $("#jours").css({'display':'block'});  $("#heure").css({'display':'none'}); 
         $("#absenceponctuel-datedebut").prop("required",true);
         $("#absenceponctuel-datefin").prop("required",true);
    }
    
    else if(option == 1) {
         $("#jours").css({'display':'none'});  $("#heure").css({'display':'block'}); 
         $("#absenceponctuel-datedebut").prop("required",false);
         $("#absenceponctuel-datefin").prop("required",false);
    }
    
    else {
         $("#jours").css({'display':'none'});  $("#heure").css({'display':'none'}); 
          $("#absenceponctuel-datedebut").prop("required",false);
         $("#absenceponctuel-datefin").prop("required",false);
    }
    
}

JS;

$this->registerJs($script,View::POS_END);

?>