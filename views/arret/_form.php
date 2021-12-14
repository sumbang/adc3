<?php

use app\models\Decisionconges;
use app\models\Habilitation;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Jouissance;
use app\models\Nature;
use app\models\Roles;
use app\models\Menus;
use yii\jui\DatePicker;
use yii\web\View;
use app\models\Employe;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Arret */
/* @var $form yii\widgets\ActiveForm */

$compte = \app\models\USER::findIdentity(Yii::$app->user->identity->IDUSER); $menu = "M11";

$habilation = Habilitation::find()->where(['CODEROLE'=>$compte->ROLE,'CODEMENU'=>$menu])->one();

?>

<div class="arret-form">

      <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php

    if($model->isNewRecord){

        $data = array();
        $query = "SELECT * FROM EMPLOYE WHERE STATUT = 1 "; $d = array();  $direction = "(";

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

        if(count($d) != 0) $query.=" AND MATRICULE IN $direction";

        $emps = Employe::findBySql($query)->orderBy(["NOM"=>SORT_ASC])->all();
        foreach ($emps as $emp) {
            $data[$emp->MATRICULE] = $emp->NOM . " " . $emp->PRENOM;
        }

        echo $form->field($model, 'employe')->widget(Select2::classname(), [
            'data' => $data,
            'language' => 'fr',
            'options' => [
                'placeholder' => 'Choisir une personne ...',
                'multiple' => false
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'pluginEvents' => [
                'change' => "function() { 
                                        
                    $(this).children(':selected').each(function(){
                                        
                    instancier();

                                        });
                                            
                                      }",
            ]
        ]);


    }

    ?>

    <?php  if ($model->isNewRecord) echo $form->field($model, 'JOUISSANCE')->dropDownList([],['prompt'=>'choisir']); else  echo $form->field($model, 'JOUISSANCE')->dropDownList(ArrayHelper::map(Jouissance::find()->where(['STATUT'=>'V'])->andWhere(['TYPES'=>['01','02']])->all(),"IDNATURE","NUMERO"),['prompt'=>'choisir','disabled'=>$model->isNewRecord?false:true])  ?>

    <?php

   /* echo '<label class="control-label">Date de debut</label>';
    echo DatePicker::widget([
        'model' => $model,
        'value' => $model->DATEDEBUT,
        'attribute' => 'DATEDEBUT',
        'language' => 'fr',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control input-sm','placeholder' => 'Choisir une date','required'=>true, 'disabled' => $model->isNewRecord?false:true],

    ]); */

    echo $form->field($model, 'DATEDEBUT')->textInput(['required' => true,'type'=>'date']);


    ?><br>



    <?php //$form->field($model, 'DATEFIN')->textInput(['type'=>'date']) ?>

    <?= $form->field($model, 'COMMENTAIRE')->textarea(['rows' => 6]) ?>

  <?= $form->field($model, 'DOCUMENTFILE')->fileInput()->label("DOCUMENT"); $model->getDOC(); ?>

    <div class="form-group">
    <?php
        
      echo Html::submitButton('Enregistrer', ['class' => 'btn btn-success']);
      
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

$lien = Yii::$app->getUrlManager()->createUrl('jouissance/checker2');

$script = <<< JS


function instancier() {
    
    var personne = $("#arret-employe").val(); 
    
    $("#arret-jouissance").html("");
    
       $.ajax({
            url: "$lien",
            data: {'personne':personne},
            success: function(data) {
                
            if(data != "" ) {
                
                var tab = JSON.parse(data);
                
                for (var i=0;i<tab.length;i++) {
                    
                     var options = '<option value="'+tab[i].id+'">Jouissance '+tab[i].libelle+' suspendu le '+tab[i].date2+' pour une période de '+tab[i].duree+' jour(s) </option>';
               
                      $("#arret-jouissance").append(options);   
                 }
               }
            }
        });

}

JS;

$this->registerJs($script,View::POS_END);

?>